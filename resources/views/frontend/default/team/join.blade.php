@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::project._left', ['activeProject' => 'team'])
            </div>
            <div class="col col-9">
                @include('frontend::layouts._error')
                <div class="row">
                    <div class="col col-12">
                        <div class="card">
                            @include('frontend::team._common')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3 class="rightZD">可加入战队</h3>
                    <div class="rightZDA">
                        @if(!empty($list))
                            @foreach($list as $entry)
                                <div class="card">
                                    <h4>{{ $entry->name }}</h4>
                                    <p>
                                        <a href="{{ route('team.sendjoin', ['code' => $code, 'id' => $entry->id]) }}">加入</a>
                                    </p>
                                </div>
                                <div class="card">
                                    <h4>{{ $entry->name }}</h4>
                                    <p>
                                        <a href="{{ route('team.sendjoin', ['code' => $code, 'id' => $entry->id]) }}">加入</a>
                                    </p>
                                </div>
                                <div class="card">
                                    <h4>{{ $entry->name }}</h4>
                                    <p>
                                        <a href="{{ route('team.sendjoin', ['code' => $code, 'id' => $entry->id]) }}">加入</a>
                                    </p>
                                </div>
                                <div class="card">
                                    <h4>{{ $entry->name }}</h4>
                                    <p>
                                        <a href="{{ route('team.sendjoin', ['code' => $code, 'id' => $entry->id]) }}">加入</a>
                                    </p>
                                </div>
                                <div class="card">
                                    <h4>{{ $entry->name }}</h4>
                                    <p>
                                        <a href="{{ route('team.sendjoin', ['code' => $code, 'id' => $entry->id]) }}">加入</a>
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
    <script type="text/javascript">
        !function ($) {
            $(function () {
                $('.confirm-join').on('click', function () {
                    var url = $(this).attr('href');
                    if (url === '') {
                        return false;
                    }

                    swal({
                        title: "{{ __('Are you sure?') }}",
                        text: "确定发送邀请吗?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "是的, 请邀请",
                        cancelButtonText: "{{ __('No, please cancel it!') }}"
                    }, function (isConfirm) {
                        if (isConfirm) {
                            location.href = url;
                        }
                    });

                    return false;
                });
            });
        }(jQuery)
    </script>
@stop