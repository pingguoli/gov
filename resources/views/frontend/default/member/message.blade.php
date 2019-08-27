@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::member._left', ['active' => 'message'])
            </div>
            <div class="col col-9">
                <h2>暂未开放</h2>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
@stop