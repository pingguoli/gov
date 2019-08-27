<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/20 11:18
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;


use App\Model\Project;
use App\Model\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * 个人中心
 * Class MemberController
 * @package App\Http\Controllers\Web
 */
class MemberController extends BaseController
{
    /**
     * 个人中心(默认地址)
     */
    public function index()
    {
        $user = $this->getUser();

        return frontendView('member.index', compact('user'));
    }

    /**
     * 基本信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info()
    {
        $user = $this->getUser();

        return frontendView('member.info', compact('user'));
    }

    /**
     * 保存基本信息
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeInfo(Request $request)
    {
        return back()->with('error', '修改失败')->withInput();
    }

    /**
     * 密码修改
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password()
    {
        $user = $this->getUser();

        return frontendView('member.password', compact('user'));
    }

    /**
     * 保存修改密码
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $user = $this->getUser();

        $this->validate($request, [
            'orig_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ], [], [
            'orig_password' => '原密码',
            'password' => '新密码',
            'password_confirmation' => '确认密码',
        ]);

        $origPassword = $request->input('orig_password');
        if (!Hash::check($origPassword, $user->password)) {
            return back()->withErrors(['orig_password' => '原密码不正确'])->withInput();
        }

        $password = $request->input('password');
        $password = bcrypt($password);

        if ($user->update(['password' => $password])) {
            return redirect()->route('member.password')->with('success', '修改成功');
        }

        return back()->with('error', '修改失败')->withInput();
    }

    /**
     * 项目列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function project()
    {
        $user = $this->getUser();

        $projects = Project::get();

        $userProjects = UserProject::where('user_id', $user->id)->get();

        return frontendView('member.project', compact('user', 'projects', 'userProjects'));
    }

    /**
     * 账号绑定
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bind()
    {
        $user = $this->getUser();

        return frontendView('member.bind', compact('user'));
    }

    /**
     * 我的消息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message()
    {
        $user = $this->getUser();

        return frontendView('member.message', compact('user'));
    }
}