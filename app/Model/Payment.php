<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 支付单
 * Class Payment
 * @package App\Model
 */
class Payment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'code', 'out_trade_no', 'total_fee', 'description', 'payment_method', 'payment_code', 'payment_time', 'payment_result', 'status', 'is_used', 'remark'];

    /**
     * 验证用户是否已经识别
     * @param User $user
     * @return bool|Payment
     */
    public static function hasNoUsed(User $user)
    {
        $payment = self::where('user_id', $user->id)
            ->where('code', $user->code)
            ->where('status', 1)
            ->where('is_used', 0)
            ->orderBy('created_at', 'desc')->first();

        if (empty($payment) || !$payment->id) {
            return false;
        }

        return $payment;
    }

    /**
     * 生成唯一支付标识
     * @return string
     */
    public static function newOutTradeNo()
    {
        do {
            $outTradeNo = time() . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
            $count = self::where('out_trade_no', $outTradeNo)->count();
        } while ($count > 0);

        return $outTradeNo;
    }
}
