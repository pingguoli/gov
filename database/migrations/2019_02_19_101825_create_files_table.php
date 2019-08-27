<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', \App\Model\File::$types)->comment('文件类型');
            $table->string('disk')->comment('存盘位置');
            $table->string('path')->comment('文件路径');
            $table->string('mime')->comment('文件mimeType');
            $table->char('hash', 190)->comment('Hash');
            $table->string('title')->comment('文件标题');
            $table->integer('size')->default(0)->comment('文件大小');
            $table->smallInteger('width')->default(0)->comment('宽度');
            $table->smallInteger('height')->default(0)->comment('高度');
            $table->timestamps();
            $table->unique('hash');
            $table->index('type');
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
        Schema::dropIfExists('files');
    }
}
