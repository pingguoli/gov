<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/25 14:07
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Team;
use Illuminate\Http\Request;

/**
 * 战队管理
 * Class TeamController
 * @package App\Http\Controllers\Admin
 */
class TeamController extends BaseController
{
    /**
     * 战队列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $admin = $this->getAdmin();
        if ($admin->isSystem()) {
            $lists = Team::orderBy('created_at', 'desc')->paginate(config('site.other.paginate'));
        } else {
            $lists = Team::where('project_id', $admin->project_id)->orderBy('created_at', 'desc')->paginate(config('site.other.paginate'));
        }
        return backendView('team.index', compact('lists'));
    }

    /**
     * 审核战队
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request, $id = null)
    {
        /**
         * @var $team Team
         */
        $team = Team::find($id);
        if (empty($team)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        $this->allow('allow', $team);

        if (!($team->status >= 0 && $team->status <= 1)) {
            return back()->with('error', '暂不能审核');
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'verify' => 'required',
            ], [], [
                'verify' => '',
            ]);
            $verify = $request->input('verify');
            $verify = $verify ? 2 : -1;

            if ($team->update(['status' => $verify])) {
                return redirect()->route('admin.team.index')->with('success', '审核成功');
            }

            return back()->with('error', '审核失败')->withInput();

        } else {
            return backendView('team.verify', compact('team'));
        }
    }

    /**
     * 查看战队
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function view($id = null)
    {
        /**
         * @var $team Team
         */
        $team = Team::find($id);
        if (empty($team)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        $this->allow('allow', $team);

        return backendView('team.view', compact('team'));
    }
}