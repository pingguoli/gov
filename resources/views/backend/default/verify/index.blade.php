@extends('backend::layout')

@section('title', '审核设置列表')

@section('content')
    <div class="card border-no">
        <div class="card-body">
            @if(!empty($currentAdmin) && $currentAdmin->allow('verify/add'))
                <div class="row">
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                        <p>
                            <a href="{{ route('admin.verify.add') }}" class="btn btn-primary btn-sm">新增审核设置</a>
                        </p>
                    </div>
                </div>
            @endif
            <h4 class="text-black f-20">审核设置列表</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Type') }}</th>
                        <th scope="col">项目</th>
                        <th scope="col">管理员</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($settings))
                        @foreach($settings as $idx => $item)
                            <tr>
                                <th scope="row">{{ $idx + 1 }}</th>
                                <td>{{ $item->getType() }}</td>
                                <td>@if($item->project){{ $item->project->name }}@endif</td>
                                <td>@if($item->admin){{ $item->admin->nickname ?: $item->admin->username }}@endif</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('verify/edit'))
                                        <a href="{{ route('admin.verify.edit', ['id' => $item->id]) }}" class="text-info" title="{{ __('Edit') }}"><i class="fa fa-pencil"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    @if(isset($settings))
                        {{ $settings->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop