@extends('common.default')
@section('contents')
<div class="modal-header">
    <h4 class="pull-left">订单列表 </h4>
</div>
<div class="modal-body clearfix" style="padding: 15px 0px;">
    <form action="{{route('order.index')}}" method="get" class="form-inline pull-left">
        <select name="createAt" class="form-control">
            <option value=" ">按日期查找</option>
            <option value="1">今日订单</option>
            <option value="2">本周订单</option>
            <option value="3">近1月订单</option>
        </select>
        <input type="text" name="keywords" placeholder="订单号/姓名/电话" class="form-control"/>
        {{csrf_field()}}
        <input type="submit" value="搜索" class="btn btn-success"/>
    </form>
    <div class="btn-group pull-right" role="group" aria-label="...">
        <a href="{{route('order.index')}}" class="btn btn-default" id="btn1">全部</a>
        <a href="{{route('order.index',['status'=>'unPay'])}}" class="btn btn-default" id="btn1">待支付</a>
        <a href="{{route('order.index',['status'=>'unSend'])}}" class="btn btn-default" id="btn2">待发货</a>
        <a href="{{route('order.index',['status'=>'unSure'])}}" class="btn btn-default" id="btn3">待确认</a>
        <a href="{{route('order.index',['status'=>'success'])}}" class="btn btn-default" id="btn3">已完成</a>
    </div>

</div>

<table class="table table-hover table-bordered text-center" >
    <thead>
    <tr class="active">
        <th class="text-center">订单编号</th>
        <th class="text-center">客户</th>
        <th class="text-center">消费商品</th>
        <th class="text-center">消费金额</th>
        <th class="text-center">时间</th>
        <th class="text-center">订单状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
    <tr>
        <td>{{$order->sn}}</td>
        <td>{{$order->name}}<br/>{{$order->tel}}</td>
        <td><h5>
            <a href="{{route('order.show',[$order])}}" class="text-primary">
            @foreach($order->goods as $k=>$goods)
                @if($k<2)
                {{$goods->goods_name}} +
                @endif
            @endforeach
            </a></h5>
        </td>
        <td><h4 class="text-danger">{{$order->total}}</h4></td>
        <td>{{$order->created_at}}</td>
        <td>@if($order->status==-1) <span>已取消</span>
            @elseif($order->status==0) <span class="text-danger">待支付</span>
            @elseif($order->status==1) <a href="" class="btn btn-warning">发  货</a>
            @elseif($order->status==2) <span class="text-primary">待确认</span>
            @elseif($order->status==3) <span class="text-success">已完成</span>
            @endif</td>
        <td>
            @if($order->status==0)
            <a href="{{route('order.updateStatus',[$order])}}" class="btn btn-default">取消订单</a>
            @else
            <a href="{{route('order.show',[$order])}}" class="btn btn-success"><span class="glyphicon glyphicon-search"></span> 查看</a>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<!-- 分页 -->
{{ $orders->appends(request()->except('page'))->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')

@endsection


