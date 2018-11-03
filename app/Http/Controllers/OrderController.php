<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //订单列表
    public function index(Request $request){
        $wheres=[];
        $wheres[]= ['shop_id',Auth::user()->shop_id];
        if($request->createAt==1){
            $wheres[]=['created_at','>=',date('y-m-d 00:00:00')];
        }elseif($request->createAt==2){
            $wheres[]=['created_at','>=',date('y-m-d 00:00:00',strtotime('-7 day'))];
        }elseif($request->createAt==3){
            $wheres[]=['created_at','>=',date('y-m-d 00:00:00',strtotime('-1 month'))];
        }
        $orders=Order::where($wheres)->orderBy('id','desc')->paginate(10);
        if($request->keywords){
            $wheres[]=['name','like',"%{$request->keywords}%"];
            $orders=Order::where($wheres)
                ->orWhere('tel','like',"%{$request->keywords}%")
                ->orWhere('sn','like',"%{$request->keywords}%")
                ->orderBy('id','desc')->paginate(10);
        }
        return view('order.index',['orders'=>$orders]);
    }
    //订单详细
    public function show(Order $order){
        return view('order.show',compact('order'));
    }
}
