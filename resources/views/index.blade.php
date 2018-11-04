@extends('common.default')
@section('contents')
@include('common._errors')

<h2><img src="{{$shop->shop_img}}" height="60px"/> <span class="text-danger">{{$shop->shop_name}}</span> </h2>

<div class="panel panel-default">
	<div class="panel-heading"><strong>最近一周订单量统计</strong></div>
	<table class="table table-bordered text-center">
		<tr>
            @foreach($orderWeeks as $date=>$count)
			<td>{{$date}}</td>
            @endforeach
		</tr>
		<tr>
            @foreach($orderWeeks as $count)
                @if($count==0)
                <td>{{$count}}</td>
                @else
                    <td><strong style="color: red">{{$count}}</strong></td>
                @endif
            @endforeach
		</tr>
	</table>
	<div class="panel-body" >
		<div class="row">
		<div class="col-md-6" id="main" style="height:400px;"></div>
		<div class="col-md-6" id="main2" style="height:400px;"></div>
		</div>
	</div>
	<div class="panel-heading"><strong>最近一周菜品销量统计</strong></div>
	<table class="table table-bordered text-center">
        <tr>
            <th>菜品名称</th>
            @foreach($week as $day)
                <th>{{ $day }}</th>
            @endforeach
        </tr>
        @foreach($goodsWeeks as $id=>$data)
            <tr>
                <td><a href="{{route('goods.show',[$id])}}">{{ $goodses[$id] }}</a></td>
                @foreach($data as $total)
                    @if($total==0)
                    <td>{{ $total }}</td>
                    @else
                    <td><strong style="color: red"> {{ $total }}</strong></td>
                    @endif

                @endforeach
            </tr>
        @endforeach
	</table>
</div>
<!--最近3个月统计-->
<div class="row ">
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading"><strong>最近三个月菜品销量统计</strong></div>

            <!--最近3个月菜品销量统计图-->
            <div class="panel-body">
                <div id="main4" style="height:400px;"></div>
            </div>
            <table class="table table-bordered text-center">
                <tr class="bg-success">
                    <td>菜品名称</td>
                    @foreach($Months as $month)
                        <td>{{$month}}</td>@endforeach

                </tr>
                @foreach($goodsMonths as $id=>$amounts)
                    <tr>
                        <td><a href="{{route('goods.show',[$id])}}">{{$goodses[$id]}}</a></td>
                        @foreach($amounts as $amount)
                            @if($amount==0)
                                <td>{{$amount}}</td>
                            @else
                                <td><strong style="color: red">{{$amount}}</strong></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading"><strong>最近三个月订单量统计</strong></div>
            <!--最近3个月统计图-->
            <div class="panel-body">
                <div id="main3" style="height:400px;"></div>
            </div>
            <table class="table table-bordered text-center">
                <tr class="bg-success">
                    <td>日期</td>
                    @foreach($orderMonths as $month=>$monthCount)
                        <td>{{$month}}</td>
                    @endforeach
                </tr>
                <tr><td>单量</td>
                    @foreach($orderMonths as $month=>$monthCount)
                        @if($monthCount==0)
                            <td>{{$monthCount}}</td>
                        @else
                            <td><strong style="color: red">{{$monthCount}}</strong></td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>成交金额</td>
                    @foreach($money as $k=> $v)
                    @if($v==0)
                    <td>{{$v}}</td>
                    @else
                    <td><strong class="text-success">{{$v}}</strong></td>
                    @endif
                    @endforeach
                </tr>
            </table>

        </div>
    </div>

</div>
<script src="/js/echarts.simple.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'),'light');
    // 指定图表的配置项和数据
    var option = {
        title: {
            text: '最近一周订单量'
        },
        tooltip: {},
        legend: {
            data:['订单量']
        },
        xAxis: {
            data: @php echo json_encode(array_keys($orderWeeks)) @endphp
        },
        yAxis: {},
        series: [{
            name: '销量',
            type: 'line',
            data: @php echo json_encode(array_values($orderWeeks)) @endphp
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    //统计图2
    // 基于准备好的dom，初始化echarts实例
    var myChart2 = echarts.init(document.getElementById('main2'),'light');
    // 指定图表的配置项和数据
    var option2 = {
        title: {
            text: '最近一周菜品销量'
        },
        tooltip: {
            trigger: 'axis'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: @php echo json_encode($week) @endphp
        },
        yAxis: {
            type: 'value'
        },
        series: @php echo json_encode($series) @endphp
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart2.setOption(option2);

    //图3
    var myChart3 = echarts.init(document.getElementById('main3'),'light');
    // 指定图表的配置项和数据
    var option3 = {
        title: {
            text: '最近3个月订单量'
        },
        tooltip: {},
        legend: {
            data:['订单量']
        },
        xAxis: {
            data: @php echo json_encode(array_keys($orderMonths)) @endphp
        },
        yAxis: {},
        series: [{
            name: '销量',
            type: 'line',
            data: @php echo json_encode(array_values($orderMonths)) @endphp
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart3.setOption(option3);

    //图4
    // 基于准备好的dom，初始化echarts实例
    var myChart4 = echarts.init(document.getElementById('main4'),'light');
    // 指定图表的配置项和数据
    var option4= {
        title: {
            text: '最近三个月菜品销量'
        },
        tooltip: {
            trigger: 'axis'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: @php echo json_encode($Months) @endphp
        },
        yAxis: {
            type: 'value'
        },
        series: @php echo json_encode($series2) @endphp
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart4.setOption(option4);

</script>



@endsection