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
 * Class SmsCode
 * @package App\Model
 */
class SmsCode extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['mobile', 'type', 'code', 'expired_time', 'is_verify'];

    /**
     * 注册短信标识
     */
    const TYPE_REGISTER = 'register';

    /**
     *注册短信标识
     */
    const TYPE_LOGIN = 'login';

    /**
     * 忘记密码短信标识
     */
    const TYPE_FORGET_PASSWORD = 'forget_password';

    /**
     * 保存短信验证码
     * 默认有效时间5分钟
     * @param string $mobile 手机号
     * @param string $code 验证码
     * @param string $type 类型
     * @param int $time 验证码有效期(单位:分钟)
     * @return bool
     */
    public static function send($mobile, $code, $type = self::TYPE_REGISTER, $time = 5)
    {
        $time = intval($time) > 0 ? intval($time) : 5;
        $expiredTime = $time * 60 + time();
        $data = [
            'mobile' => $mobile,
            'code' => $code,
            'type' => $type,
            'expired_time' => $expiredTime,
            'is_verify' => 0
        ];
        if (self::create($data)) {
            return true;
        }

        return false;
    }

    /**
     * 验证短信验证码
     * @param string $mobile 手机号
     * @param string $code 验证码
     * @param string $type 类型
     * @return bool
     */
    public static function verify($mobile, $code, $type = self::TYPE_REGISTER)
    {
        if (empty($mobile) || empty($code)) {
            return false;
        }

        // 获取最后一条当前手机、当前验证类型的验证码
        $sms = self::where('mobile', encryptStr($mobile))->where('type', $type)->orderBy('created_at', 'desc')->first();
        if (!$sms || !$sms->id) {
            return false;
        }

        // 判断是否验证过
        if ($sms->is_verify) {
            return false;
        }

        // 更改已验证
        $sms->is_verify = 1;
        $sms->save();

        // 验证验证码是否正确
        if ($sms->code != $code) {
            return false;
        }

        // 验证是否过期
        if ($sms->expired_time < time()) {
            return false;
        }

        return true;
    }

    /**
     * 加密手机号
     * @param  string $value
     * @return void
     */
    public function setMobileAttribute($value)
    {
        $this->attributes['mobile'] = encryptStr($value);
    }

    /**
     * 解密手机号
     * @param  string $value
     * @return string
     */
    public function getMobileAttribute($value)
    {
        return decryptStr($value);
    }
}
