@extends('common.default')
@section('contents')
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">订单编号: {{$order->sn}}
    <span class="pull-right">订单状态: @if($order->status==-1) 已取消
        @elseif($order->status==0) 待支付
        @elseif($order->status==1) 待发货
        @elseif($order->status==2) 待确认
        @elseif($order->status==3)已完成
        @endif</span></div>
    <div class="panel-body text-primary">
        <div class="row">
        <div class="col-xs-1 text-center"><h2 class="glyphicon glyphicon-map-marker"></h2></div>
        <div class="col-xs-11"><h4 class="clearfix"><span class="pull-left">收货人: {{$order->name}}</span><span class="pull-right">电话: {{$order->tel}}</span></h4>
        <h4>收获地址: {{$order->province.$order->city.$order->county.$order->address}}</h4></div>
        </div>
    </div>

    <!-- List group -->
    <ul class="list-group">
        <li class="list-group-item  disabled">
            <div class="row">
                <div class="col-xs-3 text-right">商品图片</div>
                <div class="col-xs-4">商品名称</div>
                <div class="col-xs-2">数量</div>
                <div class="col-xs-3 text-right">单价</div>
            </div>
        </li>
        @foreach( $order->goods as $goods)
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-3 text-right">
                    @if($goods->goods_img)<img src="{{$goods->goods_img}}" height="50"/>@endif
                </div>
                <div class="col-xs-4"><h4>{{$goods->goods_name}}</h4></div>
                <div class="col-xs-1"><h4>{{$goods->amount}}</h4></div>
                <div class="col-xs-4 text-right"><h4>￥{{$goods->goods_price}}</h4></div>
            </div>
        </li>
        @endforeach
    </ul>
    <div class="panel-footer">
        <div class="row">
            <div class="col-xs-4">
                <p>订单总价: </p>
                <h3 class="text-danger">￥{{$order->total}}</h3>
            </div>
            <div class="col-xs-8 text-right">
                <p>下单时间: {{$order->created_at}}</p>
                @if($order->status==0) <a href="{{route('order.updateStatus',$order)}}" class="btn btn-warning">取消订单</a>
                @elseif($order->status==1))<a href="" class="btn btn-warning">发  货</a>
                @endif
                <a href="{{route('order.index')}}" class="btn btn-default">返回</a>
            </div>
        </div>

    </div>
</div>

@endsection