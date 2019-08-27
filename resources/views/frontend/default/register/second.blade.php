@extends('frontend::layouts.default')

@section('title', __('Register'))

@section('style')
    @include('frontend::register._css')
@stop

@section('content')
    @include('frontend::layouts._error')

    <!--login-->
    <div class="login register register2">
        <div class="step"><img src="{{ asset('images/step2.jpg') }}" /></div>
        <div class="login-form register1-form">
            <form action="" method="post">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" name="id" value="{{ old('id') ?: $user->id }}">
                <input type="hidden" class="form-control" name="code" value="{{ old('code') ?: $user->code }}">
                <input type="hidden" class="form-control" name="mobile" value="{{ old('mobile') ?: $user->mobile }}">


                <div class="password single"><span><label for="nickname">昵称</label></span><input type="text" name="nickname" id="nickname" value="{{ old('nickname') ?: $user->nickname }}" />
                    <span class="red">
                        @if($errors->has('nickname'))
                            {{ $errors->first('nickname') }}
                        @endif
                    </span>
                </div>

                <div class="password single"><span><label for="name">姓名</label></span><input type="text" name="name" id="name" value="{{ old('name') ?: $user->name }}" />
                    <span class="red">
                        @if($errors->has('name'))
                            {{ $errors->first('name') }}
                        @endif
                    </span>
                </div>

                <div class="password single"><span><label for="id_card">身份证号</label></span><input type="text" name="id_card" id="id_card" value="{{ old('id_card') ?: $user->id_card }}" />
                    <span class="red">
                         @if($errors->has('id_card'))
                             {{ $errors->first('id_card') }}
                         @endif
                    </span>
                </div>

                <div class="forget is-agreen2 single">
                    <span>性别</span>
                    <label for="agree"><input id="agree" type="radio" name="sex" {{ old('sex') == 1 || $user->sex == 1 ? 'checked' : '' }} value="1" /><span></span>男</label>
                    <label for="agree2"><input id="agree2" type="radio" name="sex" {{ old('sex') == 2 || $user->sex == 2 ? 'checked' : '' }} value="2" /><span></span>女</label>
                    <span class="red">
                        @if($errors->has('sex'))
                            {{ $errors->first('sex') }}
                        @endif
                    </span>
                </div>
                <div class="password single"><span><label for="email">邮箱</label></span><input type="text" name="email" id="email" value="{{ old('email') ?: $user->email }}" />
                    <span class="red">
                        @if($errors->has('email'))
                            {{ $errors->first('email') }}
                        @endif
                    </span>
                </div>
                <div class="password single"><span><label for="birthday">生日</label></span><input type="text" name="birthday" id="birthday" value="{{ old('birthday') ?: $user->birthday }}" />
                    <span class="red">
                        @if($errors->has('birthday'))
                            {{ $errors->first('birthday') }}
                        @endif
                    </span>
                </div>
                <div class="password single country"><span><label for="nationality">国籍</label></span>
                    <select name="nationality" id="nationality">
                        <option value="">请选择</option>
                        @foreach(\App\Support\Enum::$nationality as $key => $title)
                            <option value="{{ $key }}" {{ old('nationality') == $key || $user->nationality == $key ? 'selected' : '' }}>{{ __($title) }}</option>
                        @endforeach
                    </select>
                    <span class="red">
                       @if($errors->has('nationality'))
                           {{ $errors->first('nationality') }}
                       @endif
                    </span>
                </div>
                <div class="password single"><span><label for="address">地址</label></span><input type="text" name="address" id="address" value="{{ old('address') ?: $user->address }}" />
                    <span class="red">
                        @if($errors->has('address'))
                            {{ $errors->first('address') }}
                        @endif
                    </span>
                </div>
                <div class="password single country"><span><label for="education">学历</label></span>
                    <select name="education" id="education">
                        <option value="">请选择</option>
                        @foreach(\App\Support\Enum::$education as $key => $title)
                            <option value="{{ $key }}" {{ old('education') == $key || $user->education == $key ? 'selected' : '' }}>{{ __($title) }}</option>
                        @endforeach
                    </select>
                    <span class="red">
                          @if($errors->has('education'))
                              {{ $errors->first('education') }}
                          @endif
                    </span>
                </div>
                <div class="login-submit"><input class="prev" type="button" onclick="location.href='{{ $prev }}'" value="上一步" /><input type="submit" value="下一步" /></div>
            </form>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::register._js')
@stop