@extends('common.default')
@section('contents')
<div class="clearfix">
    <h4 class="pull-left">商品分类列表 </h4>
    <a href="{{route('goodsCategory.create')}}" class="btn btn-success pull-right">添加分类</a>
</div>


<table class="table table-hover table-bordered text-center" >
    <thead>
    <tr class="active">
        <th class="text-center">序号</th>
        <th class="text-center">分类名</th>
        <th class="text-center">描述</th>
        <th class="text-center">默认分类</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($goodsCategories as $k => $goodsCategory)
        <tr>
            <td>{{$k+1}}</td>
            <td>{{$goodsCategory->name}}</td>
            <td>{{$goodsCategory->description}}</td>
            <td>
                @if($goodsCategory->is_selected==1)<span class="text-success">是</span>
                @elseif($goodsCategory->is_selected==0)否 @endif
            </td>
            <td>
                <a href="{{ route('goodsCategory.edit',[$goodsCategory]) }}" class="btn btn-success btn-sm">修改</a>
                <a href="javascript:;" data-href="{{route('goodsCategory.destroy',[$goodsCategory])}}" class="del_btn btn btn-danger btn-sm">删除</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<!-- 分页 -->
{{ $goodsCategories->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')
@endsection