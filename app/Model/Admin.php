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

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * Class Admin
 * 管理员类型说明:
 * 0 为系统类型账号
 * 1 为平台类型账号
 * 2 为项目类型账号
 * @package App\Model
 */
class Admin extends Authenticatable
{
    /**
     * 记住我字段
     * @var string
     */
    protected $rememberTokenName = '';

    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'nickname', 'real_name', 'id_card', 'email', 'mobile', 'img', 'address', 'status', 'type', 'project_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * 默认类型(所有用户可用)
     */
    const TYPE_DEFAULT = 0;

    /**
     * 平台类型
     */
    const TYPE_PLATFORM = 1;

    /**
     * 项目类型
     */
    const TYPE_PROJECT = 2;

    /**
     * 超级管理员权限
     */
    const PERMISSION_SUPPER = [
        self::TYPE_DEFAULT,
        self::TYPE_PLATFORM,
        self::TYPE_PROJECT,
    ];

    /**
     * 平台管理员权限
     */
    const PERMISSION_PLATFORM = [
        self::TYPE_DEFAULT,
        self::TYPE_PLATFORM,
    ];

    /**
     * 项目管理员权限
     */
    const PERMISSION_PROJECT = [
        self::TYPE_DEFAULT,
        self::TYPE_PROJECT,
    ];

    /**
     * 添加管理员
     * @param $data
     * @return bool
     */
    public static function add($data)
    {
        DB::beginTransaction();
        try {
            /* 添加角色 */
            $adminModel = Admin::create($data);
            if (!$adminModel) {
                throw new \Exception('');
            }

            $roles = [];
            if (!empty($data['roles']) && is_array($data['roles'])) {
                foreach ($data['roles'] as $roleId) {
                    $roles[] = [
                        'role_id' => $roleId
                    ];
                }
                /* 添加权限 */
                $adminModel->adminRoles()->createMany($roles);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 编辑管理员
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        DB::beginTransaction();
        try {
            if (!$this) {
                throw new \Exception('');
            }
            /* 编辑角色 */
            $this->update($data);

            /* 删除角色所有权限 */
            $this->adminRoles()->delete();
            $roles = [];
            if (!empty($data['roles']) && is_array($data['roles'])) {
                foreach ($data['roles'] as $roleId) {
                    $roles[] = [
                        'role_id' => $roleId
                    ];
                }
                /* 添加权限 */
                $this->adminRoles()->createMany($roles);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 判断是否是系统账号
     * @return bool
     */
    public function isSystem()
    {
        return $this->isSupperAdmin() || $this->type == self::TYPE_DEFAULT;
    }

    /**
     * 判断是否是超级管理员(创始人)
     * @return bool
     */
    public function isSupperAdmin()
    {
        return $this->getAuthIdentifier() == 1;
    }

    /**
     * 是否允许访问
     * @param $ability
     * @return bool
     */
    public function allow($ability)
    {
        return $this->can('auth', [$this, $ability]);
    }

    /**
     * 是否拒绝访问
     * @param $ability
     * @return bool
     */
    public function deny($ability)
    {
        return !$this->can('auth', [$this, $ability]);
    }

    /**
     * 后台权限验证
     * 一般给AdminPolicy使用
     * 提供 allow 和 deny 方法
     * @param $ability
     * @return bool
     */
    public function checkPermission($ability)
    {
        /* 超级管理员一直返回有权限 */
        if ($this->isSupperAdmin()) {
            return true;
        }

        if (empty($ability)) {
            return true;
        }

        // 处理验证控制器方法字符串
        $ability = $this->getAbility($ability);

        // 检查是否有权限验证
        $count = Permission::where('name', $ability)->count();
        if ($count == 0) {
            return true;
        }

        // 获取权限验证返回
        $types = [];
        switch ($this->type) {
            case self::TYPE_DEFAULT:
                $types = self::PERMISSION_SUPPER;
                break;
            case self::TYPE_PLATFORM:
                $types = self::PERMISSION_PLATFORM;
                break;
            case self::TYPE_PROJECT:
                $types = self::PERMISSION_PROJECT;
                break;
            default:
                return false;
        }

        /* 获取角色 */
        $roles = $this->roles;
        if (!$roles) {
            return false;
        }
        foreach ($roles as $role) {
            // 验证角色是否与管理员类型一致
            if ($this->type == $role->type) {
                $permissions = $role->permissions;
                if ($permissions) {
                    foreach ($permissions as $permission) {
                        // 验证类型是否允许并且名称是否一致
                        if (in_array($permission->type, $types) && strtolower($permission->name) == strtolower($ability)) {
                            return true;
                        }
                    }
                }
            }

        }

        return false;
    }


    /**
     * 获取验证权限的key
     * @param $ability
     * @return string
     */
    public function getAbility($ability)
    {
        /* 通过Controller验证拆分验证权限字符串 */
        $ability = trim($ability, '\\');
        $idx = strrpos($ability, '\\');
        $ability = $idx === false ? $ability : substr($ability, $idx + 1);

        $has = strpos($ability, '@');
        if ($has === false) {
            if (($strIdx = strripos($ability, 'controller')) !== false) {
                $ruleStr = substr($ability, 0, $strIdx);
            } else {
                $ruleStr = $ability;
            }
        } else {
            $before = substr($ability, 0, $has);
            $after = substr($ability, $has + 1);
            if (($beforeIdx = strripos($before, 'controller')) !== false) {
                $before = substr($ability, 0, $beforeIdx);
            }
            $ruleStr = $before . '/' . $after;
        }

        return strtolower($ruleStr);
    }

    /**
     * 添加多对多模型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_roles');
    }

    /**
     * 获取角色关联表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adminRoles()
    {
        return $this->hasMany(AdminRole::class);
    }

    /**
     * 获取项目信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 获取角色ID
     * @return array
     */
    public function roleIds()
    {
        $ids = [];
        $list = $this->adminRoles()->get();
        foreach ($list as $item) {
            $ids[] = $item->role_id;
        }

        return $ids;
    }

    /**
     * 获取用户状态
     * @return string
     */
    public function getStatus()
    {
        $status = [
            0 => __('Close'),
            1 => __('Open'),
        ];

        return array_key_exists($this->status, $status) ? $status[$this->status] : '-';
    }

    /**
     * 转换时间戳
     * @param $value
     * @return false|string
     */
    public function getLastLoginTimeAttribute($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
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

        return array_key_exists($this->type, $status) ? $status[$this->type] : '';
    }

    /**
     * 获取列表显示的类型
     * @return array
     */
    public function getFilterType()
    {
        if ($this->isSupperAdmin()) {
            return [
                self::TYPE_DEFAULT,
                self::TYPE_PLATFORM,
                self::TYPE_PROJECT,
            ];
        }
        switch ($this->type) {
            case self::TYPE_DEFAULT:
                return [
                    self::TYPE_DEFAULT,
                    self::TYPE_PLATFORM,
                    self::TYPE_PROJECT,
                ];
                break;
            case self::TYPE_PLATFORM:
                return [
                    self::TYPE_PLATFORM,
                ];
                break;
            case self::TYPE_PROJECT:
                return [
                    self::TYPE_PROJECT,
                ];
                break;
        }

        return [-1];
    }

    /**
     * 获取权限类型状态
     * @return string
     */
    public function getPermissionType()
    {
        $status = [
            Admin::TYPE_DEFAULT => '系统',
            Admin::TYPE_PLATFORM => '平台',
            Admin::TYPE_PROJECT => '项目',
        ];

        return array_key_exists($this->type, $status) ? $status[$this->type] : '';
    }
}
