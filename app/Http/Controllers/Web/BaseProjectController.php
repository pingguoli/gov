<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/20 16:44
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Web;


use App\Model\Project;
use App\Model\UserProject;

/**
 * 项目下所有操作基类
 * 项目的验证
 * Class BaseProjectController
 * @package App\Http\Controllers\Web
 */
abstract class BaseProjectController extends BaseController
{
    /**
     * 项目
     * @var null|Project
     */
    private $_project = null;

    /**
     * 账号项目
     * @var null|UserProject
     */
    private $_userProject = null;

    /**
     * 获取项目
     * @param $code
     * @return null|Project
     */
    public function getProject($code)
    {
        if ($this->_project === null) {
            $this->_project = Project::where('code', $code)->first();
        }

        return $this->_project;
    }

    /**
     * 根据项目编号获取账号项目
     * @param $code
     * @return null|UserProject
     */
    public function getUserProject($code)
    {
        if ($this->_userProject === null) {
            $user = $this->getUser();
            if (!$user) {
                return $this->_userProject;
            }
            $project = $this->getProject($code);
            if (!$project) {
                return $this->_userProject;
            }

            $this->_userProject = UserProject::where('project_id', $project->id)->where('user_id', $user->id)->first();
        }

        return $this->_userProject;
    }
}