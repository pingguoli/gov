@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::member._left', ['active' => 'info'])
            </div>
            <div class="col col-9">
                <div class="row rightTop">
                    <p>基本信息</p>
                </div>
                <div class="row rightBodys">
                    <div class="col col-2 BodyH">
                        <label>昵称</label>
                    </div>
                    <div class="col col-9 BodyH">
                        <input value="阿川">
                    </div>
                    <div class="col col-2">
                        <label for="file1">头像</label>
                    </div>
                    <div class="col col-9">
                        <div class="upload chunk-upload">
                            <input type="hidden" class="img"  name="img" value="{{ old('img') ?: $user->img }}">
                            <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('img') ?: $user->img, asset('images/photo-default.jpg')) }}" />
                            <label class="file-box" for="file1">选择文件<input class="file-input img_upload" id="file1" type="file" /></label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="form-text text-info output"></p>
                            @if($errors->has('img'))
                                {{ $errors->first('img') }}
                            @endif
                        </div>
                    </div>
                    <div class="col col-2">
                        <label for="mobile">手机号</label>
                        <label for="yz">短信验证码</label>
                    </div>
                    <div class="col col-9">
                        <input type="text" name="mobile" id="mobile" value=""><button id="send_sms">发送验证码(60s)</button>
                            <span class="red" id="send_smsS"></span>
                        <br/>
                        <input id="yz" type="text" value=""><br/>
                        <button class="SubmitS">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
    <script>
        $(function () {
            $('#send_sms').on('click', function () {
                var $that = $(this);
                var mobile = $('#mobile');

                if ($(this).hasClass('has-send')) {
                    return false;
                }

                if (!mobile.val()) {
                    $("#send_smsS").text("{{ __('Please enter :attribute', ['attribute' => __('Mobile')]) }}")
                    return false;
                }else{
                    $("#send_smsS").text("");
                    $("#send_smsN").text("");
                }

                $that.addClass('has-send');
                var oldText = $that.text();
                var tickerTime = 60;
                var ticker = null;
                $that.text('{{ __('Sending...') }}');

                $.ajax({
                    url: '{{ route('register.sms') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        mobile: mobile.val(),
                        protocol: protocol.prop('checked') ? 1 : 0
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res.error == 0) {
                            ticker = setInterval(function () {
                                if (tickerTime <= 1) {
                                    clearInterval(ticker);
                                    $that.text(oldText);
                                    $that.removeClass('has-send');
                                } else {
                                    $that.text(tickerTime + '秒后重新发送');
                                }
                                tickerTime--;
                            }, 1000);
                        } else {
                            swal({
                                title: '',
                                text: res.message,
                                type: "warning",
                                confirmButtonText: "{{ __('Ok') }}",
                            });
                            clearInterval(ticker);
                            $that.text(oldText);
                            $that.removeClass('has-send');
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        clearInterval(ticker);
                        $that.text(oldText);
                        $that.removeClass('has-send');
                    }
                });
                return false;
            });
        });
    </script>
@stop