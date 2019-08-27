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

use App\Support\WxNativeNotify;
use Illuminate\Http\Request;

/**
 * Class WxPayController
 * @package App\Http\Controllers
 */
class WxPayController extends Controller
{
    /**
     * 微信支付回调入口(默认扫码支付native)
     */
    public function notify()
    {
        $notify = new WxNativeNotify();
        $notify->notify();
    }
}
