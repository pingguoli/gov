<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;

use App\Library\AdvancedRateLimiter;
use App\Model\Admin;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 后台登录页
 * Class LoginController
 * @package App\Http\Controllers\Admin
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
     * 登录页页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.index');
        }

        return backendView('login.index');
    }

    /**
     * 登录验证
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.index');
        }

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

        /* 登录验证 */
        $status = Auth::guard('admin')->attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'status' => 1
        ]);

        if ($status) {

            /* 清除错误次数 */
            $this->clearLoginAttempts($request);

            /**
             * 更新最后登录IP 和 时间
             * @var $user Admin
             */
            $user = Auth::guard('admin')->user();
            $user->timestamps = false;
            $user->last_login_ip = $request->ip();
            $user->last_login_time = time();
            $user->save();

            return redirect()->intended(route('admin.index'));
        }

        /* 增加错误次数 */
        $this->incrementLoginAttempts($request);

        return back()->with('error', __('Account, password error or Account shutdown'))->withInput();
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
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
