<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();

        $sort = 1;

        /************************** 系统公用菜单 *******************************/

        /* 增加系统设置 */
        $pid = DB::table('menus')->insertGetId([
            'pid' => 0,
            'title' => '系统设置',
            'name' => '',
            'url' => '',
            'icon' => 'fa-cog',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '系统设置',
            'name' => 'setting/app',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '站点设置',
            'name' => 'setting/site',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '注册设置',
            'name' => 'setting/register',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 增加权限管理类别 */
        $pid = DB::table('menus')->insertGetId([
            'pid' => 0,
            'title' => '权限管理',
            'name' => '',
            'url' => '',
            'icon' => 'fa-lock',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        /* 管理员设置 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '管理员管理',
            'name' => 'manager/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增管理员',
            'name' => 'manager/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑管理员',
            'name' => 'manager/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '删除管理员',
            'name' => 'manager/delete',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看管理员',
            'name' => 'manager/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 角色管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '角色管理',
            'name' => 'role/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增角色',
            'name' => 'role/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑角色',
            'name' => 'role/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '删除角色',
            'name' => 'role/delete',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看角色',
            'name' => 'role/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '授权角色',
            'name' => 'role/permission',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 菜单管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '菜单管理',
            'name' => 'menu/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增菜单',
            'name' => 'menu/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑菜单',
            'name' => 'menu/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '删除菜单',
            'name' => 'menu/delete',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看菜单',
            'name' => 'menu/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /************************** 系统定制菜单 *******************************/

        /* 增加基本设置类别 */
        $pid = DB::table('menus')->insertGetId([
            'pid' => 0,
            'title' => '基本设置',
            'name' => '',
            'url' => '',
            'icon' => 'fa-th',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 审核设置管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '审核设置管理',
            'name' => 'verify/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增审核设置',
            'name' => 'verify/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑审核设置',
            'name' => 'verify/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 增加新闻管理类别 */
        $pid = DB::table('menus')->insertGetId([
            'pid' => 0,
            'title' => '新闻管理',
            'name' => '',
            'url' => '',
            'icon' => 'fa-bell',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 导航管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '导航管理',
            'name' => 'navigation/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增导航',
            'name' => 'navigation/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑导航',
            'name' => 'navigation/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '删除导航',
            'name' => 'navigation/delete',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看导航',
            'name' => 'navigation/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 分类管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '分类管理',
            'name' => 'category/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增分类',
            'name' => 'category/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑分类',
            'name' => 'category/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '删除分类',
            'name' => 'category/delete',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看分类',
            'name' => 'category/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 文章管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '文章管理',
            'name' => 'article/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增文章',
            'name' => 'article/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑文章',
            'name' => 'article/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '删除文章',
            'name' => 'article/delete',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看文章',
            'name' => 'article/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 单页管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '单页管理',
            'name' => 'page/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增单页',
            'name' => 'page/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑单页',
            'name' => 'page/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '删除单页',
            'name' => 'page/delete',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看单页',
            'name' => 'page/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 增加运动员管理类别 */
        $pid = DB::table('menus')->insertGetId([
            'pid' => 0,
            'title' => '运动员管理',
            'name' => '',
            'url' => '',
            'icon' => 'fa-user',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        /* 账号管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '运动员管理',
            'name' => 'user/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑运动员',
            'name' => 'user/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看运动员',
            'name' => 'user/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '历史记录',
            'name' => 'user/history',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看历史详情',
            'name' => 'user/detail',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 增加比赛管理类别 */
        $pid = DB::table('menus')->insertGetId([
            'pid' => 0,
            'title' => '比赛管理',
            'name' => '',
            'url' => '',
            'icon' => 'fa-gamepad',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        /* 项目类型管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '项目类型管理',
            'name' => 'projecttype/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增项目类型',
            'name' => 'projecttype/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑项目类型',
            'name' => 'projecttype/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 项目管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '项目管理',
            'name' => 'project/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '新增项目',
            'name' => 'project/add',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '编辑项目',
            'name' => 'project/edit',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 战队管理 */
        $sonPid = DB::table('menus')->insertGetId([
            'pid' => $pid,
            'title' => '战队管理',
            'name' => 'team/index',
            'url' => '',
            'icon' => '',
            'is_show' => 1,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '战队审核',
            'name' => 'team/verify',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('menus')->insertGetId([
            'pid' => $sonPid,
            'title' => '查看战队',
            'name' => 'team/view',
            'url' => '',
            'icon' => '',
            'is_show' => 0,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
