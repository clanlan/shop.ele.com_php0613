<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type_accumulation')->default(0)->comment('菜品编号');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('shop_id')->comment('所属商家id');
            $table->tinyInteger('is_selected')->default(0)->comment('1是0否默认分类');
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
        Schema::dropIfExists('goods_categories');
    }
}
