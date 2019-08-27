<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/25 14:20
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Policies;


use App\Model\Admin;
use App\Model\Team;

/**
 * 战队验证策略
 * Class TeamPolicy
 * @package App\Policies
 */
class TeamPolicy
{
    /**
     * 验证是否可以操作
     * @param Admin $admin
     * @param Team $model
     * @return bool
     */
    public function allow(Admin $admin, Team $model)
    {
        return $admin->isSystem() || $admin->type == Admin::TYPE_PROJECT && $admin->project_id == $model->project_id;
    }
}