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
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class User
 * @package App\Model
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'name', 'id_card', 'sex', 'email', 'mobile', 'nickname', 'birthday', 'nationality', 'address', 'education', 'img',
        'id_card_type', 'id_card_face', 'id_card_nation', 'house_img', 'passport_img', 'password', 'type', 'status', 'step',
        'is_complete', 'register_time'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 1选手
     */
    const TYPE_PLAYER = 1;

    /**
     * 2教练
     */
    const TYPE_COACH = 2;

    /**
     * 3裁判
     */
    const TYPE_REFEREE = 3;

    /**
     * 4解说员
     */
    const TYPE_COMMENTATOR = 4;

    /**
     * 5数据分析师
     */
    const TYPE_ANALYST = 5;

    /**
     * 用户类型
     * @var array
     */
    public static $types = [
        self::TYPE_PLAYER => '选手',
        self::TYPE_COACH => '教练',
        self::TYPE_REFEREE => '裁判',
        self::TYPE_COMMENTATOR => '解说',
        self::TYPE_ANALYST => '数据分析师',
    ];

    /**
     * 生成唯一标识码
     * @return string
     */
    public static function generateCode()
    {
        do {
            $code = 'user:' . Str::random(32);
            $count = self::where('code', $code)->count();
        } while ($count > 0);

        return $code;
    }

    /**
     * 更改用户信息并保存修改历史
     * @param $data
     * @param null|Admin $admin
     * @return bool
     */
    public function edit($data, $admin = null)
    {
        DB::beginTransaction();
        try {
            if (!$this) {
                throw new \Exception('');
            }

            $isChange = $this->isChange($data);

            if ($isChange) {
                $userHistory = new UserHistory();
                foreach (UserHistory::$historyFields as $key => $title) {
                    $userHistory->{$key} = $this->{$key};
                }
                $userHistory->user_id = $this->id;
                $userHistory->history_time = time();
                if ($admin !== null && $admin instanceof Admin) {
                    $userHistory->admin_id = $admin->id;
                }
                if (!$userHistory->save()) {
                    throw new \Exception('');
                }
            }

            /* 编辑角色 */
            $this->update($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 判断是否修改
     * @param $data
     * @return bool
     */
    public function isChange($data)
    {
        if (!is_array($data)) {
            return false;
        }

        foreach ($data as $key => $value) {
            if (!array_key_exists($key, UserHistory::$historyFields)) {
                continue;
            }
            if ($this->{$key} == $value) {
                continue;
            }

            return true;
        }


        return false;
    }

    /**
     * 获取修改的列表
     * @param $data
     * @return array|bool
     */
    public function changeList($data)
    {
        if (!is_array($data)) {
            return false;
        }
        $changes = [];
        if (array_key_exists('password', $data)) {
            $changes['password'] = '修改了密码';
        }

        $newUser = new User();

        foreach ($data as $key => $value) {
            if (!array_key_exists($key, UserHistory::$historyFields)) {
                continue;
            }
            if ($this->{$key} == $value) {
                continue;
            }

            if ($key == 'sex') {
                $newUser->{$key} = $value;
                $changes['sex'] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => $this->getSex(),
                    'new' => $newUser->getSex()
                ];
            } else if ($key == 'nationality') {
                $newUser->{$key} = $value;
                $changes['nationality'] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => $this->getNationality(),
                    'new' => $newUser->getNationality()
                ];
            } else if ($key == 'education') {
                $newUser->{$key} = $value;
                $changes['education'] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => $this->getEducation(),
                    'new' => $newUser->getEducation()
                ];
            } else if ($key == 'type') {
                $newUser->{$key} = $value;
                $changes['type'] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => $this->getType(),
                    'new' => $newUser->getType()
                ];
            } else if ($key == 'status') {
                $newUser->{$key} = $value;
                $changes['status'] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => $this->getStatus(),
                    'new' => $newUser->getStatus()
                ];
            } else if ($key == 'id_card_type') {
                $newUser->{$key} = $value;
                $changes['id_card_type'] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => $this->getIdCardType(),
                    'new' => $newUser->getIdCardType()
                ];
            } else if ($key == 'id_card_face' || $key == 'id_card_nation' || $key == 'house_img' || $key == 'passport_img') {
                $changes[$key] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => File::getFileUrl($this->{$key}),
                    'new' => File::getFileUrl($value)
                ];
            } else {
                $changes[$key] = [
                    'name' => UserHistory::$historyFields[$key],
                    'orig' => $this->{$key},
                    'new' => $value
                ];

            }
        }


        return count($changes) ? $changes : false;
    }

    /**
     * 获取用户类型
     * @return string
     */
    public function getType()
    {
        return array_key_exists($this->type, self::$types) ? self::$types[$this->type] : '';
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
     * 是否注册完成
     * @return string
     */
    public function isComplete()
    {
        $list = [
            0 => __('No'),
            1 => __('Yes'),
        ];

        return array_key_exists($this->is_complete, $list) ? $list[$this->is_complete] : '';
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
     * 验证身份证号码是否存在
     * $id 表示不验证的ID
     * @param $idCard
     * @param null $id
     * @return bool
     */
    public static function hasIdCard($idCard, $id = null)
    {
        if (empty($idCard)) {
            return false;
        }
        $idCard = encryptStr($idCard);
        if (empty($id)) {
            $count = self::where('id_card', $idCard)->count();
        } else {
            $count = self::where('id_card', $idCard)->where('id', '<>', $id)->count();
        }
        return $count > 0 ? true : false;
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
     * 验证邮箱是否存在
     * $id 表示不验证的ID
     * @param $email
     * @param null $id
     * @return bool
     */
    public static function hasEmail($email, $id = null)
    {
        if (empty($email)) {
            return false;
        }
        $email = encryptStr($email);
        if (empty($id)) {
            $count = self::where('email', $email)->count();
        } else {
            $count = self::where('email', $email)->where('id', '<>', $id)->count();
        }
        return $count > 0 ? true : false;
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
     * 验证手机号是否存在
     * $id 表示不验证的ID
     * @param $mobile
     * @param null $id
     * @return bool
     */
    public static function hasMobile($mobile, $id = null)
    {
        if (empty($mobile)) {
            return false;
        }
        $mobile = encryptStr($mobile);
        if (empty($id)) {
            $count = self::where('mobile', $mobile)->count();
        } else {
            $count = self::where('mobile', $mobile)->where('id', '<>', $id)->count();
        }
        return $count > 0 ? true : false;
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
     * 获取登录时间
     * @param $value
     * @return false|string
     */
    public function getLastLoginTimeAttribute($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
    }

    /**
     * 获取注册时间
     * @param $value
     * @return false|string
     */
    public function getRegisterTimeAttribute($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
    }
}
