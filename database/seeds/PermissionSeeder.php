<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        $sort = 1;
        /************************** 系统公用权限 *******************************/

        /* 增加设置权限 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '设置',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '系统设置',
            'name' => 'setting/app',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '站点设置',
            'name' => 'setting/site',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '注册设置',
            'name' => 'setting/register',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 增加管理员权限 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '管理员管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '管理员列表',
            'name' => 'manager/index',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增管理员',
            'name' => 'manager/add',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑管理员',
            'name' => 'manager/edit',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '删除管理员',
            'name' => 'manager/delete',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看管理员',
            'name' => 'manager/view',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 角色权限 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '角色管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '角色列表',
            'name' => 'role/index',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增角色',
            'name' => 'role/add',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑角色',
            'name' => 'role/edit',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '删除角色',
            'name' => 'role/delete',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看角色',
            'name' => 'role/view',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '授权角色',
            'name' => 'role/permission',
            'type' => \App\Model\Admin::TYPE_DEFAULT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 菜单权限*/
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '菜单管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '菜单列表',
            'name' => 'menu/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增菜单',
            'name' => 'menu/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑菜单',
            'name' => 'menu/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '删除菜单',
            'name' => 'menu/delete',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看菜单',
            'name' => 'menu/view',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /************************** 系统定制权限 *******************************/

        /* 审核设置管理 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '审核设置管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '审核设置列表',
            'name' => 'verify/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增审核设置',
            'name' => 'verify/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑审核设置',
            'name' => 'verify/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 导航管理权限*/
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '导航管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '导航列表',
            'name' => 'navigation/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增导航',
            'name' => 'navigation/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑导航',
            'name' => 'navigation/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '删除导航',
            'name' => 'navigation/delete',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看导航',
            'name' => 'navigation/view',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 分类管理权限*/
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '分类管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '分类列表',
            'name' => 'category/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增分类',
            'name' => 'category/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑分类',
            'name' => 'category/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '删除分类',
            'name' => 'category/delete',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看分类',
            'name' => 'category/view',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 文章管理权限*/
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '文章管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '文章列表',
            'name' => 'article/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增文章',
            'name' => 'article/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑文章',
            'name' => 'article/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '删除文章',
            'name' => 'article/delete',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看文章',
            'name' => 'article/view',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 单页管理权限*/
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '单页管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '单页列表',
            'name' => 'page/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增单页',
            'name' => 'page/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑单页',
            'name' => 'page/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '删除单页',
            'name' => 'page/delete',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看单页',
            'name' => 'page/view',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        /* 运动员管理 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '运动员管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        /* 运动员管理 */
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '运动员列表',
            'name' => 'user/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑运动员',
            'name' => 'user/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '历史记录',
            'name' => 'user/history',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看运动员',
            'name' => 'user/view',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 项目类型管理 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '项目类型管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '项目类型列表',
            'name' => 'projecttype/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增项目类型',
            'name' => 'projecttype/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑项目类型',
            'name' => 'projecttype/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 项目管理 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '项目管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '项目列表',
            'name' => 'project/index',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '新增项目',
            'name' => 'project/add',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '编辑项目',
            'name' => 'project/edit',
            'type' => \App\Model\Admin::TYPE_PLATFORM,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        /* 战队管理 */
        $pid = DB::table('permissions')->insertGetId([
            'pid' => 0,
            'title' => '战队管理',
            'name' => '',
            'type' => \App\Model\Admin::TYPE_PROJECT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '战队列表',
            'name' => 'team/index',
            'type' => \App\Model\Admin::TYPE_PROJECT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '审核战队',
            'name' => 'team/verify',
            'type' => \App\Model\Admin::TYPE_PROJECT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insertGetId([
            'pid' => $pid,
            'title' => '查看战队',
            'name' => 'team/view',
            'type' => \App\Model\Admin::TYPE_PROJECT,
            'sort' => $sort++,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
