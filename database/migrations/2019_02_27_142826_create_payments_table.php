<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('用户ID');
            $table->string('code')->nullable()->comment('用户标识码');
            $table->string('out_trade_no')->nullable()->comment('订单号');
            $table->decimal('total_fee', 20)->default(0)->comment('订单总金额');
            $table->string('description')->nullable()->comment('支付单简要描述');
            $table->string('payment_method')->nullable()->comment('支付方式');
            $table->string('payment_code')->nullable()->comment('支付单号(如:微信支付订单号)');
            $table->integer('payment_time')->nullable()->comment('支付时间');
            $table->text('payment_result')->nullable()->comment('支付返回信息(json格式存储)');
            $table->tinyInteger('status')->default(0)->comment('状态0默认(未支付)1已支付');
            $table->tinyInteger('is_used')->default(0)->comment('是否使用');
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
        Schema::dropIfExists('payments');
    }
}
