<ul class="nav nav-inline">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('home') }}">{{ __('Home') }}</a>
    </li>
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
    @else
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">我</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">修改信息</a>
                <a class="dropdown-item" href="#">安全管理</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">退出</a>
            </div>
        </li>
    @endguest

</ul>