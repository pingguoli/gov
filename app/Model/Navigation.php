<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 导航
 * Class Navigation
 * @package App\Model
 */
class Navigation extends Model
{
    /**
     * 默认导航
     */
    const POSITION_DEFAULT = 0;

    /**
     * 顶部导航
     */
    const POSITION_TOP = 1;

    /**
     * 底部导航
     */
    const POSITION_BOTTOM = 2;

    /**
     * 顶部导航标记
     */
    const POSITION_TOP_FLAG = 'top';

    /**
     * 底部导航标记
     */
    const POSITION_BOTTOM_FLAG = 'bottom';

    /**
     * 链接
     */
    const TYPE_LINK = 1;

    /**
     * 分类
     */
    const TYPE_CATEGORY = 2;

    /**
     * 单页
     */
    const TYPE_PAGE = 3;

    /**
     * 文章
     */
    const TYPE_ARTICLE = 4;

    /**
     * 可以导航列表
     * @var array
     */
    public static $positions = [
        self::POSITION_DEFAULT => '默认导航',
        self::POSITION_TOP => '顶部导航',
        self::POSITION_BOTTOM => '底部导航',
    ];

    /**
     * 可以类型列表
     * @var array
     */
    public static $types = [
        self::TYPE_LINK => '链接',
        self::TYPE_CATEGORY => '分类',
        self::TYPE_PAGE => '单页',
//        self::TYPE_ARTICLE => '文章',
    ];

    /**
     * @var array
     */
    protected $fillable = ['parent_id', 'name', 'position', 'type', 'target', 'link', 'category_id', 'page_id', 'article_id', 'is_show', 'sort'];

    /**
     * 获取导航位置标记
     * @param string $flag
     * @return int
     */
    public static function getPositionCode($flag)
    {
        switch ($flag) {
            case self::POSITION_TOP_FLAG:
                return self::POSITION_TOP;
                break;
            case self::POSITION_BOTTOM_FLAG:
                return self::POSITION_BOTTOM;
                break;
            default:
                return self::POSITION_DEFAULT;
                break;
        }
    }

    /**
     * 获取类型名
     * @param $type
     * @return string
     */
    public static function getType($type)
    {
        return array_key_exists($type, self::$types) ? self::$types[$type] : '';
    }

    /**
     * 位置
     * @return string
     */
    public function getPosition()
    {
        return array_key_exists($this->position, self::$positions) ? self::$positions[$this->position] : '';
    }

    /**
     * 根据导航类型显示导航信息
     * @param $list
     * @return string
     */
    public static function showTypeVal($list)
    {
        if (is_array($list)) {
            if (!array_key_exists('type', $list)) {
                return '';
            }
            switch ($list['type']) {
                case self::TYPE_LINK:
                    return array_key_exists('link', $list) ? $list['link'] : '';
                    break;
                case self::TYPE_CATEGORY:
                    if (array_key_exists('category_id', $list)) {
                        $category = Category::find($list['category_id']);
                        if ($category) {
                            return $category->name;
                        }
                    }
                    break;
                case self::TYPE_PAGE:
                    if (array_key_exists('page_id', $list)) {
                        $page = Page::find($list['page_id']);
                        if ($page) {
                            return $page->title;
                        }
                    }
                    break;
                case self::TYPE_ARTICLE:
                    if (array_key_exists('article_id', $list)) {
                        $article = Article::find($list['article_id']);
                        if ($article) {
                            return $article->title;
                        }
                    }
                    break;
            }
        } else if ($list instanceof self) {
            switch ($list->type) {
                case self::TYPE_LINK:
                    return $list->link;
                    break;
                case self::TYPE_CATEGORY:
                    $category = Category::find($list->category_id);
                    if ($category) {
                        return $category->name;
                    }
                    break;
                case self::TYPE_PAGE:
                    $page = Page::find($list->page_id);
                    if ($page) {
                        return $page->title;
                    }
                    break;
                case self::TYPE_ARTICLE:
                    $article = Article::find($list->article_id);
                    if ($article) {
                        return $article->title;
                    }
                    break;
            }
        }

        return '';
    }

    /**
     * 获取选择选项
     * @param integer $position
     * @param Navigation|null $navigation
     * @param string $startStr
     * @param string $repeatStr
     * @return array|\Illuminate\Support\Collection
     */
    public static function getOptions($position = self::POSITION_DEFAULT, Navigation $navigation = null, $startStr = '|', $repeatStr = '--')
    {
        $sourceArray = static::where('position', $position)->get();
        $targetCollect = collect();

        foreach ($sourceArray as $entry) {
            if ($entry->parent_id == 0 && ($navigation === null || $navigation->id != $entry->id)) {
                $targetCollect[] = $entry;
                foreach ($sourceArray as $sonMenu) {
                    if ($sonMenu->parent_id == $entry->id && ($navigation === null || $navigation->id != $sonMenu->id)) {
                        $sonMenu->title = $startStr . $repeatStr . $sonMenu->title;
                        $targetCollect[] = $sonMenu;
                    }
                }
            }
        }

        return $targetCollect;
    }

    /**
     * 获取所有导航树
     * @param array $where
     * @return array
     */
    public static function getTreeInfo(Array $where = [])
    {
        $sourceArray = static::where($where)->get()->toArray();
        $targetArray = static::getTree($sourceArray, 0);

        return $targetArray;
    }

    /**
     * 根据数据获取导航树
     * @param $sourceArray
     * @param int $pid
     * @return array
     */
    public static function getTree($sourceArray, $pid = 0)
    {
        $targetArray = [];
        foreach ($sourceArray as $v) {
            if ($v['parent_id'] == $pid) {
                $children = static::getTree($sourceArray, $v['id']);
                if (!empty($children)) {
                    $v['children'] = $children;
                    $targetArray[] = $v;
                } else {
                    $targetArray[] = $v;
                }
            }
        }

        return $targetArray;
    }

    /**
     * 获取父级导航
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Navigation::class, 'parent_id');
    }
}
