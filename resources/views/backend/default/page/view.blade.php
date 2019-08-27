@extends('backend::layout')

@section('title', '查看单页')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="javascript:history.back(-1);" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
                    </p>
                </div>
            </div>
            <h4 class="text-black f-20">查看单页</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">单页标题</th>
                        <td>{{ $page->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row">副标题</th>
                        <td>{{ $page->subtitle }}</td>
                    </tr>
                    <tr>
                        <th scope="row">关键字</th>
                        <td>{{ $page->keywords }}</td>
                    </tr>
                    <tr>
                        <th scope="row">描述</th>
                        <td>{{ $page->description }}</td>
                    </tr>
                    <tr>
                        <th scope="row">作者</th>
                        <td>{{ $page->author }}</td>
                    </tr>
                    <tr>
                        <th scope="row">来源</th>
                        <td>{{ $page->source }}</td>
                    </tr>
                    <tr>
                        <th scope="row">内容</th>
                        <td>{!! $page->content !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>{{ $page->getStatus() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Create Time') }}</th>
                        <td>{{ $page->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $page->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop