<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class LocaleController
 * @package App\Http\Controllers\Web
 */
class LocaleController extends Controller
{
    /**
     * 切换多语言
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lang($locale)
    {
        $languages = config('locale.languages');
        if (is_array($languages) && array_key_exists($locale, $languages)) {
            session()->put('locale', $locale);
        }

        return redirect()
            ->back()
            ->withInput();
    }
}
