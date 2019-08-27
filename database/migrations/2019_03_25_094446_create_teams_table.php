<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_id')->comment('项目ID');
            $table->string('name')->nullable()->comment('战队名称');
            $table->string('logo')->nullable()->comment('战队Logo');
            $table->integer('point')->default(0)->comment('积分');
            $table->integer('user_project_id')->comment('战队队长ID');
            $table->tinyInteger('status')->default(0)->comment('状态0默认1审核中2审核通过-1驳回-2已解散');
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
        Schema::dropIfExists('teams');
    }
}
