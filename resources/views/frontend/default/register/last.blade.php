@extends('frontend::layouts.default')

@section('title', __('Register'))

@section('style')
    @include('frontend::register._css')
@stop

@section('content')
    @include('frontend::layouts._error')

    <!--login-->
    <div class="login register register2 register3 register4">
        <div class="step"><img src="{{ asset('images/step4.jpg') }}" /></div>
        <div class="login-form register1-form register4-form">
            <form action="" method="post">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" id="id" name="id" value="{{ old('id') ?: $user->id }}">
                <input type="hidden" class="form-control" id="code" name="code" value="{{ old('code') ?: $user->code }}">
                <input type="hidden" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') ?: $user->mobile }}">

                <div class="forget is-agreen3 single">
                    <span>证件类型</span>
                    <label>
                        @if($user->id_card_type == 1)
                            身份证
                        @elseif($user->id_card_type == 2)
                            户口
                        @elseif($user->id_card_type == 3)
                            护照
                        @endif
                    </label>
                </div>

                @if($user->id_card_type == 1)
                    <div class="password single"><span>身份证头像面</span>
                        <div class="upload">
                            <img src="{{ \App\Model\File::getFileUrl($user->id_card_face, asset('images/photo.jpg')) }}" />
                        </div>
                    </div>
                    <div class="password single"><span>身份证国徽面</span>
                        <div class="upload">
                            <img src="{{ \App\Model\File::getFileUrl($user->id_card_nation, asset('images/photo.jpg')) }}" />
                        </div>
                    </div>
                @elseif($user->id_card_type == 2)
                    <div class="password single"><span>户口照片</span>
                        <div class="upload">
                            <img src="{{ \App\Model\File::getFileUrl($user->house_img, asset('images/photo.jpg')) }}" />
                        </div>
                    </div>
                @elseif($user->id_card_type == 3)
                    <div class="password single"><span>护照照片</span>
                        <div class="upload">
                            <img src="{{ \App\Model\File::getFileUrl($user->passport_img, asset('images/photo.jpg')) }}" />
                        </div>
                    </div>
                @endif

                @if($user->id_card_type == 1)
                    <div class="forget is-agreen3 single">
                        <span></span>
                        <label id="verify_wrap">
                            @if($isVerify)
                                已验证
                            @elseif($isPayment)
                                已支付,未验证
                                <button type="button" class="btn btn-sm btn-info" id="verify">验证</button>
                            @else
                                <button type="button" class="btn btn-sm btn-info" id="payment">支付并验证</button>
                            @endif

                            @if($errors->has('check_id_card'))
                                <p class="form-text text-danger">
                                    {{ $errors->first('check_id_card') }}
                                </p>
                            @endif
                        </label>
                        <span class="paymentS red"></span>
                    </div>
                @else
                    <div class="forget is-agreen3 single">
                        <span></span>
                        <label>
                            暂不支持验证
                        </label>
                    </div>
                @endif

                <div class="password single"><span><label for="password">密码</label></span><input type="password" name="password" id="password" value="{{ old('password') }}" />
                    <span class="red">
                        @if($errors->has('password'))
                            {{ $errors->first('password') }}
                        @endif
                    </span>
                </div>

                <div class="password single"><span><label for="password_confirmation">确认密码</label></span><input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}"  />
                    <span class="red">
                        @if($errors->has('password_confirmation'))
                            {{ $errors->first('password_confirmation') }}
                        @endif
                    </span>
                </div>
                <div class="login-submit"><input class="prev" type="button" onclick="location.href='{{ $prev }}'" value="上一步" /><input type="submit" value="完成注册" /></div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">请扫码支付</h5>
                </div>
                <div class="modal-body" id="paymentImage">
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::register._js')
    <script>
        !function ($) {
            $(function () {
                var loopCheckPayment = null;
                $('#payment').on('click', function () {
                    var $this = $(this);

                    var origText = $this.text();
                    $this.prop('disabled', true);
                    $this.text('支付请求中...');

                    var data = {
                        _token: '{{ csrf_token() }}',
                        id: $('#id').val(),
                        code: $('#code').val(),
                        mobile: $('#mobile').val(),
                    };
                    $.ajax({
                        url: '{{ route('register.payment', ['key' => $key]) }}',
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function (rst) {
                            if (rst.error == 0) {
                                if (rst.pay == 0) {
                                    $('#paymentImage').html(rst.image);
                                    $('#paymentModal').modal({
                                        backdrop: 'static'
                                    });

                                    checkPayment(rst.code);
                                } else {
                                    /*swal({
                                        title: '已有支付',
                                        text: rst.message,
                                        type: "warning",
                                        confirmButtonText: "{{ __('Ok') }}",
                                    });*/
                                    $(".paymentS").text(rst.message);
                                    setTimeout(function () {
                                        verifyFace();
                                    }, 1000);
                                }
                            } else {
                                /*swal({
                                    title: '支付失败',
                                    text: rst.message,
                                    type: "warning",
                                    confirmButtonText: "{{ __('Ok') }}",
                                });*/
                                $(".paymentS").text(rst.message);
                            }
                            $this.prop('disabled', false);
                            $this.text(origText);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            $this.prop('disabled', false);
                            $this.text(origText);
                        }
                    });

                    return false;
                });

                $('#verify').on('click', function () {
                    verifyFace();
                    return false;
                });

                var verifyFace = function () {
                    var data = {
                        _token: '{{ csrf_token() }}',
                        id: $('#id').val(),
                        code: $('#code').val(),
                        mobile: $('#mobile').val(),
                    };

                    // 验证提示
                    /*swal({
                        title: '身份证验证',
                        text: '正在验证...',
                        type: "warning",
                        confirmButtonText: "{{ __('Ok') }}",
                    });*/
                    $(".paymentS").text("正在验证...");
                    $.ajax({
                        url: '{{ route('register.verify', ['key' => $key]) }}',
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function (rst) {
                            if (rst.error == 0 && rst.verify != 0) {
                                if (rst.verify == 1) {
                                    /*swal({
                                        title: '身份证验证',
                                        text: '验证成功',
                                        type: "success",
                                        confirmButtonText: "{{ __('Ok') }}",
                                    });*/
                                    $(".paymentS").text("身份证验证成功");
                                    $('#verify_wrap').html('已验证');
                                } else {
                                    /*swal({
                                        title: '身份证验证',
                                        text: '验证失败,请重新验证',
                                        type: "error",
                                        confirmButtonText: "{{ __('Ok') }}",
                                    });*/
                                    $(".paymentS").text("身份证验证失败,请重新验证");
                                }

                            } else {
                                /*swal({
                                    title: '身份证验证',
                                    text: '正在验证...',
                                    type: "error",
                                    confirmButtonText: "{{ __('Ok') }}",
                                });*/
                                $(".paymentS").text("正在身份证验证...");
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            /*swal({
                                title: '身份证验证',
                                text: '验证失败',
                                type: "error",
                                confirmButtonText: "{{ __('Ok') }}",
                            });*/
                            $(".paymentS").text("身份证验证失败");
                        }
                    });
                };

                var checkPayment = function (code) {
                    loopCheckPayment = setInterval(function () {
                        var data = {
                            _token: '{{ csrf_token() }}',
                            id: $('#id').val(),
                            code: $('#code').val(),
                            mobile: $('#mobile').val(),
                            out_trade_no: code
                        };
                        $.ajax({
                            url: '{{ route('register.checkPayment', ['key' => $key]) }}',
                            type: "POST",
                            data: data,
                            dataType: "json",
                            success: function (rst) {
                                if (rst.error == 0) {
                                    if (rst.pay != 0) {
                                        $('#paymentModal').modal('hide');
                                        clearInterval(loopCheckPayment);
                                        verifyFace();
                                    }
                                } else {
                                    $('#paymentModal').modal('hide');
                                    clearInterval(loopCheckPayment);
                                }
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                $('#paymentModal').modal('hide');
                                clearInterval(loopCheckPayment);
                            }
                        });
                    }, 3000);
                };
            });
        }(jQuery);
    </script>
@stop