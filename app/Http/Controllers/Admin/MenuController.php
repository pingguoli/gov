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

use App\Model\Menu;
use Illuminate\Http\Request;

/**
 * 菜单管理
 * Class MenuController
 * @package App\Http\Controllers\Admin
 */
class MenuController extends BaseController
{
    /**
     * 菜单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $menu = Menu::getTreeInfo();
        return backendView('menu.index', [
            'menu' => $menu
        ]);
    }

    /**
     * 新增菜单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'pid' => 'nullable|numeric',
                'title' => 'required|max:50',
                'name' => 'nullable|max:100',
                'url' => 'nullable|url|max:255',
                'icon' => 'nullable|max:100',
                'sort' => 'integer|min:0|max:999',
                'is_show' => 'required|numeric',
            ], [], [
                'pid' => __('Parent Menu'),
                'title' => __('Name'),
                'name' => __('Controller / method'),
                'url' => __('URL'),
                'icon' => __('Icon'),
                'sort' => __('Sort'),
                'is_show' => __('Is displayed as a menu'),
            ]);

            $data = $request->only(['pid', 'title', 'name', 'url', 'icon', 'sort', 'is_show']);

            if (Menu::create($data)) {
                return redirect()->route('admin.menu.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            $menuOptions = Menu::getOptions();
            return backendView('menu.add', ['menuOptions' => $menuOptions]);
        }
    }

    /**
     * 编辑菜单
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $menu Menu
         */
        $menu = Menu::find($id);
        if (empty($menu)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'pid' => 'nullable|numeric',
                'title' => 'required|max:50',
                'name' => 'nullable|max:100',
                'url' => 'nullable|url|max:255',
                'icon' => 'nullable|max:100',
                'sort' => 'integer|min:0|max:999',
                'is_show' => 'required|numeric',
            ], [], [
                'pid' => __('Parent Menu'),
                'title' => __('Name'),
                'name' => __('Controller / method'),
                'url' => __('URL'),
                'icon' => __('Icon'),
                'sort' => __('Sort'),
                'is_show' => __('Is displayed as a menu'),
            ]);

            $data = $request->only(['pid', 'title', 'name', 'url', 'icon', 'sort', 'is_show']);

            if ($menu->update($data)) {
                return redirect()->route('admin.menu.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $menuOptions = Menu::getOptions($menu);
            return backendView('menu.edit', ['menuOptions' => $menuOptions, 'menu' => $menu]);
        }
    }

    /**
     * 查看菜单
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view($id = null)
    {
        /**
         * @var $menu Menu
         */
        $menu = Menu::find($id);
        if (empty($menu)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        return backendView('menu.view', ['menu' => $menu]);
    }

    /**
     * 删除菜单
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = null)
    {
        /**
         * @var $menu Menu
         */
        $menu = Menu::find($id);
        if (empty($menu)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        try {
            $count = Menu::where('pid', $menu->id)->count();
            if ($count > 0) {
                return back()->with('error', __('Containing submenu cannot be deleted'));
            }

            if ($menu->delete()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }
}
