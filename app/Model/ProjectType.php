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
 * Class ProjectType
 * @package App\Model
 */
class ProjectType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];
}
