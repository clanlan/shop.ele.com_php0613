@extends('common.default')
@section('contents')
	<div class="col-md-8 ">
		<div class="modal-header">
			<h2 class="text-center">修改分类</h2>
		</div>
		<div class="modal-body">
			<form action="{{route('goodsCategory.update',[$goodsCategory])}}" method="post" enctype="multipart/form-data">
				<div class="form-group form-group-lg">
					<label>分 类 名：</label>
					<input type="text" name="name" class="form-control" value="{{$goodsCategory->name}}"/>
					<span class="text-danger">{{$errors->first('name')}}</span>
				</div>
				<div class="form-group form-group-lg">
					<label>描述：</label>
					<textarea class="form-control" rows="5" name="description">{{$goodsCategory->description}} </textarea>
					<span class="text-danger">{{$errors->first('description')}}</span>
				</div>
				<div class="form-group form-group-lg">
					<label> 默认分类：</label>
					<label><input type="radio" name="is_selected" value="1"
								  @if($goodsCategory->is_selected==1) checked @endif/> 是 </label>
					<label><input type="radio" name="is_selected" value="0"
								  @if($goodsCategory->is_selected==0) checked @endif/> 否 </label>
				</div>

				{{ csrf_field() }}
				{{method_field('PUT')}}
				<div class="text-center">
					<button type="submit" class="btn btn-success btn-lg btn-block"> 提交分类</button>
				</div>
			</form>
		</div>
	</div>
@endsection
@include('common._img_js')