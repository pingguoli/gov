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

use App\Support\Enum;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserHistory
 * @package App\Model
 */
class UserHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'id_card', 'sex', 'email', 'mobile', 'nickname', 'birthday', 'nationality', 'address', 'education', 'img',
        'id_card_type', 'id_card_face', 'id_card_nation', 'house_img', 'passport_img', 'type', 'status',
        'history_time', 'admin_id'];

    /**
     * 需要保存修改历史的字段
     * @var array
     */
    public static $historyFields = [
        'name' => '姓名',
        'id_card' => '身份证号码',
        'sex' => '性别',
        'email' => '邮箱',
        'mobile' => '手机号',
        'nickname' => '昵称',
        'birthday' => '生日',
        'nationality' => '国籍',
        'address' => '地址',
        'education' => '学历',
        'img' => '照片',
        'id_card_type' => '证件类型',
        'id_card_face' => '身份证头像面',
        'id_card_nation' => '身份证国徽面',
        'house_img' => '户口照片',
        'passport_img' => '护照照片',
        'type' => '类型',
        'status' => '状态'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * 获取用户类型
     * @return string
     */
    public function getType()
    {
        return array_key_exists($this->type, User::$types) ? User::$types[$this->type] : '';
    }

    /**
     * 获取用户状态
     * @return string
     */
    public function getStatus()
    {
        $status = [
            0 => __('Close'),
            1 => __('Open'),
        ];

        return array_key_exists($this->status, $status) ? $status[$this->status] : '-';
    }

    /**
     * 获取性别
     * @return string
     */
    public function getSex()
    {
        $sex = [
            1 => __('Male'),
            2 => __('Female'),
        ];

        return array_key_exists($this->sex, $sex) ? $sex[$this->sex] : '';
    }

    /**
     * 获取国籍
     * @return string
     */
    public function getNationality()
    {
        return array_key_exists($this->nationality, Enum::$nationality) ? __(Enum::$nationality[$this->nationality]) : '';
    }

    /**
     * 获取学历
     * @return string
     */
    public function getEducation()
    {
        return array_key_exists($this->education, Enum::$education) ? __(Enum::$education[$this->education]) : '';
    }

    /**
     * 获取证件类型
     * @return string
     */
    public function getIdCardType()
    {
        $list = [
            1 => '身份证',
            2 => '户口',
            3 => '护照',
        ];
        return array_key_exists($this->id_card_type, $list) ? $list[$this->id_card_type] : '';
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
     * 加密邮箱
     * @param  string $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = encryptStr($value);
    }

    /**
     * 解密邮箱
     * @param  string $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return decryptStr($value);
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

    /**
     * 加密地址
     * @param  string $value
     * @return void
     */
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = encryptStr($value);
    }

    /**
     * 解密地址
     * @param  string $value
     * @return string
     */
    public function getAddressAttribute($value)
    {
        return decryptStr($value);
    }

    /**
     * 获取历史记录时间
     * @param $value
     * @return false|string
     */
    public function getHistoryTimeAttribute($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
    }
}
