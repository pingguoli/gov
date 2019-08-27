<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/27 11:07
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;


/**
 * 新闻
 * Class NewsController
 * @package App\Http\Controllers\Web
 */
class NewsController extends BaseController
{
    /**
     * 新闻列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return frontendView('news.index');
    }

    /**
     * 新闻详情
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id = null)
    {
        return frontendView('news.detail');
    }
}