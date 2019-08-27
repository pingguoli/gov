<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Policies;

use App\Model\Admin;

/**
 * 后台用户权限验证策略
 * Class AdminPolicy
 * @package App\Policies
 */
class AdminPolicy
{
    /**
     * 验证权限
     * @param Admin $admin
     * @param Admin $model
     * @param null $permission
     * @return bool
     */
    public function auth(Admin $admin, Admin $model = null, $permission = null)
    {
        return $admin->checkPermission($permission);
    }

    /**
     * 验证是否可以操作
     * @param Admin $admin
     * @param Admin $model
     * @return bool
     */
    public function allow(Admin $admin, Admin $model)
    {
        return $admin->isSystem() || $admin->type == $model->type;
    }
}
