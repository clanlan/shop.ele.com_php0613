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
		<tr class="text-danger">
            @foreach($orderWeeks as $count)
                <td>{{$count}}</td>
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
                <td>{{ $goods[$id] }}</td>
                @foreach($data as $total)
                    <td>{{ $total }}</td>
                @endforeach
            </tr>
        @endforeach
	</table>

</div>
<script src="/js/echarts.common.min.js"></script>
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
</script>



@endsection