<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTeamRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_team_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_project_id')->comment('项目账号ID');
            $table->integer('team_id')->nullable()->comment('战队ID');
            $table->string('message')->nullable()->comment('附带留言');
            $table->tinyInteger('status')->default(0)->comment('状态0默认1同意-1拒绝');
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
        Schema::dropIfExists('user_team_records');
    }
}
