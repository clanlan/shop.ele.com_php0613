@extends('common.default')
@section('contents')
<div class="modal-header">
    <h1 class="text-center">{{$good->goods_name}}</h1>
</div>
<div class="modal-body">
    <ul class="list-group">
        <li class="list-group-item">商品图片：@if($good->goods_img)
                <img src="{{$good->goods_img}} " width="200"/>@endif</li>
        <li class="list-group-item">
            <div class="row">
            <span class="col-sm-3">商品价格：<strong class="text-danger">{{$good->goods_price}}</strong></span>
            <span class="col-sm-3">商品分类：{{$good->GoodsCategory->name}}</span>
            <span class="col-sm-3">商品评分：{{$good->rating}}</span>
            <span class="col-sm-3">评分数量：{{$good->rating_count}}</span>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
            <span class="col-sm-3">月销量：{{$good->month_sales}}</span>
            <span class="col-sm-3">满意度数量：{{$good->satisfy_count}}</span>
            <span class="col-sm-3">满意度评分：{{$good->satisfy_rate}}</span>
            <span class="col-sm-3">商品状态：@if($good->status==1)
                <span class="text-success">售卖中</span>
            @else
                <span class="text-danger">已下架</span>
            @endif</span>
            </div>
        </li>

        <li class="list-group-item">商品描述:<div>{!! $good->description !!}</div></li>
        <li class="list-group-item">提示信息：{{$good->tips}}</li>
    </ul>

    <div class="row">
        <label class="col-sm-3"></label>
        <div class="col-sm-3">
            <a href="{{ route('goods.edit',[$good]) }}" class="btn btn-success btn-block">修改</a>
        </div>
        <div class="col-sm-3">
            @if($good->status==1)
            <a href="{{ route('goods.edit',[$good]) }}" class="btn btn-warning btn-block">立即下架</a>
            @else
            <a href="{{ route('goods.edit',[$good]) }}" class="btn btn-primary btn-block">立即上架</a>
            @endif
        </div>

    </div>
</div>
@endsection