<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 账号项目战队历史记录
 * Class UserTeamHistory
 * @package App\Model
 */
class UserTeamHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_project_id', 'team_id', 'remark'];

    /**
     * 增加历史信息
     * @param $userProjectId
     * @param $teamId
     * @param bool|string $isJson
     * @return bool
     */
    public static function addHistory($userProjectId, $teamId, $isJson = true)
    {
        $remark = is_bool($isJson) ? ($isJson ? '加入战队' : '退出战队') : (is_string($isJson) ? $isJson : '');
        $data = [
            'user_project_id' => $userProjectId,
            'team_id' => $teamId,
            'remark' => $remark
        ];
        if (self::create($data)) {
            return true;
        }

        return false;
    }
}
