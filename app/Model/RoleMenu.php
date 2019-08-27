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

/**
 * 角色菜单关联表
 * Class RoleMenu
 * @package App\Model
 */
class RoleMenu extends Model
{
    /**
     * @var string
     */
    protected $table = 'roles_menus';

    /**
     * @var array
     */
    protected $fillable = ['role_id', 'menu_id'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $touches = ['role'];

    /**
     * 角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
