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
 * Class Project
 * @package App\Model
 */
class Project extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'name', 'type_id'];

    /**
     * 项目类型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ProjectType::class);
    }
}
