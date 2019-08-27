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
use Illuminate\Support\Facades\DB;

/**
 * 人脸识别
 * Class Face
 * @package App\Model
 */
class Face extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'code', 'id_card', 'img', 'verify_time', 'status', 'payment_id', 'out_trade_no', 'remark'];

    /**
     * 验证用户是否已经识别
     * @param User $user
     * @return bool
     */
    public static function verify(User $user)
    {
        $face = self::where('user_id', $user->id)
            ->where('code', $user->code)
            ->where('id_card', encryptStr($user->id_card))
            ->where('img', $user->id_card_face)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')->first();

        if (empty($face) || !$face->id) {
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     * @param Payment $payment
     * @return null|Face
     */
    public static function add(User $user, Payment $payment)
    {
        DB::beginTransaction();
        try {
            /* 添加身份证识别 */
            $face = self::create([
                'user_id' => $user->id,
                'code' => $user->code,
                'id_card' => $user->id_card,
                'img' => $user->id_card_face,
                'payment_id' => $payment->id,
                'out_trade_no' => $payment->out_trade_no
            ]);

            if (!$face || !$face->id) {
                throw new \Exception('');
            }

            $payment->is_used = 1;
            $payment->remark = '身份证识别支付';
            if (!$payment->save()) {
                throw new \Exception('');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }

        return $face;
    }

    /**
     * 加密身份证号码
     * @param  string $value
     * @return void
     */
    public function setIdCardAttribute($value)
    {
        $this->attributes['id_card'] = encryptStr($value);
    }

    /**
     * 解密身份证号码
     * @param  string $value
     * @return string
     */
    public function getIdCardAttribute($value)
    {
        return decryptStr($value);
    }

    /**
     * 加密备注(备注为接口返回信息)
     * @param  string $value
     * @return void
     */
    public function setRemarkAttribute($value)
    {
        $this->attributes['remark'] = encryptStr($value);
    }

    /**
     * 解密备注
     * @param  string $value
     * @return string
     */
    public function getRemarkAttribute($value)
    {
        return decryptStr($value);
    }
}
