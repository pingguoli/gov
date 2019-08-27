<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->comment('上级id');
            $table->string('name')->comment('名称');
            $table->tinyInteger('position')->default(0)->comment('导航位置(0默认导航1顶部导航2底部导航)');
            $table->tinyInteger('type')->default(1)->comment('类型(1链接2分类3单页4文章)');
            $table->tinyInteger('target')->default(0)->comment('是否新建标签(0 _self,1 _blank)');
            $table->string('link')->nullable()->comment('URL');
            $table->integer('category_id')->default(0)->comment('分类ID');
            $table->integer('page_id')->default(0)->comment('单页ID');
            $table->integer('article_id')->default(0)->comment('文章ID');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('navigations');
    }
}
