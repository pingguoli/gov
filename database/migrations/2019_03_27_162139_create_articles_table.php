<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('文章标题');
            $table->string('subtitle')->nullable()->comment('副标题');
            $table->string('keywords')->nullable()->comment('关键字');
            $table->string('description')->nullable()->comment('文章描述');
            $table->string('author')->nullable()->comment('文章作者');
            $table->string('source')->nullable()->comment('文章来源');
            $table->text('content')->comment('文章内容');
            $table->string('thumb')->nullable()->comment('封面');
            $table->integer('sort')->default(0)->comment('排序');
            $table->unsignedInteger('views')->default(0)->comment('浏览数');
            $table->tinyInteger('top')->default(0)->comment('置顶');
            $table->tinyInteger('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('articles');
    }
}
