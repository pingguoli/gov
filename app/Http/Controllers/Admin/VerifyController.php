<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/18 9:34
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Admin;
use App\Model\Project;
use App\Model\Verify;
use Illuminate\Http\Request;

/**
 * 审核设置管理
 * Class VerifyController
 * @package App\Http\Controllers\Admin
 */
class VerifyController extends BaseController
{
    /**
     * 审核设置列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $settings = Verify::paginate(config('site.other.paginate'));
        return backendView('verify.index', compact('settings'));
    }

    /**
     * 新增审核设置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {

            $validate = [
                'type' => 'required',
                'admin_id' => 'required',
            ];

            $this->validate($request, $validate, [], [
                'type' => __('Type'),
                'admin_id' => '管理员',
            ]);

            $data = $request->only(['type', 'project_id', 'admin_id']);

            // 验证类型
            if (empty($data['type'])) {
                return back()->withErrors(['type' => __('validation.required', ['attribute' => __('Type')])])->withInput();
            }
            if (!array_key_exists($data['type'], Verify::$types)) {
                return back()->withErrors(['type' => __('validation.in', ['attribute' => __('Type')])])->withInput();
            }

            if (in_array($data['type'], Verify::$projectSome)) {
                // 项目多个设置每个类型只能设置一个
                if (empty($data['project_id'])) {
                    return back()->withErrors(['project_id' => __('validation.required', ['attribute' => '项目'])])->withInput();
                }

                if (Verify::where('type', $data['type'])->where('project_id', $data['project_id'])->count() > 0) {
                    return back()->withErrors(['project_id' => '只能设置一次'])->withInput();
                }

            } else {
                // 每个类型只能设置一个

                if (Verify::where('type', $data['type'])->count() > 0) {
                    return back()->withErrors(['type' => '只能设置一次'])->withInput();
                }

                $data['project_id'] = 0;
            }

            if (Verify::create($data)) {
                return redirect()->route('admin.verify.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            $projects = Project::get();
            $type = old('type');
            if ($type === null || !in_array($type, Verify::$projectSome)) {
                $managers = Admin::whereIn('type', Admin::PERMISSION_PLATFORM)->get();
            } else {
                $projectId = old('project_id');
                if (empty($projectId)) {
                    $managers = Admin::where('type', Admin::TYPE_DEFAULT)->get();
                } else {
                    $managers = Admin::where([
                        ['type', '=', Admin::TYPE_PROJECT],
                        ['project_id', '=', $projectId],
                    ])->orWhere('type', Admin::TYPE_DEFAULT)->get();
                }
            }
            return backendView('verify.add', compact('projects', 'managers'));
        }
    }

    /**
     * 编辑审核设置
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $verify Verify
         */
        $verify = Verify::find($id);
        if (empty($verify)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $validate = [
                'type' => 'required',
                'admin_id' => 'required',
            ];

            $this->validate($request, $validate, [], [
                'type' => __('Type'),
                'admin_id' => '管理员',
            ]);

            $data = $request->only(['type', 'project_id', 'admin_id']);

            // 验证类型
            if (empty($data['type'])) {
                return back()->withErrors(['type' => __('validation.required', ['attribute' => __('Type')])])->withInput();
            }
            if (!array_key_exists($data['type'], Verify::$types)) {
                return back()->withErrors(['type' => __('validation.in', ['attribute' => __('Type')])])->withInput();
            }

            if (in_array($data['type'], Verify::$projectSome)) {
                // 项目多个设置每个类型只能设置一个
                if (empty($data['project_id'])) {
                    return back()->withErrors(['project_id' => __('validation.required', ['attribute' => '项目'])])->withInput();
                }

                if (Verify::where('type', $data['type'])->where('project_id', $data['project_id'])->where('id', '<>', $verify->id)->count() > 0) {
                    return back()->withErrors(['project_id' => '只能设置一次'])->withInput();
                }

            } else {
                // 每个类型只能设置一个

                if (Verify::where('type', $data['type'])->where('id', '<>', $verify->id)->count() > 0) {
                    return back()->withErrors(['type' => '只能设置一次'])->withInput();
                }

                $data['project_id'] = 0;
            }

            if ($verify->update($data)) {
                return redirect()->route('admin.verify.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $projects = Project::get();
            $type = old('type') === null ? $verify->type : old('type');
            $projectId = old('project_id') === null ? $verify->project_id : old('project_id');
            if ($type === null || !in_array($type, Verify::$projectSome)) {
                $managers = Admin::whereIn('type', Admin::PERMISSION_PLATFORM)->get();
            } else {
                if (empty($projectId)) {
                    $managers = Admin::where('type', Admin::TYPE_DEFAULT)->get();
                } else {
                    $managers = Admin::where([
                        ['type', '=', Admin::TYPE_PROJECT],
                        ['project_id', '=', $projectId],
                    ])->orWhere('type', Admin::TYPE_DEFAULT)->get();
                }
            }
            return backendView('verify.edit', compact('verify', 'projects', 'managers'));
        }
    }

    /**
     * 获取管理员
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function manager(Request $request)
    {
        $json = [
            'status' => 200,
            'message' => '',
            'errors' => [],
            'lists' => []
        ];
        $admin = $this->getAdmin();
        if (!$admin || ($admin->deny('verify/add') && $admin->deny('verify/edit'))) {
            return response()->json($json);
        }

        $data = $request->only(['type', 'project_id']);

        // 验证类型
        if (!empty($data['type']) && !array_key_exists($data['type'], Verify::$types)) {
            $json['status'] = 422;
            $json['errors']['type'] = __('validation.in', ['attribute' => __('Type')]);
            return response()->json($json);
        }

        if (empty($data['type']) || !in_array($data['type'], Verify::$projectSome)) {
            $managers = Admin::whereIn('type', Admin::PERMISSION_PLATFORM)->get();
        } else {
            if (empty($data['project_id'])) {
                $managers = Admin::where('type', Admin::TYPE_DEFAULT)->get();
            } else {
                $managers = Admin::where([
                    ['type', '=', Admin::TYPE_PROJECT],
                    ['project_id', '=', $data['project_id']],
                ])->orWhere('type', Admin::TYPE_DEFAULT)->get();
            }
        }

        $lists = [];
        foreach ($managers as $item) {
            $lists[$item->id] = $item->nickname ?: $item->username;
        }
        $json['lists'] = $lists;

        return response()->json($json);
    }
}