<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('code')->nullable()->comment('验证码');
            $table->string('type')->nullable()->comment('类型');
            $table->integer('expired_time')->default(0)->comment('过期时间');
            $table->tinyInteger('is_verify')->default(0)->comment('是否验证过(0未验证1已验证)');
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
        Schema::dropIfExists('sms_codes');
    }
}
