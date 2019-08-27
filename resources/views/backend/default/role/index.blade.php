@extends('backend::layout')

@section('title', __('Role List'))

@section('content')
    <div class="card border-no">
        <div class="card-body">
            @if(!empty($currentAdmin) && $currentAdmin->allow('role/add'))
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="{{ route('admin.role.add') }}" class="btn btn-primary btn-sm">{{ __('New Role') }}</a>
                    </p>
                </div>
            </div>
            @endif
            <h4 class="text-black f-20">{{__('Role List')}}</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Type') }}</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($roles))
                        @foreach($roles as $idx => $item)
                            <tr>
                                <th scope="row">{{ $idx + 1 }}</th>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->getType() }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('role/permission'))
                                        <a href="{{ route('admin.role.permission', ['id' => $item->id]) }}" class="text-warning" title="{{ __('Permission') }}"><i class="fa fa-lock"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('role/view'))
                                        <a href="{{ route('admin.role.view', ['id' => $item->id]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('role/edit'))
                                        <a href="{{ route('admin.role.edit', ['id' => $item->id]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('role/delete'))
                                        <a href="{{ route('admin.role.delete', ['id' => $item->id]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
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
                    @if(isset($roles))
                        {{ $roles->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop