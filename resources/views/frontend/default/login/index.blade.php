@extends('frontend::layouts.default')

@section('title', __('Login'))

@section('style')
    @include('frontend::login._css')
    <style>
        .send {cursor: pointer;display: inline-block;width: 110px;height: 41px;line-height: 41px;text-align: center;font-size: 12px;color: #1e2558;font-weight: bold;border: solid 1px #d5dadf;vertical-align: middle;margin-left: 8px;}
        #mobile{ width: 144px;vertical-align: middle;}
        .topD{
            color: #797878;
        }
        .topMain{color: #1e2558;cursor:pointer;}
        .login-form{margin-bottom:50px;}
        .login .single p.ts {margin-left: 79px;}
    </style>
@stop

@section('content')
    <!--login-->
    <div class="login">
        <h1><label class="topD">登录</label>/<label class="topD topMain">手机号</label></h1>
        <div class="login-form">
            <form action="{{route('login')}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="type" name="type" value="{{ old('type') ?: \App\Http\Controllers\Web\LoginController::LOGIN_NORMAL }}">
                <div class="ifs1" @if(old('type') !== null && old('type') != \App\Http\Controllers\Web\LoginController::LOGIN_NORMAL) style="display:none;" @endif>
                    <div class="accord single">
                        <span>账号</span>
                        <input type="text" name="username" value="{{old('username')}}"/>
                        @if($errors->has('username'))
                            <span class="ts">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="password single">
                        <span>密码</span>
                        <input type="password" name="password" />
                        @if($errors->has('password'))
                            <span class="ts">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="ifs2" @if(old('type') != \App\Http\Controllers\Web\LoginController::LOGIN_SMS) style="display:none;" @endif>
                    <div class="password single">
                        <span>手机号</span>
                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"/><span class="send" id="send_sms">发送验证码</span>
                        <span class="red" id="send_smsS">
                            @if($errors->has('mobile'))
                                {{ $errors->first('mobile') }}
                            @endif
                        </span>
                    </div>
                    <div class="password single">
                        <span>短信验证码</span>
                        <input type="text" name="sms_code" id="sms_code"  />
                        @if($errors->has('sms_code'))
                            <span class="red">{{ $errors->first('sms_code') }}</span>
                        @endif
                    </div>
                </div>
                @if(!empty(config('site.other.captcha')))
                    <div class="password single">
                        <span>{{ __('Captcha') }}</span>
                        <input type="text" name="captcha" style="width:125px;"/><img src="{{captcha_src()}}" style="cursor: pointer;height: 41px;vertical-align: top;" onclick="this.src='{{ captcha_src() }}' + Math.random()">
                        @if($errors->has('captcha'))
                            <span class="ts">{{ $errors->first('captcha') }}</span>
                        @endif
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="password single">
                        <p class="ts">{{ session()->get('error') }}</p>
                    </div>
                @endif
                <div class="forget"><a href="{{ route('forget') }}">忘记密码？</a></div>
                <div class="login-submit"><input type="submit" value="登录" /><a href="{{ route('register') }}">注册</a></div>
            </form>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::login._js')
    <script>
        $(function () {
            // if($("input[name=type]").val()!=1){
            //     $(".topD").click();
            // }
        });
        $(".topD").click(function(){
            $(".topD").addClass("topMain");
            $(this).removeClass("topMain");
            if($(this)[0].innerText=="登录"){
                $('#type').val('{{ \App\Http\Controllers\Web\LoginController::LOGIN_NORMAL }}');
                $(".ifs2").css("display","none");
                $(".ifs1").css("display","block");
            }else{
                $('#type').val('{{ \App\Http\Controllers\Web\LoginController::LOGIN_SMS }}');
                $(".ifs1").css("display","none");
                $(".ifs2").css("display","block");
            }
        });
        $('#send_sms').on('click', function () {
            var $that = $(this);
            var mobile = $('#mobile');

            if ($(this).hasClass('has-send')) {
                return false;
            }
            console.log(mobile.val());
            if (!mobile.val()) {
                $("#send_smsS").text("{{ __('Please enter :attribute', ['attribute' => __('Mobile')]) }}")
                return false;
            }else{
                $("#send_smsS").text("");
            }

            $that.addClass('has-send');
            var oldText = $that.text();
            var tickerTime = 60;
            var ticker = null;
            $that.text('{{ __('Sending...') }}');

            $.ajax({
                url: '{{ route('login.sms') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    mobile: mobile.val()
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
                        $("#send_smsS").text(res.message);
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
    </script>
@stop