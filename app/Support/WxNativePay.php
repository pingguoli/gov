<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Support;

use App\Wxpay\WxPayApi;
use App\Wxpay\WxPayException;
use App\Wxpay\WxPayUnifiedOrder;
use Exception;

/**
 * 微信扫码支付
 * Class WxNativePay
 * @package App\Support
 */
class WxNativePay
{
    /**
     * 设置商品或支付单简要描述
     * @var string
     */
    private $_body = '';

    /**
     * 设置附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
     * @var string
     */
    private $_attach = '';

    /**
     * 设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
     * @var string
     */
    private $_out_trade_no = '';

    /**
     * 设置订单总金额，只能为整数，详见支付金额
     * @var string
     */
    private $_total_fee = '';

    /**
     * 设置订单生成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。其他详见时间规则
     * @var string
     */
    private $_time_start = '';

    /**
     * 设置订单失效时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。其他详见时间规则
     * @var string
     */
    private $_time_expire = '';

    /**
     * 设置商品标记，代金券或立减优惠功能的参数，说明详见代金券或立减优惠
     * @var string
     */
    private $_goods_tag = '';

    /**
     * 设置接收微信支付异步通知回调地址
     * @var string
     */
    private $_notify_url = '';

    /**
     * 设置取值如下：JSAPI，NATIVE，APP，详细说明见参数规定
     * @var string
     */
    private $_trade_type = 'NATIVE';

    /**
     * 设置trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义。
     * @var string
     */
    private $_product_id = '';

    /**
     * 错误信息
     * @var string
     */
    private $_message = '';

    /**
     * 返回结果
     * @var null
     */
    private $_result = null;

    /**
     * WxNativePay constructor.
     */
    public function __construct()
    {
        // 默认初始化订单生成时间和实效时间
        $this->_time_start = date("YmdHis");
        $this->_time_expire = date("YmdHis", time() + 600);
    }

    /**
     * $wxpay = new WxNativePay();
     * $result = $wxpay->setOutTradeNo("sdkphp123456789")
     *   ->setTotalFee(1)
     *   ->setBody("test")
     *   ->setNotifyUrl("http://paysdk.weixin.qq.com/notify.php")
     *   ->pay();
     * $result 为false, 请求失败, 其他为请求成功
     * $wxpay->getMessage(); 获取错误时的错误信息
     * $wxpay->getResult(); 获取返回的结果数组, 如果发生异常为null
     * 流程：
     * 1、调用统一下单，取得code_url，生成二维码
     * 2、用户扫描二维码，进行支付
     * 3、支付完成之后，微信服务器会通知支付成功
     * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
     */
    public function pay()
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($this->_body);
        $input->SetAttach($this->_attach);
        $input->SetOut_trade_no($this->_out_trade_no);
        $input->SetTotal_fee($this->_total_fee);
        $input->SetTime_start($this->_time_start);
        $input->SetTime_expire($this->_time_expire);
        $input->SetGoods_tag($this->_goods_tag);
        $input->SetNotify_url($this->_notify_url);
        $input->SetTrade_type($this->_trade_type);
        $input->SetProduct_id($this->_product_id);

        $result = $this->GetPayUrl($input);
        if ($result === false) {
            return false;
        } else if ($result['return_code'] == 'FAIL') {
            $this->_message = $result['return_msg'];
            $this->_result = $result;
            return false;
        } else if ($result['result_code'] == 'FAIL') {
            $this->_message = $result['err_code_des'];
            $this->_result = $result;
            return false;
        }
        $this->_result = $result;

        return $result["code_url"];
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * @param string $attach
     * @return $this
     */
    public function setAttach($attach)
    {
        $this->_attach = $attach;
        return $this;
    }

    /**
     * @param string $out_trade_no
     * @return $this
     */
    public function setOutTradeNo($out_trade_no)
    {
        $this->_out_trade_no = $out_trade_no;
        return $this;
    }

    /**
     * @param string $total_fee
     * @return $this
     */
    public function setTotalFee($total_fee)
    {
        $this->_total_fee = $total_fee;
        return $this;
    }

    /**
     * @param string $time_start
     * @return $this
     */
    public function setTimeStart($time_start)
    {
        $this->_time_start = $time_start;
        return $this;
    }

    /**
     * @param string $time_expire
     * @return $this
     */
    public function setTimeExpire($time_expire)
    {
        $this->_time_expire = $time_expire;
        return $this;
    }

    /**
     * @param string $goods_tag
     * @return $this
     */
    public function setGoodsTag($goods_tag)
    {
        $this->_goods_tag = $goods_tag;
        return $this;
    }

    /**
     * @param string $notify_url
     * @return $this
     */
    public function setNotifyUrl($notify_url)
    {
        $this->_notify_url = $notify_url;
        return $this;
    }

    /**
     * @param string $trade_type
     * @return $this
     */
    public function setTradeType($trade_type)
    {
        $this->_trade_type = $trade_type;
        return $this;
    }

    /**
     * @param string $product_id
     * @return $this
     */
    public function setProductId($product_id)
    {
        $this->_product_id = $product_id;
        return $this;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * 获取执行结果
     * @return null|array
     */
    public function getResult()
    {
        return $this->_result;
    }

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param WxPayUnifiedOrder $input
     * @return bool
     */
    private function GetPayUrl($input)
    {
        if ($input->GetTrade_type() == "NATIVE") {
            try {
                $config = new WxPayConfig("native");
                $result = WxPayApi::unifiedOrder($config, $input);
                return $result;
            } catch (WxPayException $e) {
                $this->_message = $e->getMessage();
            } catch (Exception $e) {
                $this->_message = $e->getMessage();
            }
        }

        return false;
    }
}