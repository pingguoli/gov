<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 文章类别关系
 * Class CategoryArticle
 * @package App\Model
 */
class CategoryArticle extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['category_id', 'article_id'];
}
