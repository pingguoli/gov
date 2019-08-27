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

use App\Model\Payment;
use App\Wxpay\WxPayApi;
use App\Wxpay\WxPayException;
use App\Wxpay\WxPayNotify;
use App\Wxpay\WxPayOrderQuery;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * 微信扫码支付回调
 * Class WxNativeNotify
 * @package App\Support
 */
class WxNativeNotify extends WxPayNotify
{
    /**
     * 回调处理
     */
    public function notify()
    {
        try {
            $config = new WxPayConfig("native");
            $this->Handle($config, false);
        } catch (WxPayException $e) {
            Log::notice("微信扫码支付异步回调:" . $e->getMessage());
        }
    }

    /**
     * @param \App\Wxpay\WxPayNotifyResults $objData 回调解释出的参数
     * @param \App\Wxpay\WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return bool true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     * @throws WxPayException
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->GetValues();
        // 1、进行参数校验
        if (!array_key_exists("return_code", $data)
            || (array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            //TODO失败,不是支付成功的通知
            //如果有需要可以做失败时候的一些清理处理，并且做一些监控
            $msg = "异常异常";
            return false;
        }

        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }

        // 2、进行签名验证
        try {
            $checkResult = $objData->CheckSign($config);
            if ($checkResult == false) {
                //签名错误
                Log::error("微信扫码支付异步回调:签名错误...");
                return false;
            }
        } catch (Exception $e) {
            Log::error("微信扫码支付异步回调:" . json_encode($e));
        }

        // 3、处理业务逻辑
        /**
         * @var $payment Payment
         */
        $payment = Payment::where('out_trade_no', $data['out_trade_no'])->first();
        if (!$payment || !$payment->id || $payment->total_fee * 100 != $data['total_fee']) {
            $msg = "订单不存在";
            return false;
        }
        if (empty($payment->payment_time) && empty($payment->status)) {
            // 未支付
            $payment->payment_code = $data["transaction_id"];
            $payment->payment_time = strtotime($data['time_end']);
            $payment->status = 1;
            $payment->payment_result = json_encode($data, JSON_UNESCAPED_UNICODE);
            if (!$payment->save()) {
                $msg = "处理订单失败";
                return false;
            }
        }

        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }

        return true;
    }

    /**
     * 查询订单
     * @param $transaction_id
     * @return bool
     * @throws WxPayException
     */
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);

        $config = new WxPayConfig("native");
        $result = WxPayApi::orderQuery($config, $input);
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS") {
            return true;
        }

        return false;
    }
}