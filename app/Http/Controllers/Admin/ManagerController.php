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
use App\Model\Project;
use App\Model\Role;
use App\Support\ChunkUpload;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * 管理员管理
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class ManagerController extends BaseController
{
    /**
     * 管理员列表
     */
    public function index()
    {
        $admin = $this->getAdmin();
        $manager = Admin::whereIn('type', $admin->getFilterType())->paginate(config('site.other.paginate'));
        $roles = Role::get();
        return backendView('manager.index', [
            'manager' => $manager,
            'roles' => $roles
        ]);
    }

    /**
     * 新增管理员
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $admin = $this->getAdmin();
        if ($request->isMethod('POST')) {

            $validate = [
                'username' => 'required|unique:admins|min:4|max:20|only_alpha_dash',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'nickname' => 'nullable|min:4|max:20',
                'real_name' => 'nullable|min:4|max:20',
                'id_card' => 'nullable|size:18',
                'email' => 'nullable|email',
                'mobile' => 'nullable|unique:admins|min:11|max:11',
                'address' => 'nullable|max:255',
                'img' => 'image',
                'roles' => 'required',
                'status' => 'required|numeric',
            ];

            if ($admin->isSystem()) {
                $validate['type'] = ['required', Rule::in(Admin::PERMISSION_SUPPER)];
            }

            $this->validate($request, $validate, [], [
                'username' => __('Account'),
                'password' => __('Password'),
                'password_confirmation' => __('Confirm Password'),
                'nickname' => __('Nickname'),
                'real_name' => __('Real name'),
                'id_card' => __('ID Card'),
                'email' => __('E-mail'),
                'mobile' => __('Mobile'),
                'address' => __('Address'),
                'img' => __('Img'),
                'roles' => __('Role'),
                'status' => __('Status'),
                'type' => __('Type'),
            ]);

            $data = $request->only(['username', 'password', 'nickname', 'real_name', 'id_card', 'email', 'mobile', 'address', 'type', 'project_id', 'roles', 'status']);
            $data['password'] = bcrypt($data['password']);
            if (!$admin->isSystem()) {
                $data['type'] = $admin->type;
            }

            if ($data['type'] == Admin::TYPE_PROJECT) {
                if (empty($data['project_id'])) {
                    return back()->withErrors(['project_id' => '项目必须选择'])->withInput();
                }
                $project = Project::find($data['project_id']);
                if (!$project || !$project->id) {
                    return back()->withErrors(['project_id' => '所选项目不存在'])->withInput();
                }
            } else {
                $data['project_id'] = 0;
            }

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $uploader = new ChunkUpload();
                $filePath = $uploader->setType('image')->upload($file);
                if ($filePath === false) {
                    return back()->withErrors(['img' => __('Img upload failed')])->withInput();
                }
                $data['img'] = $filePath;
            }

            if (Admin::add($data)) {
                return redirect()->route('admin.manager.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            if ($admin->isSystem()) {
                $type = old('type') ?: Admin::TYPE_DEFAULT;
                $roles = Role::where('type', $type)->get();
            } else {
                $roles = Role::where('type', $admin->type)->get();
            }
            $projects = Project::get();
            return backendView('manager.add', compact('roles', 'projects'));
        }
    }

    /**
     * 编辑管理员
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $user Admin
         */
        $user = Admin::find($id);
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        $this->allow('allow', $user);

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'password' => 'nullable|confirmed',
                'nickname' => 'nullable|min:4|max:20',
                'real_name' => 'nullable|min:4|max:20',
                'id_card' => 'nullable|size:18',
                'email' => 'nullable|email',
                'mobile' => ['nullable', Rule::unique('admins')->ignore($id), 'min:11', 'max:11'],
                'address' => 'nullable|max:255',
                'img' => 'image',
                'roles' => 'required',
                'status' => 'required|numeric',
            ], [], [
                'password' => __('Password'),
                'password_confirmation' => __('Confirm Password'),
                'nickname' => __('Nickname'),
                'real_name' => __('Real name'),
                'id_card' => __('ID Card'),
                'email' => __('E-mail'),
                'mobile' => __('Mobile'),
                'address' => __('Address'),
                'img' => __('Img'),
                'roles' => __('Role'),
                'status' => __('Status'),
            ]);

            if ($user->isSupperAdmin() && empty($request->input('status'))) {
                return back()->withErrors(['status' => __('System owner cannot shut down')])->withInput();
            }

            $data = $request->only(['password', 'nickname', 'real_name', 'id_card', 'email', 'mobile', 'address', 'roles', 'status', 'project_id']);
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            if ($user->type == Admin::TYPE_PROJECT) {
                if (empty($data['project_id'])) {
                    return back()->withErrors(['project_id' => '项目必须选择'])->withInput();
                }
                $project = Project::find($data['project_id']);
                if (!$project || !$project->id) {
                    return back()->withErrors(['project_id' => '所选项目不存在'])->withInput();
                }
            } else {
                $data['project_id'] = 0;
            }

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $uploader = new ChunkUpload();
                $filePath = $uploader->setType('image')->upload($file);
                if ($filePath === false) {
                    return back()->withErrors(['img' => __('Img upload failed')])->withInput();
                }
                $data['img'] = $filePath;
            }

            if ($user->edit($data)) {
                return redirect()->route('admin.manager.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $roles = Role::where('type', $user->type)->get();
            $projects = Project::get();
            return backendView('manager.edit', compact('user', 'roles', 'projects'));
        }
    }

    /**
     * 查看管理员
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function view($id = null)
    {
        /**
         * @var $user Admin
         */
        $user = Admin::find($id);
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        $this->allow('allow', $user);

        $roles = Role::where('type', $user->type)->get();
        return backendView('manager.view', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * 删除管理员
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id = null)
    {
        /**
         * @var $user Admin
         */
        $user = Admin::find($id);
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        $this->allow('allow', $user);

        $admin = $this->getAdmin();
        if ($admin && $admin->id == $user->id) {
            return back()->with('error', '无法删除当前管理员');
        }

        try {
            if ($user->isSupperAdmin()) {
                return back()->with('error', __('System owner cannot be deleted'));
            }
            if ($user->delete()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }

    /**
     * AJAX获取角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function role(Request $request)
    {
        $json = [
            'error' => 0,
            'message' => '',
            'list' => []
        ];

        $type = $request->get('type');
        if (!in_array($type, Admin::PERMISSION_SUPPER)) {
            $json['error'] = 1;
            $json['message'] = '您的请求不被允许,请刷新重试';
            return response()->json($json);
        }

        $roles = Role::where('type', $type)->get();

        $list = [];
        foreach ($roles as $item) {
            $list[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        $json['list'] = $list;

        return response()->json($json);
    }

}
