<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * 多语言切换
 * Class Locale
 * @package App\Http\Middleware
 */
class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $languages = config('locale.languages');
        view()->share('languages', $languages);

        if (Session::has('locale') && is_array($languages) && array_key_exists(Session::get('locale'), $languages)) {
            App::setLocale(Session::get('locale'));
            view()->share('currentLang', Session::get('locale'));
        } else {
            App::setLocale(config('locale.default'));
            view()->share('currentLang', config('locale.default'));
        }

        return $next($request);
    }
}
