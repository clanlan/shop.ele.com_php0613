<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{

    protected $fillable=['goods_name','rating','shop_id','category_id','goods_price',
        'keywords','description','month_sales','rating_count','tips','satisfy_count','satisfy_rate','goods_img','status'];


    //获取菜品所属商家 1对多反向
    public function GoodsCategory(){
        return $this->belongsTo(GoodsCategory::class,'category_id');
    }
}
