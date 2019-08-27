@extends('frontend::layouts.default')

@section('title', __('Register'))

@section('style')
    @include('frontend::register._css')
@stop

@section('content')
    @include('frontend::layouts._error')

    <!--login-->
    <div class="login register register2">
        <div class="step" style="text-align: center;"><img src="{{ asset('images/stepps2.jpg') }}" /></div>
        <div class="login-form register1-form">
            <form action="" method="post">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" name="id" value="{{ old('id') ?: $user->id }}">
                <input type="hidden" class="form-control" name="code" value="{{ old('code') ?: $user->code }}">
                <input type="hidden" class="form-control" name="mobile" value="{{ old('mobile') ?: $user->mobile }}">

                <div class="password single"><span>密码</span><input type="password" name="password" id="password" value="{{ old('password') }}" />
                    <span class="red">
                        @if($errors->has('password'))
                            {{ $errors->first('password') }}
                        @endif
                    </span>
                </div>
                <div class="password single"><span>确认密码</span><input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}"  />
                    <span class="red">
                        @if($errors->has('password_confirmation'))
                            {{ $errors->first('password_confirmation') }}
                        @endif
                    </span>
                </div>
                <div class="login-submit"><input class="prev" type="button" onclick="location.href='{{ $prev }}'" value="上一步" /><input type="submit" value="修改" /></div>
            </form>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::register._js')
@stop