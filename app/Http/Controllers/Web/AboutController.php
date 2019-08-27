<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/27 11:06
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;


/**
 * 关于我们
 * Class AboutController
 * @package App\Http\Controllers\Web
 */
class AboutController extends BaseController
{
    /**
     * 关于我们
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return frontendView('about.index');
    }
}