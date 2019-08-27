<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 审核确认
 * Class Verify
 * @package App\Model
 */
class Verify extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'project_id', 'admin_id'];

    /**
     * 1审核用户
     */
    const VERIFY_USER = 1;

    /**
     * 2审核项目
     */
    const VERIFY_PROJECT = 2;

    /**
     * 3审核比赛
     */
    const VERIFY_MATCH = 3;

    /**
     * 4审核考试
     */
    const VERIFY_EXAM = 4;

    /**
     * 根据项目唯一的类型
     * @var array
     */
    public static $projectSome = [self::VERIFY_PROJECT, self::VERIFY_MATCH, self::VERIFY_EXAM];

    /**
     * 审核确认类型
     * @var array
     */
    public static $types = [
        self::VERIFY_USER => '账号',
        self::VERIFY_PROJECT => '项目',
    ];

    /**
     * 获取类型
     * @return string
     */
    public function getType()
    {
        return array_key_exists($this->type, self::$types) ? self::$types[$this->type] : '';
    }

    /**
     * 项目
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 管理员
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * 获取验证的管理员
     * @param int $type
     * @param null $projectId
     * @return null|Admin
     */
    public static function getVerifyAdmin($type = self::VERIFY_USER, $projectId  = null)
    {
        if ($type != self::VERIFY_USER && !in_array($type, self::$projectSome)) {
            return null;
        }

        if (in_array($type, self::$projectSome) && empty($projectId)) {
            return null;
        }

        if (in_array($type, self::$projectSome)) {
            $verify = self::where('type', $type)->where('project_id', $projectId)->first();
        } else {
            $verify = self::where('type', $type)->first();
        }

        if (!$verify || !$verify->id) {
            return null;
        }

        $manager = Admin::find($verify->admin_id);
        if (!$manager || !$manager->id) {
            return null;
        }

        return $manager;
    }
}
