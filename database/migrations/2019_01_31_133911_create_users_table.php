<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('姓名');
            $table->string('code', 190)->unique()->nullable()->comment('用户唯一识别码');
            $table->string('id_card', 190)->unique()->nullable()->comment('身份证号码');
            $table->tinyInteger('sex')->default(0)->comment('性别(0默认1男2女)');
            $table->string('mobile', 190)->unique()->nullable()->comment('手机号');
            $table->string('email', 190)->unique()->nullable()->comment('邮箱');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('birthday')->nullable()->comment('生日');
            $table->string('nationality')->nullable()->comment('国籍');
            $table->string('address')->nullable()->comment('住址');
            $table->string('education')->nullable()->comment('学历');
            $table->string('img')->nullable()->comment('照片');
            $table->tinyInteger('id_card_type')->default(0)->comment('证件类型(0默认1身份证2户口3护照)');
            $table->string('id_card_face')->nullable()->comment('身份证头像面照片');
            $table->string('id_card_nation')->nullable()->comment('身份证国徽面照片');
            $table->string('house_img')->nullable()->comment('户口照片');
            $table->string('passport_img')->nullable()->comment('护照照片');
            $table->string('password')->nullable()->comment('密码');
            $table->tinyInteger('type')->default(0)->comment('类型(0默认1选手2教练3裁判4解说员5数据分析师)');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->tinyInteger('step')->default(0)->comment('注册到的位置');
            $table->tinyInteger('is_complete')->default(0)->comment('是否注册完成');
            $table->integer('register_time')->nullable()->comment('注册成功时间');
            $table->ipAddress('last_login_ip')->nullable()->comment('最后登录IP');
            $table->integer('last_login_time')->nullable()->comment('最后登录时间');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
