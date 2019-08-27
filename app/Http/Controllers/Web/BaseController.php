<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/6 11:09
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseController
 * @package App\Http\Controllers\Web
 */
abstract class BaseController extends Controller
{
    /**
     * @var User|null
     */
    private $_user = null;

    /**
     * 设置账号
     * @param $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->_user = $user;
        return $this;
    }

    /**
     * 获取账号
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Auth::user();
        }

        return $this->_user;
    }

    /**
     * 验证是否允许操作
     * @param $ability
     * @param Model $model
     * @return \Illuminate\Auth\Access\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function allow($ability, Model $model)
    {
        return $this->authorize($ability, $model);
    }
}