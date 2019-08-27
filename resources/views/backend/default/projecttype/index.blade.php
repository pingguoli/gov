@extends('backend::layout')

@section('title', '项目类型列表')

@section('content')
    <div class="card border-no">
        <div class="card-body">
            @if(!empty($currentAdmin) && $currentAdmin->allow('projecttype/add'))
                <div class="row">
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                        <p>
                            <a href="{{ route('admin.project_type.add') }}" class="btn btn-primary btn-sm">新增项目类型</a>
                        </p>
                    </div>
                </div>
            @endif
            <h4 class="text-black f-20">项目类型列表</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($lists))
                        @foreach($lists as $idx => $item)
                            <tr>
                                <th scope="row">{{ $idx + 1 }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('projecttype/edit'))
                                        <a href="{{ route('admin.project_type.edit', ['id' => $item->id]) }}" class="text-info" title="{{ __('Edit') }}"><i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('projecttype/delete'))
                                        <a href="{{ route('admin.project_type.delete', ['id' => $item->id]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
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
                    @if(isset($lists))
                        {{ $lists->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop