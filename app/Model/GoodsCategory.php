<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    protected $fillable=['name','is_selected','description','shop_id','type_accumulation'];
}
