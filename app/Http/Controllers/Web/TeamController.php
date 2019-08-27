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

use App\Model\Team;
use App\Model\TeamRecord;
use App\Model\UserProject;
use App\Model\UserTeamRecord;
use App\Support\ChunkUpload;
use Illuminate\Http\Request;

/**
 * 战队
 * Class ProjectController
 * @package App\Http\Controllers\Web
 */
class TeamController extends BaseProjectController
{
    /**
     * 我的战队
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($code = null)
    {
        $userProject = $this->getUserProject($code);

        return frontendView('team.index', compact('code', 'userProject'));
    }

    /**
     * 创建战队
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create($code = null)
    {
        $userProject = $this->getUserProject($code);

        if ($userProject->team_id) {
            return redirect()->route('team', ['code' => $code])->with('error', "您已经在战队({$userProject->team->name}),无法创建战队");
        }

        return frontendView('team.create', compact('code', 'userProject'));
    }

    /**
     * 保存创建战队
     * @param Request $request
     * @param null $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveCreate(Request $request, $code = null)
    {
        $userProject = $this->getUserProject($code);

        if ($userProject->team_id) {
            return redirect()->route('team', ['code' => $code])->with('error', "您已经在战队({$userProject->team->name}),无法创建战队");
        }

        $this->validate($request, [
            'name' => 'required|min:1|max:50',
            'logo' => 'image',
        ], [], [
            'name' => '战队名称',
            'logo' => '战队LOGO',
        ]);

        $data = $request->only(['name']);

        if (Team::hasName($data['name'], $userProject->project_id)) {
            return back()->withErrors(['name' => '战队名称已存在'])->withInput();
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $uploader = new ChunkUpload();
            $filePath = $uploader->setType('image')->upload($file);
            if ($filePath === false) {
                return back()->withErrors(['logo' => '战队LOGO上传失败'])->withInput();
            }
            $data['logo'] = $filePath;
        }

        if (Team::add($userProject, $data)) {
            return redirect()->route('team', ['code' => $code])->with('success', '创建成功');
        }

        return back()->with('error', '创建失败')->withInput();
    }

    /**
     * 解散战队
     * @param Request $request
     * @param null $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disband(Request $request, $code = null)
    {
        $userProject = $this->getUserProject($code);

        if (!$userProject->team_id || $userProject->id != $userProject->team->user_project_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有战队队长才能解散战队');
        }

        // todo 解散操作

        return back()->with('error', '解算失败')->withInput();
    }

    /**
     * 战队邀请队员
     * @param Request $request
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function teamInvite(Request $request, $code = null)
    {
        $userProject = $this->getUserProject($code);

        if (!$userProject->team_id || $userProject->id != $userProject->team->user_project_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有战队队长才能邀请队员');
        }
        $query = $request->query('query');
        if (!empty($query)) {
            $list = UserProject::where('project_id', $userProject->project_id)->where('team_id', null)->where('name', 'like', '%' . $query . '%')->get();
        } else {
            $list = UserProject::where('project_id', $userProject->project_id)->where('team_id', null)->get();
        }

        return frontendView('team.team_invite', compact('code', 'userProject', 'list'));
    }

    /**
     * 邀请队员
     * @param null $code
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendTeamInvite($code = null, $id = null)
    {
        $userProject = $this->getUserProject($code);

        if (!$userProject->team_id || $userProject->id != $userProject->team->user_project_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有战队队长才能邀请队员');
        }

        $curUserProject = UserProject::find($id);
        if (!$curUserProject || $curUserProject->team_id || $curUserProject->project_id != $userProject->project_id) {
            return back()->with('error', '邀请失败')->withInput();
        }

        $data = [
            'user_project_id' => $curUserProject->id,
            'team_id' => $userProject->team_id,
        ];

        $hasInvite = UserTeamRecord::where('user_project_id', $curUserProject->id)
            ->where('team_id', $userProject->team_id)
            ->where('status', 0)->count();
        if ($hasInvite) {
            return back()->with('error', '已邀请')->withInput();
        }

        if (UserTeamRecord::create($data)) {
            return back()->with('error', '已发送邀请')->withInput();
        }

        return back()->with('error', '邀请失败')->withInput();
    }

    /**
     * 队员管理
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function manage($code = null)
    {
        $userProject = $this->getUserProject($code);

        if (!$userProject->team_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有加入战队才能管理队员');
        }
        $list = UserProject::where('project_id', $userProject->project_id)->where('team_id', $userProject->team_id)->paginate(config('site.other.paginate'));

        return frontendView('team.manage', compact('code', 'userProject', 'list'));
    }

    /**
     * 转让战队
     * @param null $code
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer($code = null, $id = null)
    {
        $userProject = $this->getUserProject($code);

        if (!$userProject->team_id || $userProject->id != $userProject->team->user_project_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有战队队长才能转让战队');
        }

        if ($userProject->id == $id) {
            return back()->with('error', '不能转让给自己')->withInput();
        }

        /**
         * @var $newUserProject UserProject
         */
        $newUserProject = UserProject::find($id);
        if (!$newUserProject || $newUserProject->team_id != $userProject->team_id) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if (Team::transfer($userProject->team_id, $newUserProject->id)) {
            return back()->with('success', '操作成功')->withInput();
        }

        return back()->with('error', '操作失败')->withInput();
    }

    /**
     * 踢出队员
     * @param null $code
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($code = null, $id = null)
    {
        $userProject = $this->getUserProject($code);

        if (!$userProject->team_id || $userProject->id != $userProject->team->user_project_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有战队队长才能移出队员');
        }

        if ($userProject->id == $id) {
            return back()->with('error', '不能移出自己')->withInput();
        }

        /**
         * @var $newUserProject UserProject
         */
        $newUserProject = UserProject::find($id);
        if (!$newUserProject || $newUserProject->team_id != $userProject->team_id) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($newUserProject->removeTeam()) {
            return back()->with('success', '操作成功')->withInput();
        }

        return back()->with('error', '操作失败')->withInput();
    }

    /**
     * 战队申请加入列表
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teamJoin($code = null)
    {
        $userProject = $this->getUserProject($code);
        if (!$userProject->team_id || $userProject->id != $userProject->team->user_project_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有战队队长才能管理申请');
        }

        $list = TeamRecord::where('team_id', $userProject->team_id)->paginate(config('site.other.paginate'));

        return frontendView('team.team_join', compact('code', 'userProject', 'list'));
    }

    /**
     * 战队确认申请或拒绝申请
     * @param Request $request
     * @param null $code
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmTeamJoin(Request $request, $code = null, $id = null)
    {
        $userProject = $this->getUserProject($code);

        if (!$userProject->team_id || $userProject->id != $userProject->team->user_project_id) {
            return redirect()->route('team', ['code' => $code])->with('error', '只有战队队长才能管理申请');
        }

        /**
         * @var $teamRecord TeamRecord
         */
        $teamRecord = TeamRecord::find($id);
        if (!$teamRecord || $teamRecord->team_id != $userProject->team_id) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        $joinUserProject = UserProject::find($teamRecord->user_project_id);
        if (empty($joinUserProject)) {
            return back()->with('error', '账号不存在')->withInput();
        }

        $status = $request->input('status');

        if ($status && $joinUserProject->team_id) {
            return back()->with('error', '您已经加入其它战队')->withInput();
        }

        if ($status) {
            if ($teamRecord->agree()) {
                return back()->with('success', '操作成功')->withInput();
            }
        } else {
            $teamRecord->status = TeamRecord::TYPE_REFUSE;
            if ($teamRecord->save()) {
                return back()->with('success', '操作成功')->withInput();
            }
        }

        return back()->with('error', '操作失败')->withInput();
    }

    /**
     * 加入战队列表
     * @param Request $request
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function join(Request $request, $code = null)
    {
        $userProject = $this->getUserProject($code);

        if ($userProject->team_id) {
            return redirect()->route('team', ['code' => $code])->with('error', "您已经在战队({$userProject->team->name})了");
        }
        $query = $request->query('query');
        if (!empty($query)) {
            $list = Team::where('project_id', $userProject->project_id)->where('name', 'like', '%' . $query . '%')->get();
        } else {
            $list = Team::where('project_id', $userProject->project_id)->get();
        }

        return frontendView('team.join', compact('code', 'userProject', 'list'));
    }

    /**
     * 发送申请加入战队
     * @param null $code
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendJoin($code = null, $id = null)
    {
        $userProject = $this->getUserProject($code);

        if ($userProject->team_id) {
            return redirect()->route('team', ['code' => $code])->with('error', "您已经在战队({$userProject->team->name})了");
        }

        $team = Team::find($id);
        if (!$team) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        $data = [
            'user_project_id' => $userProject->id,
            'team_id' => $team->id,
        ];

        $hasInvite = TeamRecord::where('user_project_id', $userProject->id)
            ->where('team_id', $team->id)
            ->where('status', 0)->count();
        if ($hasInvite) {
            return back()->with('error', '已申请')->withInput();
        }

        if (TeamRecord::create($data)) {
            return back()->with('error', '已发送申请')->withInput();
        }

        return back()->with('error', '申请失败')->withInput();
    }

    /**
     * 队员被邀请列表
     * @param null $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invite($code = null)
    {
        $userProject = $this->getUserProject($code);

        $list = UserTeamRecord::where('user_project_id', $userProject->id)->paginate(config('site.other.paginate'));

        return frontendView('team.invite', compact('code', 'userProject', 'list'));
    }

    /**
     * 队员确认申请或拒绝申请
     * @param Request $request
     * @param null $code
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmInvite(Request $request, $code = null, $id = null)
    {
        $userProject = $this->getUserProject($code);

        /**
         * @var $userTeamRecord UserTeamRecord
         */
        $userTeamRecord = UserTeamRecord::find($id);
        if (!$userTeamRecord || $userTeamRecord->user_project_id != $userProject->id) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        $status = $request->input('status');

        if ($status && $userProject->team_id) {
            return back()->with('error', '您已经加入其它战队')->withInput();
        }

        if ($status) {
            if ($userTeamRecord->agree()) {
                return back()->with('success', '操作成功')->withInput();
            }
        } else {
            $userTeamRecord->status = UserTeamRecord::TYPE_REFUSE;
            if ($userTeamRecord->save()) {
                return back()->with('success', '操作成功')->withInput();
            }
        }

        return back()->with('error', '操作失败')->withInput();
    }
}