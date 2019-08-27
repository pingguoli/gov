<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = DB::table('roles')->where('id', 1)->first();

        if ($role) {
            /* 更新 */
            DB::table('roles')->where('id', 1)->update([
                'name' => '超级管理员',
                'type' => \App\Model\Admin::TYPE_DEFAULT,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            /* 插入 */
            DB::table('roles')->insert([
                'id' => 1,
                'name' => '超级管理员',
                'type' => \App\Model\Admin::TYPE_DEFAULT,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        /* 删除角色权限 */
        $count = DB::table('role_permissions')->where('role_id', '<>', 1)->count();
        if ($count == 0) {
            DB::table('role_permissions')->truncate();
        } else {
            DB::table('role_permissions')->where('role_id', 1)->delete();
        }

        /* 新增角色权限 */
        $permissions = DB::table('permissions')->whereIn('type', \App\Model\Admin::PERMISSION_SUPPER)->get();
        foreach ($permissions as $permission) {
            DB::table('role_permissions')->insert([
                'role_id' => 1,
                'permission_id' => $permission->id,
            ]);
        }
    }
}
