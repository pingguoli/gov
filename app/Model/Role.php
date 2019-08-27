<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 角色管理
 * 角色类型说明:
 * 0 为系统类型账号可选择角色
 * 1 为平台类型账号可选择角色
 * 2 为项目类型账号可选择角色
 * Class Role
 * @package App\Model
 */
class Role extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'type'];

    /**
     * 授权
     * @param $data
     * @return bool
     */
    public function savePermission($data)
    {
        DB::beginTransaction();
        try {
            if (!$this) {
                throw new \Exception('');
            }
            /* 删除角色所有权限 */
            $this->rolePermissions()->delete();
            $permissions = [];
            if (!empty($data['permissions']) && is_array($data['permissions'])) {
                foreach ($data['permissions'] as $permissionId) {
                    $permissions[] = [
                        'permission_id' => $permissionId
                    ];
                }
                /* 添加权限 */
                $this->rolePermissions()->createMany($permissions);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 获取权限
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * 获取权限关联表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    /**
     * 获取权限ID
     * @return array
     */
    public function permissionIds()
    {
        $ids = [];
        $list = $this->rolePermissions()->get();
        foreach ($list as $item) {
            $ids[] = $item->permission_id;
        }

        return $ids;
    }

    /**
     * 获取类型状态
     * @return string
     */
    public function getType()
    {
        $status = [
            Admin::TYPE_DEFAULT => '系统',
            Admin::TYPE_PLATFORM => '平台',
            Admin::TYPE_PROJECT => '项目',
        ];

        return array_key_exists($this->type, $status) ? $status[$this->type] : '-';
    }

    /**
     * 获取权限类型
     * @return array
     */
    public function getPermissionType()
    {
        switch ($this->type) {
            case Admin::TYPE_DEFAULT:
                return Admin::PERMISSION_SUPPER;
                break;
            case Admin::TYPE_PLATFORM:
                return Admin::PERMISSION_PLATFORM;
                break;
            case Admin::TYPE_PROJECT:
                return Admin::PERMISSION_PROJECT;
                break;
        }

        return [-1];
    }
}
