@if(!empty($code))
    <ul class="nav flex-column" style="margin:0;">
        <li class="nav-item">
            @if(!empty($activeProject) && $activeProject == 'index')<span></span> @endif
            <a class="nav-link" href="{{ route('project', ['code' => $code]) }}">我的状态</a>
        </li>
        <li class="nav-item">
            @if(!empty($activeProject) && $activeProject == '')<span></span> @endif
            <a class="nav-link" href="">我的比赛</a>
        </li>
        <li class="nav-item">
            @if(!empty($activeProject) && $activeProject == '')<span></span> @endif
            <a class="nav-link" href="">我的认证</a>
        </li>
        <li class="nav-item">
            @if(!empty($activeProject) && $activeProject == '')<span></span> @endif
            <a class="nav-link" href="">我的积分</a>
        </li>
        <li class="nav-item">
            @if(!empty($activeProject) && $activeProject == '')<span></span> @endif
            <a class="nav-link" href="">我的战绩</a>
        </li>
        <li class="nav-item">
            @if(!empty($activeProject) && $activeProject == 'team')<span></span> @endif
            <a class="nav-link" href="{{ route('team', ['code' => $code]) }}">我的战队</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">&nbsp;</a>
        </li>
    </ul>
@endif