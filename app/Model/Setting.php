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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * 系统设置
 * Class Setting
 * @package App\Model
 */
class Setting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['section', 'key', 'value'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 缓存设置文件
     */
    const CACHE_SETTING_FILE = 'settings_cache';

    /**
     * 取出一组
     *
     * @param string $section
     * @return mixed
     */
    public static function getSection($section = 'site')
    {
        return static::where(['section' => $section])->pluck('value', 'key')->toArray();
    }

    /**
     * 保存设置
     *
     * @param $data
     * @param string $section
     * @return bool
     */
    public static function setSetting($data, $section = 'site')
    {
        DB::beginTransaction();
        try {
            foreach ($data as $key => $value) {
                static::updateOrCreate(['section' => $section, 'key' => $key], ['value' => is_string($value) || is_numeric($value) ? $value : '']);
            }

            DB::commit();
            static::clearCache();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            static::clearCache();
            return false;
        }
    }

    /**
     * 清除缓存
     */
    public static function clearCache()
    {
        Cache::forget(self::CACHE_SETTING_FILE);

        return true;
    }

    /**
     * 获取所有设置
     *
     * @return mixed
     */
    public static function getSetting()
    {

        $settings = Cache::get(self::CACHE_SETTING_FILE);

        if (App::environment('production') && $settings) {
            return $settings;
        }

        $settings = static::get();

        if (App::environment('production')) {
            $expiredAt = now()->addMinutes(config('site.cache.expired', 10));
            Cache::put(self::CACHE_SETTING_FILE, $settings, $expiredAt);
        }

        return $settings;
    }

    /**
     * 加载系统设置
     */
    public static function loadSetting()
    {
        try {
            $config = [];
            foreach (static::getSetting() as $item) {
                if ($item->value === '' || $item->value === null) {
                    continue;
                }
                $lastKey = str_replace(':', '.', $item->key);
                $key = "{$item->section}.{$lastKey}";
                $config[$key] = $item->value;
            }

            config($config);
        } catch (\Exception $e) {

        }
    }
}
