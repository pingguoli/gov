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
use Illuminate\Support\Facades\Storage;

/**
 * Class File
 * @package App\Model
 */
class File extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['type', 'disk', 'path', 'mime', 'hash', 'title', 'size', 'width', 'height'];

    /**
     * 文件类型
     * @var array
     */
    public static $types = [
        'image', // 图片
        'voice', // 语音
        'video', // 视频
        'annex', // 附件
        'file'   // 文件
    ];

    /**
     * 检查文件是否存在
     * @param $hash
     * @return bool
     */
    public static function hashExists($hash)
    {
        $count = self::where('hash', $hash)->count();
        return $count ? true : false;
    }

    /**
     * 获取文件物理地址
     * @param $hash
     * @return bool|string
     */
    public static function getFilePathByHash($hash)
    {
        $file = self::where('hash', $hash)->first();
        if (empty($file) || empty($file->id)) {
            return false;
        }
        if (Storage::disk($file->disk)->exists($file->path)) {
            return Storage::disk($file->disk)->path($file->path);
        }

        return false;
    }

    /**
     * 判断文件是否存在
     * @param $hash
     * @return bool
     */
    public static function hasFile($hash)
    {
        if (!self::hashExists($hash)) {
            return false;
        }

        $file = self::where('hash', $hash)->first();
        if (empty($file) || empty($file->id)) {
            return false;
        }

        return Storage::disk($file->disk)->exists($file->path);
    }

    /**
     * 获取图片 url 地址
     * @param $hash
     * @param string $default
     * @return string
     */
    public static function getFileUrl($hash, $default = '')
    {
        if (!self::hashExists($hash)) {
            return $default;
        }

        $file = self::where('hash', $hash)->first();
        if (empty($file) || empty($file->id)) {
            return $default;
        }

        return Storage::disk($file->disk)->url($file->path);
    }
}
