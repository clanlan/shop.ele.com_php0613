<?php

namespace App\Http\Controllers;

use App\Model\Goods;
use App\Model\OrderDetail;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CountController extends Controller
{
    //首页
    public function index(){
        $user=Auth::user();
        $shop=Shop::find($user->shop_id);
        //最近1周订单量统计
        $time_start=date('Y-m-d 00:00:00',strtotime('-7 day'));
        $time_end=date('Y-m-d 23:59:59');
        $sql="select date(created_at) as date,count(*) as count from orders where created_at >= '{$time_start}' and created_at <= '{$time_end}' and shop_id={$user->shop_id} GROUP by date(created_at)";
        $rows=DB::select($sql);
        //构造7天统计格式
        $orderWeeks=[];
        for($i=7;$i>0;$i--){
            $orderWeeks[date('Y-m-d',strtotime("-{$i} day"))]=0;
        }//重写数组 使它符合需要的格式
        foreach($rows as $row){
            $orderWeeks[$row->date]=$row->count;
        }

        //最近一周菜品销量
        $sql2="select date(orders.created_at) as date,order_details.goods_id as goods_id,sum(order_details.amount) as amount
        from orders JOIN order_details on orders.id=order_details.order_id 
        where orders.created_at >= '{$time_start}' and orders.created_at <= '{$time_end}' and orders.shop_id={$user->shop_id} 
        GROUP by date,goods_id";
        $rows2=DB::select($sql2);
        //dd($rows2);
        $goodsWeeks=[];
        //得到商品名称

        $goods=Goods::where('shop_id',$shop->id)->select(['id','goods_name'])->get();
        $keyed=$goods->mapWithKeys(function ($item){
            return [$item['id']=>$item['goods_name']];
        });
        $keyed2=$goods->mapWithKeys(function ($item){
            return [$item['id']=>0];
        });
        $goods=$keyed->all();
        $week=[];
        for ($i=7;$i>0;$i--){
            $week[] = date('Y-m-d',strtotime("-{$i} day"));
        }
        foreach ($goods as $id=>$name){
            foreach ($week as $day){
                $goodsWeeks[$id][$day] = 0;
            }
        }
        /**/
        //dd($result);
        foreach ($rows2 as $row2){
            $goodsWeeks[$row2->goods_id][$row2->date]=$row2->amount;
        }
        $series = [];
        foreach ($goodsWeeks as $id=>$data){
            $serie = [
                'name'=> $goods[$id],
                'type'=>'line',
                'stack'=> '销量',
                'data'=>array_values($data)
            ];
            $series[] = $serie;
        }
        return view('index',compact('user','shop','orderWeeks','goodsWeeks','goods','week','series'));
    }
}
