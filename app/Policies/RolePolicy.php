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
use App\Model\Role;

/**
 * 角色验证策略
 * Class AdminPolicy
 * @package App\Policies
 */
class RolePolicy
{
    /**
     * 验证是否可以操作
     * @param Admin $admin
     * @param Role $model
     * @return bool
     */
    public function allow(Admin $admin, Role $model)
    {
        return $admin->isSystem() || $admin->type == $model->type;
    }
}
