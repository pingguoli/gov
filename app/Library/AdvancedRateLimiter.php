<?php

namespace App\Library;

use Illuminate\Cache\RateLimiter;

/**
 * 登录频率限制器
 * 增加可以设置登录错误次数越多
 * 冻结时间越长
 * Class AdvancedRateLimiter
 * @package App\Library
 */
class AdvancedRateLimiter extends RateLimiter
{
    /**
     * 重写错误间隔时间
     * @param string $key
     * @param int|array $decayMinutes
     * @return int
     */
    public function hit($key, $decayMinutes = 1)
    {
        if (is_array($decayMinutes)) {
            if (!$this->cache->has($key . ':timer')) {
                if (!$this->cache->has($key . ':step')) {
                    $this->cache->add($key . ':step', 0, 1440);
                } else {
                    $this->cache->increment($key . ':step');
                }
            }
            $step = $this->cache->get($key . ':step', 0);
            $step = $step < count($decayMinutes) ? $step : count($decayMinutes) - 1;
            $decayMinutes = $decayMinutes[$step] ?: 1;
        }

        return parent::hit($key, $decayMinutes);
    }

    /**
     * 清除时同时清除步数
     * @param string $key
     */
    public function clear($key)
    {
        $this->cache->forget($key.':step');

        parent::clear($key);
    }
}