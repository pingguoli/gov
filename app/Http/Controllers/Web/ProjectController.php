<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/20 16:56
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;

use App\Model\UserProject;
use Illuminate\Http\Request;

/**
 * 项目中心
 * Class ProjectController
 * @package App\Http\Controllers\Web
 */
class ProjectController extends BaseProjectController
{
    /**
     * 创建项目昵称页面
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create($code = null)
    {
        $userProject = $this->getUserProject($code);
        if ($userProject) {
            return redirect()->route('project', ['code' => $code]);
        }

        return frontendView('project.create', compact('code'));
    }

    /**
     * 保存新建昵称
     * @param Request $request
     * @param null $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveCreate(Request $request, $code = null)
    {
        $userProject = $this->getUserProject($code);
        if ($userProject) {
            return redirect()->route('project', ['code' => $code]);
        }

        $this->validate($request, [
            'name' => 'required|alpha_dash',
        ], [], [
            'name' => '昵称',
        ]);

        $name = $request->input('name');
        $user = $this->getUser();
        $project = $this->getProject($code);

        $hasName = UserProject::where('project_id', $project->id)->where('name', $name)->count();
        if ($hasName > 0) {
            return back()->withErrors(['name' => '昵称已存在'])->withInput();
        }
        $data = [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'name' => $name
        ];

        if (!UserProject::create($data)) {
            return back()->with('error', '新建失败')->withInput();
        }

        return redirect()->route('project', ['code' => $code])->with('success', '新建成功');
    }

    /**
     * 账号项目中心
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($code = null)
    {
        $userProject = $this->getUserProject($code);

        return frontendView('project.index', compact('code', 'userProject'));
    }
}