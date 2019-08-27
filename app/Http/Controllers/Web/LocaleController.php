<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
