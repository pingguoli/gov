<?php

namespace App\Wxpay;

use Exception;

/**
 *
 * 微信支付API异常类
 * @author widyhu
 *
 */
class WxPayException extends Exception
{
    /**
     * @return string
     */
    public function errorMessage()
    {
        return $this->getMessage();
    }
}
