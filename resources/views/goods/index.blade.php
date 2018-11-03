@extends('common.default')
@section('contents')
<div class="modal-header">
    <h4 class="pull-left">商品列表 </h4>
    <a href="{{route('goods.create')}}" class="btn btn-success pull-right">添加商品</a>
</div>
<div class="modal-body clearfix" style="padding: 15px 0px;">
    <form action="{{route('goods.index')}}" method="get" class="form-inline pull-left">
        <select name="category_id" class="form-control">
            <option value=" ">请选择商品分类</option>
            @foreach($cates as $cate)
                <option value="{{$cate->id}}">{{$cate->name}}</option>
            @endforeach
        </select>
        <input type="text" name="keywords" placeholder="关键字" class="form-control"/>
        <label>价格：</label>
        <input type="text" name="min_price" placeholder="0" class="form-control"  value="{{old('min_price')}}" style="width: 80px"/>-
        <input type="text" name="max_price" class="form-control" value="{{old('max_price')}}"  style="width: 80px"/>
        {{csrf_field()}}
        <input type="submit" value="搜索" class="btn btn-success"/>
    </form>
    <div class="btn-group pull-right" role="group" aria-label="...">
        <button type="button" onclick="location.href='{{route('goods.price')}}'" class="btn btn-default" id="btn1"><span class="glyphicon glyphicon-arrow-up" style="color:#aaaaaa"></span> 价格</a>
        <button type="button" class="btn btn-default" id="btn2"><span class="glyphicon glyphicon-arrow-down" style="color:#aaaaaa"></span> 评分</button>
        <button type="button" class="btn btn-default" id="btn3"><span class="glyphicon glyphicon-arrow-down" style="color:#aaaaaa"></span> 销量</button>
    </div>

</div>
<table class="table table-hover table-bordered text-center" >
    <thead>
    <tr class="active">
        <th class="text-center">编号</th>
        <th class="text-center">商品图片</th>
        <th>商品名称</th>
        <th class="text-center">分类</th>
        <th class="text-center">评分</th>
        <th class="text-center">价格</th>
        <th class="text-center">销量</th>
        <th class="text-center">状态</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($goods as $k=>$good)
        <tr>
            <td>{{$good->id}}</td>
            <td>@if($good->goods_img)<img src="{{$good->goods_img}}" height="50"/>@endif</td>
            <td class="text-left">
                <h4><a href="{{route('goods.show',[$good])}}">{{$good->goods_name}}</a> </h4></td>
            <td>{{$good->GoodsCategory->name}}</td>
            <td>
                {{$good->rating}}分<br>
                {{$good->rating_count}}次
            </td>
            <td><h4 class="text-danger">{{$good->goods_price}}</h4></td>
            <td><h5 class="text-success">{{$good->month_sales}}</h5></td>
            <td>@if($good->status==1)
                <h6>正常</h6>
                @else
                <h6 class="text-danger">已下架</h6>
                @endif</td>
            <td>

                <a href="{{ route('goods.show',[$good]) }}" class="btn btn-default btn-sm">查看</a>
                <a href="{{ route('goods.edit',[$good]) }}" class="btn btn-success btn-sm">修改</a>
                <a href="javascript:;" data-href="{{route('goods.destroy',[$good])}}" class="del_btn btn btn-danger btn-sm">删除</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<!-- 分页 -->
{{ $goods->appends(request()->except('page'))->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')

@endsection


