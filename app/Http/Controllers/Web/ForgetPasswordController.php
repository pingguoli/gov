<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/19 10:09
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;

use App\Model\SmsCode;
use App\Model\User;
use App\Support\AliyunSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * 忘记密码
 * Class ForgetPasswordController
 * @package App\Http\Controllers\Web
 */
class ForgetPasswordController extends BaseController
{
    /**
     * ForgetPasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 注册发送短信
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

            if (!SmsCode::send($mobile, $code, SmsCode::TYPE_FORGET_PASSWORD)) {
                $data = [
                    'error' => 1,
                    'message' => ''
                ];
                return response()->json($data);
            }

            return response()->json($data);
        }

        return redirect()->route('forget');
    }

    /**
     * 忘记密码页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return frontendView('forget.index');
    }

    /**
     * 忘记密码验证步骤
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveIndex(Request $request)
    {
        $validate = [
            'mobile' => 'required|min:11|max:11',
            'sms_code' => 'required',
        ];

        if (!empty(config('site.other.captcha'))) {
            $validate['captcha'] = 'required|captcha';
        }

        $this->validate($request, $validate, [], [
            'mobile' => __('Mobile'),
            'sms_code' => __('SMS Code'),
            'captcha' => __('Captcha')
        ]);

        $mobile = $request->input('mobile');

        // 验证短信验证码
        $smsCode = $request->input('sms_code');
        if (!SmsCode::verify($mobile, $smsCode, SmsCode::TYPE_FORGET_PASSWORD)) {
            return back()->withErrors(['sms_code' => __('SMS Verification Code incorrect or expired')])->withInput();
        }

        // 重新提交第一步时需要清除之前所有session信息
        $this->delSessionKey();

        $user = User::where('mobile', encryptStr($mobile))->where('is_complete', 1)->first();
        if (!$user || !$user->id) {
            return back()->with('error', '手机号不存在或未注册完成')->withInput();
        }

        $key = $this->encryptKey($user->code);
        return redirect()->route('forget.change', ['key' => $key]);
    }

    /**
     * 修改密码
     * @param Request $request
     * @param $key
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function change(Request $request, $key)
    {
        $code = $this->decryptKey($key);
        if (empty($code)) {
            return redirect()->route('forget')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        $user = User::where('code', $code)->where('is_complete', 1)->first();
        if (!$user || !$user->id) {
            return back()->with('error', __('Your request is not allowed. Please refresh and try again.'))->withInput();
        }

        $prev = route('forget');
        return frontendView('forget.change', compact('user', 'prev'));
    }

    /**
     * 保存修改密码
     * @param Request $request
     * @param $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveChange(Request $request, $key)
    {
        $id = $request->input('id');
        $code = $request->input('code');
        $mobile = $request->input('mobile');

        $hasCode = $this->decryptKey($key);
        if (empty($hasCode) || $hasCode != $code) {
            return redirect()->route('forget')->with('error', __('Your request is not allowed. Please refresh and try again.'));
        }

        /**
         * @var $user User
         */
        $user = User::where('mobile', encryptStr($mobile))->where('code', $code)->where('id', $id)->where('is_complete', 1)->first();
        if (!$user || !$user->id) {
            return back()->with('error', '修改失败')->withInput();
        }

        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ], [], [
            'password' => __('Password'),
            'password_confirmation' => __('Confirm Password'),
        ]);

        $data = $request->only(['password']);
        $data['password'] = bcrypt($data['password']);
        if (!$user->update($data)) {
            return back()->with('error', '修改失败')->withInput();
        }

        // 注册成功删除临时session
        $this->delSessionKey();

        return redirect()->route('login')->with('success', '修改成功');
    }

    /**
     * 加密访问key
     * @param $key
     * @return null|string
     */
    private function encryptKey($key)
    {
        if (!($encryptKey = $this->getSessionKey())) {
            $encryptKey = encryptTempStr($key);
            $this->setSessionKey($encryptKey);
        }

        return $encryptKey;
    }

    /**
     * 解密访问key
     * @param $key
     * @return bool|string
     */
    private function decryptKey($key)
    {
        $origKey = decryptTempStr($key);
        if (empty($origKey) || !($hasKey = $this->getSessionKey()) || $hasKey != $key) {
            return false;
        }

        return $origKey;
    }

    /**
     * 存储session信息
     * @param $value
     * @param bool $isCover
     */
    private function setSessionKey($value, $isCover = true)
    {
        if ($isCover || !Session::has('forget.key')) {
            Session::put('forget.key', $value);
        }
    }

    /**
     * 获取存储的session信息
     * @return null|string
     */
    private function getSessionKey()
    {
        if (Session::has('forget.key')) {
            return Session::get('forget.key');
        }

        return null;
    }

    /**
     * 删除存储的session信息
     */
    private function delSessionKey()
    {
        Session::forget('forget.key');
    }
}