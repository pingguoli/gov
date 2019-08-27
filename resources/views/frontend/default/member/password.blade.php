@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::member._left', ['active' => 'password'])
            </div>
            <div class="col col-9">
                <div class="row rightTop">
                    <p>密码更改</p>
                </div>
                @include('frontend::layouts._error')
                <form method="post"  class="rightBodyPassword rightBodys">
                    {{ csrf_field() }}
                    <div>
                        <label>原密码</label>
                        <input type="password" name="orig_password" placeholder="">
                        @if($errors->has('orig_password'))
                            <span class="red">
                                {{ $errors->first('orig_password') }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <label>新密码</label>
                        <input type="password" name="password" placeholder="">
                        @if($errors->has('password'))
                            <span class="red">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <label>确认密码</label>
                        <input type="password" name="password_confirmation" placeholder="">
                        @if($errors->has('password_confirmation'))
                            <span class="red">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="">修改</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
@stop