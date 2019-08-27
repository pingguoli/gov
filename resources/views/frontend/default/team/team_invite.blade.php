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
                            <div class="card-body">
                                <form action="" method="get">
                                    <fieldset class="form-group row">
                                        <legend class="col-form-legend col-sm-6">昵称</legend>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="query" id="query" value="{{ request()->query('query') }}" placeholder="">
                                        </div>
                                    </fieldset>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-info btn-sm">搜索</button>
                                        </div>
                                    </div>
                                </form>

                                <h3>可加入战队成员</h3>
                                <div>
                                    @if(!empty($list))
                                        @foreach($list as $entry)
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title">{{ $entry->name }}</h4>
                                                    <p class="card-text">
                                                        <a href="{{ route('team.sendteaminvite', ['code' => $code, 'id' => $entry->id]) }}" class="btn btn-sm btn-outline-danger confirm-invite">邀请</a>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
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
                $('.confirm-invite').on('click', function () {
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