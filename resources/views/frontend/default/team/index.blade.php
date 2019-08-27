@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::project._left', ['activeProject' => 'team'])
            </div>
            <div class="col col-9">
                @include('frontend::layouts._error')
                <div class="row">
                    <div class="col col-12">
                        <div class="card">
							@include('frontend::team._common')
                        </div>
						<div class="card">
                            <div class=""><!-- card-body -->
                                @if(!empty($userProject) && $userProject->team)
                                    <h4 class="card-title">{{ $userProject->team->name }}</h4>
                                    <p class="card-text">
                                        @if($userProject->team->logo)
                                            <img src="{{ \App\Model\File::getFileUrl($userProject->team->logo) }}" class="img-fluid rounded-top" alt="">
                                        @endif
                                    </p>
                                    <p class="card-text">状态: {{ $userProject->team->getStatus() }}</p>
                                @endif
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