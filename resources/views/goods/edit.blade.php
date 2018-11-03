@extends('common.default')
@section('contents')
	<div class="modal-header">
		<h2 class="text-center">添加商品</h2>
	</div>
	<div class="modal-body">
		<form action="{{route('goods.update',[$good])}}" method="post" enctype="multipart/form-data" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">商品名称：</label>
				<div class="col-sm-8"><input type="text" name="goods_name" class="form-control" value="{{$good->goods_name}}"/></div>
				<span class="text-danger col-sm-2">*{{$errors->first('goods_name')}}</span>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">商品分类：</label>
				<div class="col-sm-8">
					<select name="category_id" class="form-control">
						<option value=" ">请选择商品分类</option>
						@foreach($cates as $cate)
							<option value="{{$cate->id}}" @if($good->category_id == $cate->id) selected @endif>{{$cate->name}}</option>
						@endforeach
					</select>
				</div>
				<span class="text-danger col-sm-2">*{{$errors->first('category_id')}}</span>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">价格：</label>
				<div class="col-sm-8">
					<div class="input-group">
						<div class="input-group-addon">￥</div>
						<input type="text" name="goods_price" class="form-control" id="exampleInputAmount" value="{{$good->goods_price}}" placeholder="金额">
						<div class="input-group-addon">元</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">商品描述：</label>
				<div class="col-sm-8">
					@include('vendor.ueditor.assets')
					<!-- 实例化编辑器 -->
					<script type="text/javascript">
						var ue = UE.getEditor('container');
						ue.ready(function() {
							ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
						});
					</script>
					<!-- 编辑器容器 -->
					<script id="container" name="description" type="text/plain">{!! $good->description !!} </script>


				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">提示信息：</label>
				<div class="col-sm-8"><input type="text" name="tips" class="form-control" value="{{$good->tips}}"/></div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">店铺状态：</label>
				<div class="col-sm-8">
					<div class="col-md-2">
						<label><input type="radio" name="status" value="1" @if($good->status==1)checked @endif /> 上架 </label></div>
					<div class="col-md-2">
						<label><input type="radio" name="status" value="0"  @if($good->status==0)checked @endif /> 下架 </label>
					</div>
				</div>
			</div>


			<div class="clearfix form-group">
				<label class="control-label col-sm-2">店铺图片：</label>
				<div class="col-sm-2"><img id="face" src=" @if ($good->goods_img) {{$good->goods_img}} @else /images/a.png @endif" alt="图片上传" width="100" style="cursor: pointer" onclick="test()" /></div>
				<div class="col-sm-8">
					<input type="file" name="goods_img" id="file" onchange="preview(this)"/>
					<h6>图片格式:jpg、jpeg、png、gif，图片大小不能超过2M</h6>
					<h5 id="err" class="text-danger"></h5>
				</div>
			</div>

			{{ csrf_field() }}
			{{method_field('PUT')}}
			<div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-8">
					<button type="submit" class="btn-success btn-lg btn-block"> 立即添加</button>
				</div>
			</div>
		</form>
	</div>


@endsection
@include('common._img_js')