@extends('backend::layout')

@section('title', '单页列表')

@section('content')
    <div class="card border-no">
        <div class="card-body">
            @if(!empty($currentAdmin) && $currentAdmin->allow('page/add'))
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="{{ route('admin.page.add') }}" class="btn btn-primary btn-sm">新增单页</a>
                    </p>
                </div>
            </div>
            @endif
            <h4 class="text-black f-20">单页列表</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">单页标题</th>
                        <th scope="col">副标题</th>
                        <th scope="col">作者</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($list))
                        @foreach($list as $idx => $item)
                            <tr>
                                <th scope="row">{{ $idx + 1 }}</th>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->subtitle }}</td>
                                <td>{{ $item->author }}</td>
                                <td>{{ $item->getStatus() }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('page/view'))
                                        <a href="{{ route('admin.page.view', ['id' => $item->id]) }}" class="text-primary" title="{{ __('View') }}"><i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('page/edit'))
                                        <a href="{{ route('admin.page.edit', ['id' => $item->id]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('page/delete'))
                                        <a href="{{ route('admin.page.delete', ['id' => $item->id]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
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
                    @if(isset($list))
                        {{ $list->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop