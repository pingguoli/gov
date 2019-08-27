<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 初始化管理员
 * Class AdminsTableSeeder
 */
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = DB::table('admins')->where('id', 1)->first();

        if ($admin) {
            /* 更新 */
            DB::table('admins')->where('id', 1)->update([
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'nickname' => 'Administrator',
                'real_name' => '',
                'id_card' => '',
                'email' => '',
                'mobile' => '',
                'img' => '',
                'address' => '',
                'status' => 1,
                'type' => \App\Model\Admin::TYPE_DEFAULT,
                'last_login_ip' => '',
                'last_login_time' => null,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            /* 插入 */
            DB::table('admins')->insert([
                'id' => 1,
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'nickname' => 'Administrator',
                'real_name' => '',
                'id_card' => '',
                'email' => '',
                'mobile' => '',
                'img' => '',
                'address' => '',
                'status' => 1,
                'type' => \App\Model\Admin::TYPE_DEFAULT,
                'last_login_ip' => '',
                'last_login_time' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        /* 删除角色权限 */
        $count = DB::table('admin_roles')->where('admin_id', '<>', 1)->count();
        if ($count == 0) {
            DB::table('admin_roles')->truncate();
        } else {
            DB::table('admin_roles')->where('admin_id', 1)->delete();
        }

        /* 新增角色权限 */
        $roles = DB::table('roles')->where('type', \App\Model\Admin::TYPE_DEFAULT)->get();
        foreach ($roles as $role) {
            DB::table('admin_roles')->insert([
                'admin_id' => 1,
                'role_id' => $role->id,
            ]);
        }
    }
}
