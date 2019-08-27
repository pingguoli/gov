@extends('backend::layout')

@section('title', '查看导航')

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
            <h4 class="text-black f-20">查看导航</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">导航位置</th>
                        <td>{{ $navigation->getPosition() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">上级导航</th>
                        <td>@if(!empty($navigation->parent->name)){{ $navigation->parent->name }}@endif</td>
                    </tr>
                    <tr>
                        <th scope="row">类型</th>
                        <td>{{ \App\Model\Navigation::getType($navigation->type) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">链接/分类/单页</th>
                        <td>{{ \App\Model\Navigation::showTypeVal($navigation) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">是否新建标签</th>
                        <td>{{ $navigation->target ? __('Yes') : __('No') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">是否显示</th>
                        <td>{{ $navigation->is_show ? __('Yes') : __('No') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">排序</th>
                        <td>{{ $navigation->sort }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Create Time') }}</th>
                        <td>{{ $navigation->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $navigation->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop