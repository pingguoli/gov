<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/18 15:15
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
 * 项目类型
 * Class ProjectTypeController
 * @package App\Http\Controllers\Admin
 */
class ProjectTypeController extends BaseController
{
    /**
     * 项目类型列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lists = ProjectType::paginate(config('site.other.paginate'));
        return backendView('projecttype.index', compact('lists'));
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
                'name' => 'required|max:100',
            ], [], [
                'name' => __('Name'),
            ]);

            $data = $request->only(['name']);

            if (ProjectType::create($data)) {
                return redirect()->route('admin.project_type.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            return backendView('projecttype.add');
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
         * @var $projectType ProjectType
         */
        $projectType = ProjectType::find($id);
        if (empty($projectType)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'name' => 'required|max:100',
            ], [], [
                'name' => __('Name'),
            ]);

            $data = $request->only(['name']);

            if ($projectType->update($data)) {
                return redirect()->route('admin.project_type.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            return backendView('projecttype.edit', compact('projectType'));
        }
    }

    /**
     * 删除项目类型
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = null)
    {
        /**
         * @var $projectType ProjectType
         */
        $projectType = ProjectType::find($id);
        if (empty($projectType)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        try {
            $count = Project::where('type_id', $projectType->id)->count();
            if ($count > 0) {
                return back()->with('error', '已使用的类型不能删除');
            }
            if ($projectType->delete()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }
}