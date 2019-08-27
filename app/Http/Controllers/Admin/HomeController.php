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

/**
 * 后台首页
 * Class HomeController
 * @package App\Http\Controllers\Admin
 */
class HomeController extends BaseController
{
    /**
     * 后台欢迎页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return backendView('home.index', [
            'title' => __('Home')
        ]);
    }
}
