<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 190)->unique()->comment('用户名');
            $table->string('password')->nullable()->comment('密码');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('real_name')->nullable()->comment('真实姓名');
            $table->string('id_card')->nullable()->comment('身份证号码');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('img')->nullable()->comment('头像');
            $table->string('address')->nullable()->comment('地址');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->tinyInteger('type')->default(0)->comment('账号类型(0默认所有1平台管理2项目管理)');
            $table->tinyInteger('project_id')->default(0)->comment('项目管理账号标识');
            $table->ipAddress('last_login_ip')->nullable()->comment('最后登录IP');
            $table->integer('last_login_time')->nullable()->comment('最后登录时间');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
