<!-- Header -->

<header class="header">
    <!-- Header Content -->
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="main_nav_container_outer d-flex flex-row align-items-end justify-content-center trans_400">
                        <nav class="main_nav">
                            <div class="main_nav_container d-flex flex-row align-items-center justify-content-lg-start justify-content-center">
                                <div>
                                    <!-- Header LIVE -->
                                    <div class="header_live">
                                        <a href="#">
                                            <div class="d-flex flex-row align-items-center justify-content-start">
                                                <div>live</div>
                                                <div>Lorem ipsum dolor sit amet, consectetur...</div>
                                            </div>
                                        </a>
                                    </div>
                                    <ul class="d-flex flex-row align-items-start justify-content-end">
                                        <li class="active"><a href="{{ route('home') }}">首页</a></li>
                                        <li><a href="{{ route('about') }}">关于我们</a></li>
                                    </ul>
                                </div>
                                <div class="logo_container text-center"><div class="trans_400"><a href="#"><img src="{{ asset('images/logo.png') }}" alt=""></a></div></div>
                                <div>
                                    <ul class="d-flex flex-row align-items-start justify-content-start">
                                        <li><a href="{{ route('news') }}">新闻</a></li>
                                        <li><a href="{{ route('contact') }}">联系我们</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <div class="hamburger">
                            <i class="fa fa-bars trans_200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header bar -->
        <div class="header_bar">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="header_bar_content d-flex flex-row align-items-center justify-content-start">
                            <div class="header_links">
                                <ul class="d-flex flex-row align-items-start justify-content-start">
                                    <li><a href="#">GET Tickets</a></li>
                                    <li><a href="#">Shop</a></li>
                                </ul>
                            </div>
                            <div class="header_bar_right ml-auto d-flex flex-row align-items-center justify-content-start">

                                <!-- Header LIVE -->
                                <div class="header_live">
                                    <a href="#">
                                        <div class="d-flex flex-row align-items-center justify-content-start">
                                            <div>live</div>
                                            <div>Lorem ipsum dolor sit amet, consectetur...</div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Sign up / Sign in -->
                                <div class="user_area">
                                    @guest
                                        <ul class="d-flex flex-row align-items-start justify-content-start">
                                            <li><a href="{{ route('register') }}">注册</a></li>
                                            <li><a href="{{ route('login') }}">登录</a></li>
                                        </ul>
                                    @else
                                        <ul class="d-flex flex-row align-items-start justify-content-start">
                                            <li><a href="{{ route('member') }}">个人中心</a></li>
                                            <li><a href="{{ route('logout') }}">退出</a></li>
                                        </ul>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Menu -->

<div class="menu">
    <div class="menu_background">
        <div class="menu_container d-flex flex-column align-items-end justify-content-start">
            <div class="menu_close">关闭</div>
            <div class="menu_user_area">
                <ul class="d-flex flex-row align-items-start justify-content-end">
                    @guest
                        <li><a href="{{ route('register') }}">注册</a></li>
                        <li><a href="{{ route('login') }}">登录</a></li>
                    @else
                        <li><a href="{{ route('member') }}">个人中心</a></li>
                        <li><a href="{{ route('logout') }}">退出</a></li>
                    @endguest
                </ul>
            </div>
            <nav class="menu_nav">
                <ul class="text-right">
                    <li><a href="{{ route('home') }}">首页</a></li>
                    <li><a href="{{ route('about') }}">关于我们</a></li>
                    <li><a href="{{ route('news') }}">新闻</a></li>
                    <li><a href="{{ route('contact') }}">联系我们</a></li>
                </ul>
            </nav>
            <div class="menu_links">
                <ul class="d-flex flex-row align-items-start justify-content-start">
                    <li><a href="#">GET Tickets</a></li>
                    <li><a href="#">Shop</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>