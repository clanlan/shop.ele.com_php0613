@extends('common.default')
@section('contents')
<div class="clearfix">
	<h4 class="pull-left">活动列表 </h4>


</div>
<table class="table table-bordered ">
	<tr>
		<td>ID</td>
		<td>标题</td>
		<td>开始时间</td>
		<td>结束时间</td>
		<td>操作</td>
	</tr>

	@foreach ($activities as $activity)
		<tr>
			<td>{{ $activity->id }}</td>
			<td><a href="{{ route('activity.show',[$activity]) }}"><strong>{{ $activity->title }}</strong></a></td>
			<td>{{ $activity->start_time }}</td>
			<td>{{ $activity->end_time }}</td>
			<td>
				<a href="{{ route('activity.show',[$activity]) }}" class="btn btn-success btn-sm">查看</a>
			</td>
		</tr>
	@endforeach
</table>
<!-- 分页 -->
{{ $activities->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')
@endsection