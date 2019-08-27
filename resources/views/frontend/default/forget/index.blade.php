@extends('frontend::layouts.default')

@section('title', '忘记密码')

@section('style')
    @include('frontend::forget._css')
    <style>
        .footer{ position: fixed; bottom: 0;}
        .footer_container{ display:none;}
        .form-control{}
        .register1 .single .yzm{ display: inline-block; font-size: 14px; width: 75px; margin-left:20px; text-align:right; padding-right:5px;}
        .register1 .single .yzm-input{ width:142px; margin-right:2px;}
    </style>
@stop

@section('content')
    @include('frontend::layouts._error')

    <!--login-->
    <div class="login register register1">
        <div class="step" style="text-align: center;"><img src="{{ asset('images/stepps1.jpg') }}" /></div>
        <div class="login-form register1-form">
            <form action="{{route('forget')}}" method="post">
                {{ csrf_field() }}
                <div class="telephone single"><span>手机号</span><input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" /><span class="send" id="send_sms">发送验证码</span>
                    <span class="red" id="send_smsN">
                        @if($errors->has('mobile'))
                            {{ $errors->first('mobile') }}
                        @endif
                    </span>
                </div>
                <div class="password single"><span>短信验证码</span><input type="text" name="sms_code" id="sms_code"  />
                    <span class="red">
                        @if($errors->has('sms_code'))
                            {{ $errors->first('sms_code') }}
                        @endif
                    </span>
                </div>
                @if(!empty(config('site.other.captcha')))
                    <div class="single row">
                        <label for="inputName" class="yzm">{{ __('Captcha') }}</label>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="yzm-input" name="captcha" placeholder="">
                                <div class="input-group-append">
                                    <img src="{{captcha_src()}}" style="cursor: pointer;" onclick="this.src='{{ captcha_src() }}' + Math.random()">
                                </div>
                            </div>
                            @if($errors->has('captcha'))
                                <p class="form-text text-danger">
                                    {{ $errors->first('captcha') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
                @if($errors->has('protocol'))
                    {{ $errors->first('protocol') }}
                @endif
                <div class="login-submit"><input type="submit" value="下一步" /></div>
            </form>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::forget._js')
    <script>
        !function ($) {
            $(function () {
                $('#send_sms').on('click', function () {
                    var $that = $(this);
                    var mobile = $('#mobile');

                    if ($(this).hasClass('has-send')) {
                        return false;
                    }

                    if (!mobile.val()) {
                        /*swal({
                            title: '',
                            text: "{{ __('Please enter :attribute', ['attribute' => __('Mobile')]) }}",
                            type: "warning",
                            confirmButtonText: "{{ __('Ok') }}",
                        });*/
                        $("#send_smsN").text("{{ __('Please enter :attribute', ['attribute' => __('Mobile')]) }}");
                        return false;
                    }

                    $that.addClass('has-send');
                    var oldText = $that.text();
                    var tickerTime = 60;
                    var ticker = null;
                    $that.text('{{ __('Sending...') }}');

                    $.ajax({
                        url: '{{ route('forget.sms') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            mobile: mobile.val(),
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
                                $("#send_smsN").text(res.message);
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
        }(jQuery);
    </script>
@stop