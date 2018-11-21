<style>
    body { padding-top: 70px; }
</style>
<nav class="navbar navbar-inverse navbar-fixed-top" style="border-radius:0;">
    <div class="container">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">商家管理后台</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">首页<span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">分类管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/goodsCategory">分类列表</a></li>
                        <li><a href="/goodsCategory/create">新增商品</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">商品管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('goods.index')}}">商品列表</a></li>
                        <li><a href="/goods/create">新增商品</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">账号管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/user">账号列表</a></li>
                        <li><a href="/user/create">新增账号</a></li>
                    </ul>
                </li>
                <li><a href="/order">订单管理<span class="sr-only">(current)</span></a></li>
                <li><a href="/activity">活动中心<span class="sr-only">(current)</span></a></li>
                <li><a href="/prize">新品试用<span class="sr-only">(current)</span></a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                @guest
                <li><a href="#" data-toggle="modal" data-target="#login">登陆</a></li>
                <li><a href="/user/create" >注册</a></li>
                @endguest
                @auth
                <li class="dropdown">
                    <a href="/user" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{auth()->user()->img}}" style="height:24px; border-radius:100%;"/>
                        {{auth()->user()->name}}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('index')}}">个人中心</a></li>
                        <li><a href="{{route('user.resetpwd')}}">修改密码</a></li>
                        <li><a href="/logout">退出登陆</a></li>
                    </ul>
                </li>
               @endauth


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
    </div>
</nav>
@include('common._modal_login')