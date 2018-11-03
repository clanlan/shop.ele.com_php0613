<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //获取订单所属商家信息 1对多反向
    public function shop(){
        return $this->belongsTo(Shop::class,'shop_id');
    }
    //获取订单详情信息 1对多
    public function goods(){
        return $this->hasMany(OrderDetail::class,'order_id');
    }

}
