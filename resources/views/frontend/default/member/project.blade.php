@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::member._left', ['active' => 'project'])
            </div>
            <div class="col col-9">
                <div class="row">
                    <div class="col col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">已参加项目</h4>
                                <div>
                                    @if(!empty($userProjects))
                                        @foreach($userProjects as $entry)
                                            @if($entry->project)
                                                <p class="card-text"><a href="{{ route('project', ['code' => $entry->project->code]) }}">{{ $entry->project->name }}</a></p>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">所有项目</h4>
                                <div>
                                    @if(!empty($projects))
                                        @foreach($projects as $project)
                                            <p class="card-text"><a href="{{ route('project', ['code' => $project->code]) }}">{{ $project->name }}</a></p>
                                        @endforeach
                                    @endif
                                </div>
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