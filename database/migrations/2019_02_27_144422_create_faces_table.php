<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('用户ID');
            $table->string('code')->nullable()->comment('用户标识码');
            $table->string('id_card')->nullable()->comment('身份证号码');
            $table->string('img')->nullable()->comment('身份证照片');
            $table->integer('verify_time')->nullable()->comment('验证时间');
            $table->tinyInteger('status')->default(0)->comment('状态0默认1已通过-1未通过');
            $table->integer('payment_id')->nullable()->comment('验证使用的支付号');
            $table->string('out_trade_no')->nullable()->comment('验证使用的支付订单号');
            $table->text('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('faces');
    }
}
