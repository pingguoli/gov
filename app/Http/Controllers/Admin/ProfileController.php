<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/6 17:16
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Admin;
use App\Support\ChunkUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Admin
 */
class ProfileController extends BaseController
{
    /**
     * 个人中心
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $this->getAdmin();
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'));
        }
        $title = '个人中心';

        return backendView('profile.index', compact('user', 'title'));
    }

    /**
     * 编辑个人中心
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        /**
         * @var $user Admin
         */
        $user = $this->getAdmin();
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'nickname' => 'nullable|min:4|max:20',
                'real_name' => 'nullable|min:4|max:20',
                'id_card' => 'nullable|size:18',
                'email' => 'nullable|email',
                'mobile' => ['nullable', Rule::unique('admins')->ignore($user->id), 'min:11', 'max:11'],
                'address' => 'nullable|max:255',
                'img' => 'image',
            ], [], [
                'nickname' => __('Nickname'),
                'real_name' => __('Real name'),
                'id_card' => __('ID Card'),
                'email' => __('E-mail'),
                'mobile' => __('Mobile'),
                'address' => __('Address'),
                'img' => __('Img'),
            ]);

            $data = $request->only(['nickname', 'real_name', 'id_card', 'email', 'mobile', 'address']);

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $uploader = new ChunkUpload();
                $filePath = $uploader->setType('image')->upload($file);
                if ($filePath === false) {
                    return back()->withErrors(['img' => __('Img upload failed')])->withInput();
                }
                $data['img'] = $filePath;
            }

            if ($user->update($data)) {
                return redirect()->route('admin.profile')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $title = '编辑个人中心';
            return backendView('profile.edit', compact('user', 'title'));
        }
    }

    /**
     * 更改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function password(Request $request)
    {
        /**
         * @var $user Admin
         */
        $user = $this->getAdmin();
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'orig_password' => 'required',
                'password' => 'required|confirmed',
            ], [], [
                'orig_password' => '原密码',
                'password' => __('Password'),
                'password_confirmation' => __('Confirm Password'),
            ]);

            $origPassword = $request->input('orig_password');
            if (!Hash::check($origPassword, $user->password)) {
                return back()->withErrors(['orig_password' => '原密码不正确'])->withInput();
            }

            $password = $request->input('password');
            $password = bcrypt($password);

            if ($user->update(['password' => $password])) {
                return redirect()->route('admin.profile.password')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $title = '更改密码';
            return backendView('profile.password', compact('user', 'title'));
        }
    }
}