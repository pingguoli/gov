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

use App\Model\Admin;
use App\Model\AdminRole;
use App\Model\Menu;
use App\Model\Permission;
use App\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * 角色管理
 * Class RoleController
 * @package App\Http\Controllers\Admin
 */
class RoleController extends BaseController
{
    /**
     * 角色列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $admin = $this->getAdmin();
        $roles = Role::whereIn('type', $admin->getFilterType())->paginate(config('site.other.paginate'));
        return backendView('role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * 添加角色
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {
            $admin = $this->getAdmin();

            $validate = [
                'name' => 'required|max:100',
            ];

            if ($admin->isSystem()) {
                $validate['type'] = ['required', Rule::in(Admin::PERMISSION_SUPPER)];
            }

            $this->validate($request, $validate, [], [
                'name' => __('Name'),
                'type' => __('Type'),
            ]);

            $data = $request->only(['name', 'type']);

            if (!$admin->isSystem()) {
                $data['type'] = $admin->type;
            }

            if (Role::create($data)) {
                return redirect()->route('admin.role.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            $menus = Menu::getTreeInfo();
            return backendView('role.add', compact('menus'));
        }
    }

    /**
     * 编辑角色
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $role Role
         */
        $role = Role::find($id);
        if (empty($role)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        $this->allow('allow', $role);

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'name' => 'required|max:100',
            ], [], [
                'name' => __('Name'),
            ]);

            $data = $request->only(['name']);

            if ($role->update($data)) {
                return redirect()->route('admin.role.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $menus = Menu::getTreeInfo();
            return backendView('role.edit', [
                'role' => $role,
                'menus' => $menus
            ]);
        }
    }

    /**
     * 授权
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function permission(Request $request, $id = null)
    {
        /**
         * @var $role Role
         */
        $role = Role::find($id);
        if (empty($role)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        $this->allow('allow', $role);

        if ($request->isMethod('POST')) {

            $data = $request->only(['permissions']);

            if ($role->savePermission($data)) {
                return redirect()->route('admin.role.index')->with('success', __('Permission success'));
            }

            return back()->with('error', __('Permission failed'))->withInput();

        } else {
            $permissions = Permission::getTreeInfo($role->getPermissionType());
            return backendView('role.permission', [
                'role' => $role,
                'permissions' => $permissions
            ]);
        }
    }

    /**
     * 查看角色
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function view($id = null)
    {
        /**
         * @var $role Role
         */
        $role = Role::find($id);
        if (empty($role)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        $this->allow('allow', $role);

        $permissions = Permission::getTreeInfo($role->getPermissionType());
        return backendView('role.view', ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * 删除角色
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id = null)
    {
        /**
         * @var $role Role
         */
        $role = Role::find($id);
        if (empty($role)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }
        $this->allow('allow', $role);

        try {
            $count = AdminRole::where('role_id', $role->id)->count();
            if ($count > 0) {
                return back()->with('error', __('The role of an existing administrator cannot be deleted'));
            }
            if ($role->delete()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }
}
