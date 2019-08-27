<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 账号项目
 * Class UserProject
 * @package App\Model
 */
class UserProject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'project_id', 'name', 'point', 'team_id', 'status'];

    /**
     * 项目信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 战队信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * 更改战队信息
     * @param $id
     * @param null $teamId
     * @return bool
     */
    public static function changeTeam($id, $teamId = null)
    {
        /**
         * @var $userProject UserProject
         */
        $userProject = self::find($id);
        if (!$userProject) {
            return false;
        }
        $userProject->team_id = $teamId;
        if (!$userProject->save()) {
            return false;
        }
        return true;
    }

    /**
     * 退出战队操作
     * @return bool
     */
    public function removeTeam()
    {
        DB::beginTransaction();
        try {
            if (!$this) {
                throw new \Exception('');
            }
            $team = $this->team_id;
            // 退出
            $this->team_id = null;
            if (!$this->save()) {
                throw new \Exception('');
            }

            // 保存战队记录
            $addHistory = UserTeamHistory::addHistory($this->id, $team, false);
            if (!$addHistory) {
                throw new \Exception('');
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
