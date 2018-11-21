@extends('common.default')
@section('contents')
<div class="modal-header">
	<h2>最新试用</h2>
</div>
<div class="modal-body row">
@foreach($prizes as $prize)
	<div class="col-sm-6 col-md-4 col-lg-3">
		<div class="thumbnail">
			<a href="{{route('prize.show',[$prize])}}"><img src="{{$prize->img}}" /></a>
			<div class="caption">
				<h3>{{$prize->title}}</h3>
				<p>提供<span class="text-danger">{{$prize->amount}}</span>份 | 已有<span class="text-danger">{{count($prize->member)}}</span>人申请</p>
				@if($prize->is_prize==1)
                    <p><a href="{{route('prize.show',[$prize]) }}" class="btn btn-success btn-block" role="button">查看中奖名单</a></p>
                @elseif($prize->signup_end <= time() && $prize->is_prize==0)
                    <p><a class="btn btn-warning btn-block" role="button">报名已截止,等待开奖中...</a></p>
                @else
                    <p class="newtime" data-time="{{$prize->signup_end}}" > 倒计时 </p>
                    <p><a href="{{route('prize.apply',[$prize]) }}" class="btn btn-danger btn-block" role="button">申请试用</a></p>
                @endif
			</div>
		</div>
	</div>

@endforeach

</div>
<script>
    var runtimes = 0;
    function GetRTime(){
        var nMS = @php  echo ($prize->signup_end)-time(); @endphp *1000 - runtimes*1000;

        if (nMS>=0){
            var nD=Math.floor(nMS/(1000*60*60*24))%24;
            var nH=Math.floor(nMS/(1000*60*60))%24;
            var nM=Math.floor(nMS/(1000*60)) % 60;
            var nS=Math.floor(nMS/1000) % 60;
            var newtime=nD+'天'+nH+'小时'+nM+'分'+nS+'秒';
            $('.newtime').html(newtime);
            runtimes++;
            setTimeout("GetRTime()",1000);
        }
    }
    window.onload = function() {
        GetRTime();
    }
</script>

@endsection