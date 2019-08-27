<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 账号项目战队邀请记录
 * Class UserTeamRecord
 * @package App\Model
 */
class UserTeamRecord extends Model
{
    /**
     * 同意
     */
    const TYPE_AGREE = 1;

    /**
     * 拒绝
     */
    const TYPE_REFUSE = -1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_project_id', 'team_id', 'message', 'status'];

    /**
     * 战队信息
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * 同意加入战队操作
     * @return bool
     */
    public function agree()
    {
        DB::beginTransaction();
        try {
            if (!$this) {
                throw new \Exception('');
            }
            // 更改当前状态
            $this->status = self::TYPE_AGREE;
            if (!$this->save()) {
                throw new \Exception('');
            }

            // 更改战队
            $changeTeam = UserProject::changeTeam($this->user_project_id, $this->team_id);
            if (!$changeTeam) {
                throw new \Exception('');
            }

            // 保存战队记录
            $addHistory = UserTeamHistory::addHistory($this->user_project_id, $this->team_id);
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
