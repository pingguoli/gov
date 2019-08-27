<?php

use Illuminate\Database\Seeder;

/**
 * 填充默认数据
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 初始化设置 */
        $this->call(SettingsTableSeeder::class);

        /* 初始化权限 */
        $this->call(PermissionSeeder::class);

        /* 初始化角色 */
        $this->call(RolesTableSeeder::class);

        /* 初始化后台管理员 */
        $this->call(AdminsTableSeeder::class);

        /* 初始化菜单 */
        $this->call(MenusTableSeeder::class);
    }
}
