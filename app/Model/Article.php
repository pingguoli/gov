<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 文章
 * Class Article
 * @package App\Model
 */
class Article extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'subtitle', 'keywords', 'description', 'author', 'source', 'content', 'thumb', 'sort', 'views', 'top', 'status'];

    /**
     * 添加文章
     * @param $data
     * @return bool
     */
    public static function add($data)
    {
        DB::beginTransaction();
        try {
            /* 添加文章 */
            $article = self::create($data);
            if (!$article) {
                throw new \Exception('3');
            }

            /* 删除分类 */
            CategoryArticle::where('article_id', $article->id)->delete();
            if (!empty($data['categories']) && is_array($data['categories'])) {
                foreach ($data['categories'] as $categoryId) {
                    if (empty($categoryId)) {
                        continue;
                    }
                    $list = [
                        'category_id' => $categoryId,
                        'article_id' => $article->id
                    ];

                    /* 增加分类 */
                    if (!CategoryArticle::create($list)) {
                        throw new \Exception('');
                    }
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 编辑文章
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
            /* 编辑文章 */
            $this->update($data);

            /* 删除分类 */
            CategoryArticle::where('article_id', $this->id)->delete();
            if (!empty($data['categories']) && is_array($data['categories'])) {
                foreach ($data['categories'] as $categoryId) {
                    if (empty($categoryId)) {
                        continue;
                    }
                    $list = [
                        'category_id' => $categoryId,
                        'article_id' => $this->id
                    ];

                    /* 增加分类 */
                    if (!CategoryArticle::create($list)) {
                        throw new \Exception('');
                    }
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 删除文章
     * @return bool
     */
    public function remove()
    {
        DB::beginTransaction();
        try {
            if (!$this) {
                throw new \Exception('');
            }


            /* 删除分类 */
            CategoryArticle::where('article_id', $this->id)->delete();
            /* 删除文章 */
            $this->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 获取分类ID
     * @return array
     */
    public function categoryIds()
    {
        $ids = [];
        $list = $this->articleCategories()->get();
        foreach ($list as $item) {
            $ids[] = $item->category_id;
        }

        return $ids;
    }

    /**
     * 获取文章分类关联表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleCategories()
    {
        return $this->hasMany(CategoryArticle::class);
    }

    /**
     * 获取是否置顶
     * @return string
     */
    public function getTop()
    {
        $status = [
            0 => __('No'),
            1 => __('Yes'),
        ];

        return array_key_exists($this->top, $status) ? $status[$this->top] : '';
    }

    /**
     * 获取状态
     * @return string
     */
    public function getStatus()
    {
        $status = [
            0 => __('Close'),
            1 => __('Open'),
        ];

        return array_key_exists($this->status, $status) ? $status[$this->status] : '';
    }
}
