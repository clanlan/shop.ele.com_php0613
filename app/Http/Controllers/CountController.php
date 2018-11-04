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
        if(!$user){
            return redirect()->route('login')->with('danger','您没有权限,请先登录');
        }
        $shop=Shop::find($user->shop_id);
        //最近1周订单量统计
        $time_start=date('Y-m-d 00:00:00',strtotime('-7 day'));
        $time_end=date('Y-m-d 23:59:59');
        $sql="select date(created_at) as date,count(*) as count from orders where created_at >= '{$time_start}' and created_at <= '{$time_end}' and shop_id={$user->shop_id} GROUP by date(created_at)";
        $rows=DB::select($sql);
        //构造7天统计格式
        $orderWeeks=[];
        for($i=6;$i>=0;$i--){
            $orderWeeks[date('Y-m-d',strtotime("-{$i} day"))]=0;
        }//重写数组 使它符合需要的格式
        foreach($rows as $row){
            $orderWeeks[$row->date]=$row->count;
        }


        //最近一周菜品销量
        $rows2=DB::select("SELECT
                DATE(orders.created_at) AS date,order_details.goods_id,
                SUM(order_details.amount) AS amount
                FROM order_details
                JOIN orders ON order_details.order_id = orders.id
                WHERE orders.created_at >= '{$time_start}' and orders.created_at <= '{$time_end}'
                AND shop_id = {$shop->id}
                GROUP BY DATE(orders.created_at),order_details.goods_id");
        //构造7天统计标准格式
        $goodsWeeks=[];
        //获取当前商家的菜品列表
        $goodses=Goods::where('shop_id',$shop->id)->select(['id','goods_name'])->get();
        //让goodsList保留id=>name格式;
        $keyed=$goodses->mapWithKeys(function ($item){
            return [$item['id']=>$item['goods_name']];
        });
        //得到新的商品列表一维数组
        $goodses=$keyed->all();
        //dd($goodses);
        //得到近一周的日期
        $week=[];
        for ($i=6;$i>=0;$i--){
            $week[] = date('Y-m-d',strtotime("-{$i} day"));
        }
        //dd($week);
        //将统计出的数据格式转换成前端表格所需要的格式goods_id=>(array)date=>amount
        foreach ($goodses as $id=>$name){
            foreach ($week as $day){
                $goodsWeeks[$id][$day] = 0;
            }
        }
        //dd($goodsWeeks);
        //将sql查询出的数据填入标准格式
        foreach ($rows2 as $row2){
            $goodsWeeks[$row2->goods_id][$row2->date]=$row2->amount;
        }
        //dd($goodsWeeks);
        //前端图形数据
        $series = [];
        foreach ($goodsWeeks as $id=>$data){
            $serie = [
                'name'=> $goodses[$id],
                'type'=>'line',
                'data'=>array_values($data)
            ];
            $series[] = $serie;
        }

        //最近3个月订单量统计
        $month_start=date('Y-m-d 00:00:00',strtotime('-2 month'));
//        $rows3=DB::select("SELECT MONTH (created_at) AS month,count(*) as count
//            FROM orders WHERE created_at >= '{$month_start}'
//            AND created_at <= '{$time_end}' AND shop_id = {$shop->id}
//            GROUP BY MONTH(created_at)
//        ");
//
        $rows3=DB::select("SELECT MONTH(orders.created_at) AS month,count(orders.id) AS count,sum(order_details.amount*order_details.goods_price) as money
            FROM orders JOIN order_details ON orders.id=order_details.order_id WHERE orders.created_at >= '{$month_start}'
            AND orders.created_at <= '{$time_end}' AND shop_id = {$shop->id}
            GROUP BY MONTH(orders.created_at)
");
        //构造3个月统计格式
        $orderMonths=[];
        $money=[];
        for($i=2;$i>=0;$i--){
            $orderMonths[date('Y-m',strtotime("-{$i} month"))]=0;
            $money[date('Y-m',strtotime("-{$i} month"))]=0;
        }
        foreach($rows3 as $row3){
            $orderMonths[date('Y-'.str_pad($row3->month,2,0,0))]=$row3->count;
            $money[date('Y-'.str_pad($row3->month,2,0,0))]=$row3->money;
        }
        //dd($orderMonths);
        //重写数组 使它符合需要的格式





        //最近3个月菜品销量统计
        $rows4=DB::select("SELECT
        MONTH(orders.created_at) AS month,sum(order_details.amount) as amount,order_details.goods_id as goods_id
        FROM orders JOIN order_details on orders.id=order_details.order_id
        WHERE orders.created_at >= '{$month_start}' AND orders.created_at <= '{$time_end}' AND shop_id = {$shop->id}
        GROUP BY  MONTH(orders.created_at),goods_id
        ");
        $goodsMonths=[];
        //得到3个月日期格式
        $Months=[];
        for($i=2;$i>=0;$i--){
            $Months[]=date('Y-m',strtotime("-{$i} month"));
        }

        //将统计出的数据格式转换成前端表格所需要的格式goods_id=>(array)date=>amount
        foreach ($goodses as $id=>$name){
            foreach ($Months as $month){
                $goodsMonths[$id][$month] = 0;
            }
        }
        //dd($goodsMonths);
        //将sql查询出的数据填入标准格式
        foreach ($rows4 as $row4){
            $goodsMonths[$row4->goods_id][date('Y-'.str_pad($row4->month,2,0,0))]=$row4->amount;
        }
        //dd($goodsMonths);
        //前端图形数据
        $series2 = [];
        foreach ($goodsMonths as $id=>$data){
            $serie = [
                'name'=> $goodses[$id],
                'type'=>'line',
                'data'=>array_values($data)
            ];
            $series2[] = $serie;
        }




        return view('index',compact('user','shop','orderWeeks','goodsWeeks','goodses','week','series','orderMonths','money','Months','goodsMonths','series2'));
    }

}
