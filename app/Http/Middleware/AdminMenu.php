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

use App\Model\Menu;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * 菜单和菜单权限验证
 * Class AdminMenu
 * @package App\Http\Middleware
 */
class AdminMenu
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
        if (Auth::guard('admin')->check()) {
            /*已登录后权限验证以及全局菜单*/

            /**
             * @var $currentAdmin \App\Model\Admin
             */
            $currentAdmin = Auth::guard('admin')->user();

            $action = Route::currentRouteAction();
            $menuName = $currentAdmin->getAbility($action);

            /* 当前菜单 */
            $currentMenu = Menu::where('name', $menuName)->first();
            view()->share('currentMenu', $currentMenu);

            /* 面包屑 */
            $breadcrumb = Menu::getBreadcrumb($currentMenu);
            view()->share('breadcrumb', $breadcrumb);

            /* 所有菜单 */
            $menusTree = Menu::getAuthTreeInfo($currentAdmin, $currentMenu);
            view()->share('menusTree', $menusTree);
        }

        return $next($request);
    }
}
