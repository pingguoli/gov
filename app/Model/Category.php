<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 文章类别
 * Class Category
 * @package App\Model
 */
class Category extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];
}
