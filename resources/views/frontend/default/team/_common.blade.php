@if(!empty($userProject) && !empty($code))
    @if($userProject->team_id)
        {{-- 已有战队 --}}
        <nav class="nav nav-pills flex-column flex-sm-row">
            @if($userProject->team->status == \App\Model\Team::TEAM_SUCCESS)
                <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('team.manage', ['code' => $code]) }}">队员管理</a>
            @endif
            @if($userProject->id == $userProject->team->user_project_id)
                @if($userProject->team->status == \App\Model\Team::TEAM_SUCCESS)
                    <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('team.teaminvite', ['code' => $code]) }}">邀请队员</a>
                @endif
                <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('team.teamjoin', ['code' => $code]) }}">加入战队申请</a>
                <a class="flex-sm-fill text-sm-center nav-link" href="{{ route('team.disband', ['code' => $code]) }}">解散战队</a>
                <a class="flex-sm-fill text-sm-center nav-link" href="">赛事报名</a>
            @endif
        </nav>
    @else
        {{-- 无战队 --}}
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a href="{{ route('team.create', ['code' => $code]) }}">创建战队<span></span></a>
            <a href="{{ route('team.join', ['code' => $code]) }}">加入战队<span></span></a>
            <a href="{{ route('team.invite', ['code' => $code]) }}">邀请列表<span></span></a>
            <form action="" method="get">
                <input type="text" name="query" id="query" value="{{ request()->query('query') }}" placeholder=""><button type="submit">搜索</button>
            </form>
        </nav>
    @endif
@endif