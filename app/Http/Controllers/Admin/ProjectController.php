<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/18 15:33
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Project;
use App\Model\ProjectType;
use Illuminate\Http\Request;

/**
 * 项目管理
 * Class ProjectController
 * @package App\Http\Controllers\Admin
 */
class ProjectController extends BaseController
{
    /**
     * 项目列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lists = Project::paginate(config('site.other.paginate'));
        return backendView('project.index', compact('lists'));
    }

    /**
     * 添加项目类型
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'code' => 'required|only_alpha_num|unique:projects|max:100',
                'name' => 'required|max:100',
                'type_id' => 'required',
            ], [], [
                'code' => '唯一标识',
                'name' => __('Name'),
                'type_id' => '项目类型',
            ]);

            $data = $request->only(['name', 'code', 'type_id']);

            if (Project::create($data)) {
                return redirect()->route('admin.project.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            $projectTypes = ProjectType::get();
            return backendView('project.add', compact('projectTypes'));
        }
    }

    /**
     * 编辑项目类型
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $project Project
         */
        $project = Project::find($id);
        if (empty($project)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'name' => 'required|max:100',
                'type_id' => 'required',
            ], [], [
                'name' => __('Name'),
                'type_id' => '项目类型',
            ]);

            $data = $request->only(['name', 'type_id']);

            if ($project->update($data)) {
                return redirect()->route('admin.project.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $projectTypes = ProjectType::get();
            return backendView('project.edit', compact('project', 'projectTypes'));
        }
    }
}