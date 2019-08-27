<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use Illuminate\Http\Request;

/**
 * 系统设置
 * Class SettingController
 * @package App\Http\Controllers\Admin
 */
class SettingController extends BaseController
{
    /**
     * 基础设置组名
     */
    const OWNER_BASE = 'app';

    /**
     * 站点设置组名
     */
    const OWNER_SITE = 'site';

    /**
     * 系统设置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function app(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'log_max_files' => 'nullable|integer|min:0',
            ], [], [
                'log_max_files' => __('Number of log files retained'),
            ]);

            $data = $request->only(['debug', 'log_level', 'log_max_files']);

            if (Setting::setSetting($data, self::OWNER_BASE)) {
                return redirect()->route('admin.setting.app')->with('success', __('Set up success'));
            }

            return back()->with('error', __('Set up failed'))->withInput();

        } else {
            $setting = Setting::getSection(self::OWNER_BASE);
            return backendView('setting.app', [
                'setting' => $setting
            ]);
        }
    }

    /**
     * 站点设置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function site(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'other:paginate' => 'nullable|integer|min:1',
            ], [], [
                'other:paginate' => __('Page number'),
            ]);

            $data = $request->only(['base:name', 'base:icp', 'base:copyright', 'base:address', 'base:telephone', 'base:email', 'seo:title', 'seo:keywords', 'seo:description', 'other:captcha', 'other:paginate']);

            if (Setting::setSetting($data, self::OWNER_SITE)) {
                return redirect()->route('admin.setting.site')->with('success', __('Set up success'));
            }

            return back()->with('error', __('Set up failed'))->withInput();

        } else {
            $setting = Setting::getSection(self::OWNER_SITE);
            return backendView('setting.site', [
                'setting' => $setting
            ]);
        }
    }

    /**
     * 登录设置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        if ($request->isMethod('POST')) {

            $data = $request->only(['register:money']);

            if (Setting::setSetting($data, self::OWNER_SITE)) {
                return redirect()->route('admin.setting.register')->with('success', __('Set up success'));
            }

            return back()->with('error', __('Set up failed'))->withInput();

        } else {
            $setting = Setting::getSection(self::OWNER_SITE);
            return backendView('setting.register', [
                'setting' => $setting
            ]);
        }
    }
}
