<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;

class HomeController extends BaseController
{
    /**
     * 首页入口
     */
    public function index()
    {
        return frontendView('home.index');
    }
}
