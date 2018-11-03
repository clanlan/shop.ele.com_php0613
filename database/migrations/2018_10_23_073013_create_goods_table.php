<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_name');
            $table->float('rating')->default(5)->comment('评分');
            $table->integer('shop_id')->comment('所属商家id');
            $table->integer('category_id')->comment('所属分类id');
            $table->float('goods_price')->default(0)->comment('价格');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('month_sales')->default(0)->comment('月销量');
            $table->integer('rating_count')->default(0)->comment('评分数量');
            $table->string('tips')->nullable()->comment('提示信息');
            $table->integer('satisfy_count')->default(0)->comment('满意度数量');
            $table->float('satisfy_rate')->default(0)->comment('满意度评分');
            $table->string('goods_img')->nullable()->comment('商品图片');
            $table->tinyInteger('status')->default(0)->comment('状态1上架0下架');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
