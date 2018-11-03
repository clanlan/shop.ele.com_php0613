<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeyShopidGoodsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //goods_categories表的shop_id添加外键,引用shops表的id
        Schema::table('goods_categories', function (Blueprint $table) {
            $table->integer('shop_id')->unsigned()->change();
            $table->foreign('shop_id')->references('id')->on('shops');
        });
        //goods表的shop_id关联shops表的id
        Schema::table('goods', function (Blueprint $table) {
            $table->integer('shop_id')->unsigned()->change(); //无符号

            $table->foreign('shop_id')->references('id')->on('shops');
            //goods表的category_id关联goods_categories表的id
            $table->integer('category_id')->unsigned()->change();
            $table->foreign('category_id')->references('id')->on('goods_categories');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
