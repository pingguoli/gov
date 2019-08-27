<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;

use App\Library\AdvancedRateLimiter;
use App\Model\SmsCode;
use App\Model\User;
use App\Support\AliyunSms;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * @package App\Http\Controllers\Web
 */
class LoginController extends BaseController
{
    use ThrottlesLogins;

    /**
     * 最多错误次数
     * @var int
     */
    protected $maxAttempts = 3;

    /**
     * 错误间隔时间(分钟)
     * @var int
     */
    protected $decayMinutes = [1, 3, 10, 60, 600];

    /**
     * 正常登录(用户名密码)
     */
    const LOGIN_NORMAL = 1;

    /**
     * 短信验证码登录
     */
    const LOGIN_SMS = 2;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 登录页页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return frontendView('login.index');
    }

    /**
     * 登录验证
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {
            case self::LOGIN_NORMAL:
                return $this->_normalLogin($request);
                break;
            case self::LOGIN_SMS:
                return $this->_smsLogin($request);
                break;
        }

        return back()->with('error', __('Your request is not allowed. Please refresh and try again.'))->withInput();
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * 登录发送短信
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sendSms(Request $request)
    {
        if ($request->ajax()) {
            $data = [
                'error' => 0,
                'message' => ''
            ];

            $mobile = $request->input('mobile');
            if (empty($mobile)) {
                $data = [
                    'error' => 1,
                    'message' => __('validation.required', ['attribute' => __('Mobile')])
                ];
                return response()->json($data);
            }

            $user = User::where('mobile', encryptStr($mobile))->where('is_complete', 1)->first();
            if (!$user || !$user->id) {
                $data = [
                    'error' => 1,
                    'message' => '手机号不存在或未注册完成'
                ];
                return response()->json($data);
            }

            $code = geneSmsCode();
            $aliyunSms = new AliyunSms();
            if (!$aliyunSms->send($mobile, $code)) {
                $data = [
                    'error' => 1,
                    'message' => __('Send failed, please try again later')
                ];
                return response()->json($data);
            }

            if (!SmsCode::send($mobile, $code, SmsCode::TYPE_LOGIN)) {
                $data = [
                    'error' => 1,
                    'message' => ''
                ];
                return response()->json($data);
            }

            return response()->json($data);
        }

        return redirect()->route('login');
    }

    /**
     * 正常登录(账号密码登录)
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function _normalLogin(Request $request)
    {
        $validate = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!empty(config('site.other.captcha'))) {
            $validate['captcha'] = 'required|captcha';
        }

        $this->validate($request, $validate, [], [
            'username' => __('Account'),
            'password' => __('Password'),
            'captcha' => __('Captcha'),
        ]);

        /* 错误次数验证 */
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );

            return back()->with('error', __('auth.throttle', ['seconds' => $seconds]))->withInput();
        }
        $isRemember = $request->input('remember', null);

        $username = $request->input('username');
        $key = 'mobile';
        if (strpos($username, '@') !== false) {
            $key = 'email';
        } else if (strlen($username) > '11') {
            $key = 'id_card';
        }

        /* 登录验证 */
        $status = Auth::attempt([
            $key => encryptStr($username),
            'password' => $request->input('password'),
            'is_complete' => 1
        ], $isRemember);

        if ($status) {

            /* 清除错误次数 */
            $this->clearLoginAttempts($request);

            /**
             * 更新最后登录IP 和 时间
             * @var $user User
             */
            $user = Auth::user();
            $user->timestamps = false;
            $user->last_login_ip = $request->ip();
            $user->last_login_time = time();
            $user->save();

            return redirect()->intended(route('member'));
        }

        /* 增加错误次数 */
        $this->incrementLoginAttempts($request);

        return back()->with('error', __('Account, password error or Account shutdown'))->withInput();
    }

    /**
     * 短信登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function _smsLogin(Request $request)
    {
        $validate = [
            'mobile' => 'required',
            'sms_code' => 'required',
        ];

        if (!empty(config('site.other.captcha'))) {
            $validate['captcha'] = 'required|captcha';
        }

        $this->validate($request, $validate, [], [
            'mobile' => '手机号',
            'sms_code' => __('Sms Code'),
            'captcha' => __('Captcha'),
        ]);

        /* 错误次数验证 */
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );

            return back()->with('error', __('auth.throttle', ['seconds' => $seconds]))->withInput();
        }

        $isRemember = $request->input('remember', null);
        $mobile = $request->input('mobile');

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->first();
        if (!$user) {
            /* 增加错误次数 */
            $this->incrementLoginAttempts($request);
            return back()->with('error', '用户不存在')->withInput();
        }

        // 验证短信验证码
        $smsCode = $request->input('sms_code');
        if (!SmsCode::verify($mobile, $smsCode, SmsCode::TYPE_LOGIN)) {
            return back()->withErrors(['sms_code' => __('SMS Verification Code incorrect or expired')])->withInput();
        }

        // 登录
        Auth::login($user, $isRemember);

        /* 清除错误次数 */
        $this->clearLoginAttempts($request);

        /**
         * 更新最后登录IP 和 时间
         * @var $user User
         */
        $user->timestamps = false;
        $user->last_login_ip = $request->ip();
        $user->last_login_time = time();
        $user->save();

        return redirect()->intended(route('member'));
    }

    /**
     * 更改高级设置登录错误次数
     * @return \Illuminate\Foundation\Application|mixed
     */
    protected function limiter()
    {
        return app(AdvancedRateLimiter::class);
    }

    /**
     * 这是错误验证的用户名
     * @return string
     */
    protected function username()
    {
        return 'username';
    }
}
