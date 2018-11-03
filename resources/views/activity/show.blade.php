@extends('common.default')
@section('contents')
    <div class="modal-header">
        <h1 class="text-center">{{$activity->title}}</h1>
    </div>
    <div class="modal-body">
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <span class="col-sm-3">开始时间：{{$activity->start_time}}</span>
                    <span class="col-sm-3">结束时间：{{$activity->end_time}}</span>
                </div>
            </li>
            <li class="list-group-item">
                活动内容
                <div>{!! $activity->content !!}</div>
            </li>
        </ul>
    </div>
@endsection