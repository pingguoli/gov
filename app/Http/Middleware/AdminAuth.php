<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * 后台登录验证和访问权限验证
 * Class AdminAuth
 * @package App\Http\Middleware
 */
class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->guest()) {
            /* 未登录页面跳转到登录页面 */
            return redirect()->route('admin.login');
        } else {
            /* 验证用户状态 */
            /**
             * @var $currentAdmin \App\Model\Admin
             */
            $currentAdmin = Auth::guard('admin')->user();
            /* 未开启退出账号 */
            if (empty($currentAdmin->status)) {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login');
            }

            view()->share('currentAdmin', $currentAdmin);

            // 权限验证
            $action = Route::currentRouteAction();
            $status = $currentAdmin->deny($action);
            if ($status) {
                return back()->with('error', __('No authority'));
            }
        }

        return $next($request);
    }
}
