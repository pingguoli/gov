<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 清空设置 */
        DB::table('settings')->truncate();
        /* 系统设置 */
        DB::table('settings')->insert([
            'section' => 'app',
            'key' => 'debug',
            'value' => 1,
        ]);
        DB::table('settings')->insert([
            'section' => 'app',
            'key' => 'log_level',
            'value' => 'debug',
        ]);
        DB::table('settings')->insert([
            'section' => 'app',
            'key' => 'log_max_files',
            'value' => 30,
        ]);

        /* 网站设置 */
        /* 基础设置 */
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'base:name',
            'value' => '电竞',
        ]);
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'base:icp',
            'value' => '',
        ]);
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'base:copyright',
            'value' => '2018-2028',
        ]);
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'base:address',
            'value' => '',
        ]);
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'base:telephone',
            'value' => '',
        ]);
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'base:email',
            'value' => '',
        ]);
        /* 其他设置 */
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'other:captcha',
            'value' => 1,
        ]);
        DB::table('settings')->insert([
            'section' => 'site',
            'key' => 'other:paginate',
            'value' => 10,
        ]);
    }
}
