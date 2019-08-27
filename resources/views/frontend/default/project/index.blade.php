@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::project._left', ['activeProject' => 'index'])
            </div>
            <div class="col col-9">
                <div class="row">
                    <div class="col col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">最后登录时间</h4>
                                <p class="card-text">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">已参与的项目</h4>
                                <p class="card-text">

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
@stop