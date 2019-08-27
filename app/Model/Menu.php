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
 * Class Menu
 * @package App\Model
 */
class Menu extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['pid', 'title', 'name', 'url', 'icon', 'sort', 'is_show'];

    /**
     * 获取选择选项
     * @param Menu|null $menu
     * @param string $startStr
     * @param string $repeatStr
     * @return array|\Illuminate\Support\Collection
     */
    public static function getOptions(Menu $menu = null, $startStr = '|', $repeatStr = '--')
    {
        $sourceArray = static::get();
        $targetCollect = collect();

        foreach ($sourceArray as $entry) {
            if ($entry->pid == 0 && ($menu === null || $menu->id != $entry->id)) {
                $targetCollect[] = $entry;
                foreach ($sourceArray as $sonMenu) {
                    if ($sonMenu->pid == $entry->id && ($menu === null || $menu->id != $sonMenu->id)) {
                        $sonMenu->title = $startStr . $repeatStr . $sonMenu->title;
                        $targetCollect[] = $sonMenu;
                        foreach ($sourceArray as $thirdMenu) {
                            if ($thirdMenu->pid == $sonMenu->id && ($menu === null || $menu->id != $thirdMenu->id)) {
                                $thirdMenu->title = $startStr . $repeatStr . $repeatStr . $thirdMenu->title;
                                $targetCollect[] = $thirdMenu;
                            }
                        }
                    }
                }
            }
        }

        return $targetCollect;
    }

    /**
     * 获取所有菜单树
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
     * 根据数据获取菜单树
     * @param $sourceArray
     * @param int $pid
     * @return array
     */
    public static function getTree($sourceArray, $pid = 0)
    {
        $targetArray = [];
        foreach ($sourceArray as $v) {
            if ($v['pid'] == $pid) {
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
     * 根据权限获取菜单
     * @param Admin $user
     * @param Menu|null $menu
     * @return array
     */
    public static function getAuthTreeInfo(Admin $user, Menu $menu = null)
    {
        $sourceArray = static::get()->toArray();
        $targetArray = static::getAuthTree($sourceArray, 0, $user, $menu);

        return $targetArray;
    }

    /**
     * 根据数据获取菜单树
     * @param $sourceArray
     * @param int $pid
     * @param Admin|null $user
     * @param Menu|null $menu
     * @return array
     */
    public static function getAuthTree($sourceArray, $pid = 0, Admin $user = null, Menu $menu = null)
    {
        $targetArray = [];
        foreach ($sourceArray as $v) {
            $v['active'] = false;
            if ($v['pid'] == $pid && ($user === null || $user->allow($v['name']))) {
                $children = static::getAuthTree($sourceArray, $v['id'], $user, $menu);
                if (!empty($children)) {
                    foreach ($children as $key => $item) {
                        if ($item['active']) {
                            $v['active'] = true;
                        }
                        if (empty($item['is_show'])) {
                            unset($children[$key]);
                        }
                    }
                    if (!empty($children)) {
                        $v['children'] = $children;
                    }
                }

                if (!empty($v['children']) || !empty($v['name']) || !empty($v['url'])) {
                    if (!empty($menu) && !empty($v['name']) && $menu->name == $v['name']) {
                        $v['active'] = true;
                    }
                    $targetArray[] = $v;
                }
            }
        }

        return $targetArray;
    }

    /**
     * 获取面包屑(不包含本身)
     * @param Menu|null $menu
     * @return \Illuminate\Support\Collection
     */
    public static function getBreadcrumb(Menu $menu = null)
    {
        $list = [];

        while (!empty($menu->pid)) {
            $menu = Menu::find($menu->pid);
            if (!empty($menu)) {
                $list[] = $menu;
            }
        }

        $list = array_reverse($list);
        return collect($list);
    }

    /**
     * 获取父级菜单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'pid');
    }
}
