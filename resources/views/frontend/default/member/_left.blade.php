<div class="top1">
    <img src="@if(!empty($user)){{ \App\Model\File::getFileUrl($user->img, asset('images/logo.png')) }}@else{{asset('images/logo.png')}}@endif">
    <p>@if(!empty($user)){{ $user->nickname ?: $user->mobile }}@endif</p>
</div>
<ul class="nav flex-column">
    <li class="nav-item">
        @if(!empty($active) && $active == 'index')<span></span> @endif
        <a class="nav-link" href="{{ route('member') }}">个人中心</a>
    </li>
    <li class="nav-item">
        @if(!empty($active) && $active == 'info')<span></span> @endif
        <a class="nav-link" href="{{ route('member.info') }}">基本信息</a>
    </li>
    <li class="nav-item">
        @if(!empty($active) && $active == 'password')<span></span> @endif
        <a class="nav-link" href="{{ route('member.password') }}">密码更改</a>
    </li>
    <li class="nav-item">
        @if(!empty($active) && $active == 'project')<span></span> @endif
        <a class="nav-link" href="{{ route('member.project') }}">项目</a>
    </li>
    <li class="nav-item">
        @if(!empty($active) && $active == 'bind')<span></span> @endif
        <a class="nav-link" href="{{ route('member.bind') }}">账号绑定</a>
    </li>
    <li class="nav-item">
        @if(!empty($active) && $active == 'message')<span></span> @endif
        <a class="nav-link" href="{{ route('member.message') }}">我的消息</a>
    </li>
</ul>