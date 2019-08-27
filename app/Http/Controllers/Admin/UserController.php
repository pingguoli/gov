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

use App\Model\File;
use App\Model\User;
use App\Model\UserHistory;
use App\Model\Verify;
use App\Support\Enum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends BaseController
{
    /**
     * 账号列表
     */
    public function index()
    {
        $users = User::paginate(config('site.other.paginate'));
        return backendView('user.index', [
            'users' => $users
        ]);
    }

    /**
     * 编辑账号
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $user User
         */
        $user = User::find($id);
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if (empty($user->is_complete)) {
            return back()->with('error', '未注册完成不可编辑')->withInput();
        }

        $currentAdmin = $this->getAdmin();
        $verifyManager = Verify::getVerifyAdmin();

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'password' => 'nullable|confirmed',
                'nickname' => 'required|min:1|max:50',
                'name' => 'required|min:1|max:50',
                'id_card' => 'required|size:18',
                'sex' => 'required|numeric',
                'email' => 'required|email',
                'mobile' => 'required|min:11|max:11',
                'birthday' => 'required|min:1|max:50',
                'nationality' => 'required|min:1|max:50',
                'address' => 'required|max:255',
                'education' => 'required|numeric',
                'img' => 'required',
                'id_card_type' => 'required',
                'type' => 'required'
            ], [], [
                'password' => __('Password'),
                'nickname' => __('Nickname'),
                'name' => __('Username'),
                'id_card' => __('ID Card'),
                'sex' => __('Sex'),
                'email' => __('E-mail'),
                'mobile' => __('Mobile'),
                'birthday' => __('Birthday'),
                'nationality' => __('Nationality'),
                'address' => __('Address'),
                'education' => __('Education'),
                'img' => '照片',
                'id_card_type' => '证件类型',
                'type' => __('Type')
            ]);

            $data = $request->only(['nickname', 'password', 'name', 'id_card', 'sex', 'email', 'mobile', 'birthday', 'nationality', 'address', 'education',
                'type', 'img', 'id_card_type', 'id_card_face', 'id_card_nation', 'house_img', 'passport_img', 'current_password', 'verify_password']);

            // 验证身份证号码
            if (User::hasIdCard($data['id_card'], $id)) {
                return back()->withErrors(['id_card' => __('validation.unique', ['attribute' => __('ID Card')])])->withInput();
            }
            // 验证邮箱
            if (User::hasEmail($data['email'], $id)) {
                return back()->withErrors(['email' => __('validation.unique', ['attribute' => __('E-mail')])])->withInput();
            }
            // 验证国籍
            if (!array_key_exists($data['nationality'], Enum::$nationality)) {
                return back()->withErrors(['nationality' => __('validation.in', ['attribute' => __('Nationality')])])->withInput();
            }
            // 验证学历
            if (!array_key_exists($data['education'], Enum::$education)) {
                return back()->withErrors(['education' => __('validation.in', ['attribute' => __('Education')])])->withInput();
            }

            if (empty($data['img']) || !File::hashExists($data['img'])) {
                return back()->withErrors(['img' => '照片不存在'])->withInput();
            }

            // 验证证件类型
            if (empty($data['id_card_type']) || !in_array($data['id_card_type'], [1, 2, 3])) {
                return back()->withErrors(['id_card_type' => __('validation.in', ['attribute' => '证件类型'])])->withInput();
            }

            // 根据证件类型验证证件
            switch ($data['id_card_type']) {
                case 1:
                    if (empty($data['id_card_face']) || !File::hashExists($data['id_card_face'])) {
                        return back()->withErrors(['id_card_face' => '身份证头像面不存在'])->withInput();
                    }
                    if (empty($data['id_card_nation']) || !File::hashExists($data['id_card_nation'])) {
                        return back()->withErrors(['id_card_nation' => '身份证国徽面不存在'])->withInput();
                    }
                    unset($data['house_img']);
                    unset($data['passport_img']);
                    break;
                case 2:
                    if (empty($data['house_img']) || !File::hashExists($data['house_img'])) {
                        return back()->withErrors(['house_img' => '户口照片不存在'])->withInput();
                    }
                    unset($data['id_card_face']);
                    unset($data['id_card_nation']);
                    unset($data['passport_img']);
                    break;
                case 3:
                    if (empty($data['passport_img']) || !File::hashExists($data['passport_img'])) {
                        return back()->withErrors(['id_card_face' => '护照照片不存在'])->withInput();
                    }
                    unset($data['id_card_face']);
                    unset($data['id_card_nation']);
                    unset($data['house_img']);
                    break;
            }

            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            // 验证当前密码
            if (empty($data['current_password'])) {
                return back()->with('error', '当前账号密码必须填写')->withInput();
            }
            if (!Hash::check($data['current_password'], $currentAdmin->password)) {
                return back()->with('error', '当前账号密码不正确')->withInput();
            }

            if (empty($data['verify_password'])) {
                return back()->with('error', '审核管理员密码必须填写')->withInput();
            }
            if (!$verifyManager) {
                return back()->with('error', '请先设置审核管理员')->withInput();
            }

            if (!Hash::check($data['verify_password'], $verifyManager->password)) {
                return back()->with('error', '审核管理员密码不正确')->withInput();
            }

            if ($user->edit($data, $currentAdmin)) {
                return redirect()->route('admin.user.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $notice = '未设置审核管理员无法保存';
            return backendView('user.edit', compact('user', 'verifyManager', 'notice'));
        }
    }

    /**
     * 验证编辑
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request, $id = null)
    {
        $json = [
            'status' => 200,
            'message' => '',
            'errors' => [],
            'changes' => []
        ];
        $admin = $this->getAdmin();
        if (!$admin || $admin->deny('user/edit')) {
            return response()->json($json);
        }
        /**
         * @var $user User
         */
        $user = User::find($id);
        if (empty($user)) {
            $json['status'] = 481;
            $json['message'] = __('The page you requested was not found');
            return response()->json($json);
        }

        if (empty($user->is_complete)) {
            $json['status'] = 481;
            $json['message'] = '未注册完成不可编辑';
            return response()->json($json);
        }

        $this->validate($request, [
            'password' => 'nullable|confirmed',
            'nickname' => 'required|min:1|max:50',
            'name' => 'required|min:1|max:50',
            'id_card' => 'required|size:18',
            'sex' => 'required|numeric',
            'email' => 'required|email',
            'mobile' => 'required|min:11|max:11',
            'birthday' => 'required|min:1|max:50',
            'nationality' => 'required|min:1|max:50',
            'address' => 'required|max:255',
            'education' => 'required|numeric',
            'img' => 'required',
            'id_card_type' => 'required',
            'type' => 'required'
        ], [], [
            'password' => __('Password'),
            'nickname' => __('Nickname'),
            'name' => __('Username'),
            'id_card' => __('ID Card'),
            'sex' => __('Sex'),
            'email' => __('E-mail'),
            'mobile' => __('Mobile'),
            'birthday' => __('Birthday'),
            'nationality' => __('Nationality'),
            'address' => __('Address'),
            'education' => __('Education'),
            'img' => '照片',
            'id_card_type' => '证件类型',
            'type' => __('Type')
        ]);

        $data = $request->only(['nickname', 'password', 'name', 'id_card', 'sex', 'email', 'mobile', 'birthday', 'nationality', 'address', 'education',
            'type', 'img', 'id_card_type', 'id_card_face', 'id_card_nation', 'house_img', 'passport_img']);

        // 验证身份证号码
        if (User::hasIdCard($data['id_card'], $id)) {
            $json['status'] = 422;
            $json['errors']['id_card'] = __('validation.unique', ['attribute' => __('ID Card')]);
            return response()->json($json);
        }
        // 验证邮箱
        if (User::hasEmail($data['email'], $id)) {
            $json['status'] = 422;
            $json['errors']['email'] = __('validation.unique', ['attribute' => __('E-mail')]);
            return response()->json($json);
        }
        // 验证国籍
        if (!array_key_exists($data['nationality'], Enum::$nationality)) {
            $json['status'] = 422;
            $json['errors']['nationality'] = __('validation.in', ['attribute' => __('Nationality')]);
            return response()->json($json);
        }
        // 验证学历
        if (!array_key_exists($data['education'], Enum::$education)) {
            $json['status'] = 422;
            $json['errors']['education'] = __('validation.in', ['attribute' => __('Education')]);
            return response()->json($json);
        }

        if (empty($data['img']) || !File::hashExists($data['img'])) {
            $json['status'] = 422;
            $json['errors']['img'] = '照片不存在';
            return response()->json($json);
        }

        // 验证证件类型
        if (empty($data['id_card_type']) || !in_array($data['id_card_type'], [1, 2, 3])) {
            $json['status'] = 422;
            $json['errors']['id_card_type'] = __('validation.in', ['attribute' => '证件类型']);
            return response()->json($json);
        }

        switch ($data['id_card_type']) {
            case 1:
                if (empty($data['id_card_face']) || !File::hashExists($data['id_card_face'])) {
                    $json['status'] = 422;
                    $json['errors']['id_card_face'] = '身份证头像面不存在';
                    return response()->json($json);
                }
                if (empty($data['id_card_nation']) || !File::hashExists($data['id_card_nation'])) {
                    $json['status'] = 422;
                    $json['errors']['id_card_nation'] = '身份证国徽面不存在';
                    return response()->json($json);
                }
                unset($data['house_img']);
                unset($data['passport_img']);
                break;
            case 2:
                if (empty($data['house_img']) || !File::hashExists($data['house_img'])) {
                    $json['status'] = 422;
                    $json['errors']['house_img'] = '户口照片不存在';
                    return response()->json($json);
                }
                unset($data['id_card_face']);
                unset($data['id_card_nation']);
                unset($data['passport_img']);
                break;
            case 3:
                if (empty($data['passport_img']) || !File::hashExists($data['passport_img'])) {
                    $json['status'] = 422;
                    $json['errors']['id_card_face'] = '护照照片不存在';
                    return response()->json($json);
                }
                unset($data['id_card_face']);
                unset($data['id_card_nation']);
                unset($data['house_img']);
                break;
        }
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $changes = $user->changeList($data);
        if ($changes !== false) {
            $json['changes'] = $changes;
        }

        return response()->json($json);
    }

    /**
     * 查看账号
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view($id = null)
    {
        /**
         * @var $user User
         */
        $user = User::find($id);
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        return backendView('user.view', compact('user'));
    }

    /**
     * 修改历史列表
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function history($id = null)
    {
        /**
         * @var $user User
         */
        $user = User::find($id);
        if (empty($user)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        $histories = UserHistory::where('user_id', $user->id)->orderBy('history_time', 'desc')->paginate(config('site.other.paginate'));

        return backendView('user.history', compact('user', 'histories'));
    }

    /**
     * 查看修改历史
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function detail($id = null)
    {
        if (!$this->auth('user/history')) {
            return back()->with('error', __('No authority'));
        }
        /**
         * @var $history UserHistory
         */
        $history = UserHistory::find($id);
        if (empty($history)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        $user = User::find($history->user_id);

        $historyTime = strtotime($history->history_time);

        $afterHistory = UserHistory::where('user_id', $history->user_id)->where('history_time', '>', $historyTime)->orderBy('history_time', 'asc')->first();

        return backendView('user.detail', compact('user', 'history', 'afterHistory'));
    }
}
