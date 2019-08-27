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
                                <h3>战队申请</h3>
                                <div>
                                    @if(!empty($list))
                                        @foreach($list as $entry)
                                            @if($entry->status == 0)
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">{{ $entry->userProject->name }}</h4>
                                                        <p class="card-text">
                                                            <a href="{{ route('team.confirmteamjoin', ['code' => $code, 'id' => $entry->id]) }}" data-val="1" class="btn btn-sm btn-outline-info confirm-join">同意</a>
                                                            <a href="{{ route('team.confirmteamjoin', ['code' => $code, 'id' => $entry->id]) }}" data-val="0" class="btn btn-sm btn-outline-danger confirm-join">拒绝</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        {{ $list->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hide">
        <form id="confirm-join-form" method="post" action="">
            {{ csrf_field() }}
            <input type="hidden" name="status" value="" id="join-status">
        </form>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
    <script type="text/javascript">
        !function ($) {
            $(function () {
                $('.confirm-join').on('click', function () {
                    var url = $(this).attr('href');
                    var status = $(this).data('val');
                    if (url === '') {
                        return false;
                    }

                    swal({
                        title: "{{ __('Are you sure?') }}",
                        text: "确定吗?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: "是的, 请执行",
                        cancelButtonText: "{{ __('No, please cancel it!') }}"
                    }, function (isConfirm) {
                        if (isConfirm) {
                            $('#join-status').val(status);
                            $('#confirm-join-form').attr('action', url).submit();
                        }
                    });

                    return false;
                });
            });
        }(jQuery)
    </script>
@stop