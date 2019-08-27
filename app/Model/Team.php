<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 战队信息
 * Class Team
 * @package App\Model
 */
class Team extends Model
{
    /**
     * 战队成功状态
     */
    const TEAM_SUCCESS = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'name', 'logo', 'point', 'user_project_id', 'status'];

    /**
     * 创建战队
     * @param UserProject $userProject
     * @param $data
     * @return bool
     */
    public static function add(UserProject $userProject, $data)
    {
        DB::beginTransaction();
        try {
            $data['project_id'] = $userProject->project_id;
            $data['user_project_id'] = $userProject->id;
            /* 创建战队 */
            $team = self::create($data);
            if (!$team) {
                throw new \Exception('');
            }

            $userProject->team_id = $team->id;
            if (!$userProject->save()) {
                throw new \Exception('');
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 转让战队队长
     * @param $id
     * @param $userProjectId
     * @return bool
     */
    public static function transfer($id, $userProjectId)
    {
        DB::beginTransaction();
        try {
            $team = self::find($id);
            if (!$team) {
                throw new \Exception('');
            }

            // 更改战队队长
            $team->user_project_id = $userProjectId;
            if (!$team->save()) {
                throw new \Exception('');
            }

            // 保存更改历史
            if (!UserTeamHistory::addHistory($userProjectId, $id, '您成为战队队长')) {
                throw new \Exception('');
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 判断名称是否存在
     * @param $name
     * @param $projectId
     * @return bool
     */
    public static function hasName($name, $projectId)
    {
        $count = self::where('name', $name)->where('project_id', $projectId)->count();
        return $count > 0 ? true : false;
    }

    /**
     * 获取战队状态
     * @return string
     */
    public function getStatus()
    {
        $status = [
            -2 => '已解散',
            -1 => '驳回',
            0 => '等待审核',
            1 => '审核中',
            2 => '通过',
        ];

        return array_key_exists($this->status, $status) ? $status[$this->status] : '';
    }
}
