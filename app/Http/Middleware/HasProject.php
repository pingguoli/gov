<?php

namespace App\Http\Middleware;

use App\Model\Project;
use App\Model\User;
use App\Model\UserProject;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * 验证是否有项目
 * Class HasProject
 * @package App\Http\Middleware
 */
class HasProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $code = $request->route()->parameter('code');
        if (!empty($code)) {

            /* 项目不存在时跳转到 404 */
            $project = Project::where('code', $code)->first();
            if (!$project) {
                abort(404);
            }

            /* 验证用户是否注册项目, 未注册的跳转到注册页面 */
            /**
             * @var $user User|null
             */
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }
            $userProject = UserProject::where('project_id', $project->id)->where('user_id', $user->id)->first();
            if (!$userProject) {
                return redirect()->route('project.create', ['code' => $code]);
            }
        }

        return $next($request);
    }
}
