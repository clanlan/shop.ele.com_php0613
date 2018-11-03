@extends('common.default')
@section('contents')
    <div class="col-md-8 ">
        <div class="modal-header">
            <h2 class="text-center">新增分类</h2>
        </div>
        <div class="modal-body">
            <form action="{{route('goodsCategory.store')}}" method="post" enctype="multipart/form-data">
                <div class="form-group form-group-lg">
                    <label>分 类 名：</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}"/>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group form-group-lg">
                    <label>描述：</label>
                    <textarea class="form-control" rows="5" name="description">{{old('description')}} </textarea>
                    <span class="text-danger"></span>
                </div>
                <div class="form-group form-group-lg">
                    <label> 默认分类：</label>
                    <label><input type="radio" name="is_selected" value="1"/> 是 </label>
                    <label><input type="radio" name="is_selected" value="0" checked/> 否 </label>
                </div>

                {{ csrf_field() }}
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg btn-block"> 提交分类</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('common._img_js')