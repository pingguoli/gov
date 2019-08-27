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
 * 权限类型说明:
 * 0 为所有用户可选择权限
 * 1 为平台用户可选择权限
 * 2 为项目用户可选择权限
 * Class Permission
 * @package App\Model
 */
class Permission extends Model
{
    /**
     * 获取所有权限树
     * @param array|null $types
     * @return array
     */
    public static function getTreeInfo($types = null)
    {
        if ($types === null || !is_array($types) || empty($types)) {
            $sourceArray = static::get()->toArray();
        } else {
            $sourceArray = static::whereIn('type', $types)->get()->toArray();
        }
        $targetArray = static::getTree($sourceArray, 0);

        return $targetArray;
    }

    /**
     * 根据数据获取权限树
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
}
