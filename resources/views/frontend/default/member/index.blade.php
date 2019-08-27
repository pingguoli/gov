@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::member._left', ['active' => 'index'])
            </div>
            <div class="col col-9">
                <div class="row rightTop">
                    <p>个人中心</p>
                    <p>已参与的项目</p>
                </div>
                <div class="row rightBody">
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}">
                        <p>133333333333</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
@stop