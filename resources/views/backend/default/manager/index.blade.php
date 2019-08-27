@extends('backend::layout')

@section('title', __('Manager List'))

@section('content')
    <div class="card border-no">
        <div class="card-body">
            @if(!empty($currentAdmin) && $currentAdmin->allow('manager/add'))
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="{{ route('admin.manager.add') }}" class="btn btn-primary btn-sm">{{ __('New Manager') }}</a>
                    </p>
                </div>
            </div>
            @endif
            <h4 class="text-black f-20">{{__('Manager List')}}</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Account') }}</th>
                        <th scope="col">{{ __('Type') }}</th>
                        <th scope="col">项目</th>
                        <th scope="col">{{ __('Nickname') }}</th>
                        <th scope="col">{{ __('E-mail') }}</th>
                        <th scope="col">{{ __('Mobile') }}</th>
                        <th scope="col">{{ __('Role') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Last login time') }}</th>
                        <th scope="col">{{ __('Last login IP') }}</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($manager))
                        @foreach($manager as $idx => $item)
                            <tr>
                                <th scope="row">{{ $idx + 1 }}</th>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->getType() }}</td>
                                <td>
                                    @if($item->type == \App\Model\Admin::TYPE_PROJECT && $item->project && $item->project->id)
                                        {{ $item->project->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->nickname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>
                                    @if(!empty($roles))
                                        @foreach($roles as $role)
                                            @if(in_array($role->id, $item->roleIds()))
                                                <div>{{ $role->name }}</div>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $item->getStatus() }}</td>
                                <td>{{ $item->last_login_time }}</td>
                                <td>{{ $item->last_login_ip }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('manager/view'))
                                        <a href="{{ route('admin.manager.view', ['id' => $item->id]) }}" class="text-primary" title="{{ __('View') }}"><i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('manager/edit'))
                                        <a href="{{ route('admin.manager.edit', ['id' => $item->id]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(!$item->isSupperAdmin() && !empty($currentAdmin) && $currentAdmin->allow('manager/delete'))
                                        <a href="{{ route('admin.manager.delete', ['id' => $item->id]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
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
                    @if(isset($manager))
                        {{ $manager->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop