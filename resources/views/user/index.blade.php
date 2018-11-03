@extends('common.default')
@section('cont-lg')
	@include('common._errors')
	<div class="container">

		<h2>亲爱的<strong class="text-success">@if(isset($user)){{$user->name}}@else游客@endif</strong> ，您好！</h2>
		<h1><span class="text-success">@if(isset($shop)){{$shop->shop_name}}@else ele购物网 @endif</span> ，欢迎您！</h1>


	</div>



@endsection