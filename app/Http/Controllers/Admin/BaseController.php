<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/6 11:09
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseController
 * @package App\Http\Controllers\Admin
 */
abstract class BaseController extends Controller
{
    /**
     * @var Admin|null
     */
    private $_admin = null;

    /**
     * 设置管理员
     * @param $admin
     * @return $this
     */
    public function setAdmin($admin)
    {
        $this->_admin = $admin;
        return $this;
    }

    /**
     * @return Admin|null
     */
    public function getAdmin()
    {
        if ($this->_admin === null) {
            $currentAdmin = Auth::guard('admin')->user();
            $this->_admin = $currentAdmin;
        }

        return $this->_admin;
    }

    /**
     * 验证非权限下是否允许操作
     * @param $ability
     * @param Model $model
     * @return \Illuminate\Auth\Access\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function allow($ability, Model $model)
    {
        return $this->authorizeForUser($this->getAdmin(), $ability, $model);
    }

    /**
     * 权限验证
     * true有权限 false 无权限
     * @param $ability
     * @return bool
     */
    public function auth($ability)
    {
        $admin = $this->getAdmin();
        if (!$admin || $admin->deny($ability)) {
            return false;
        }
        return true;
    }
}