@extends('backend::layout')

@section('title', __('View Manager'))

@section('content')
    <div class="card border-no">
        <div class="card-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-sm">{{ __('Edit') }}</a>
                    </p>
                </div>
            </div>
            <h4 class="text-black f-20">{{__('Profile')}}</h4>
            <div class="table-responsive">
                <table class="table table-striped table2 table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Account') }}</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Type') }}</th>
                        <td>{{ $user->getType() }}</td>
                    </tr>
                    @if($user->type == \App\Model\Admin::TYPE_PROJECT)
                        <tr>
                            <th scope="row">项目</th>
                            <td>
                                @if($user->project && $user->project->id)
                                    {{ $user->project->name }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th scope="row">{{ __('Nickname') }}</th>
                        <td>{{ $user->nickname }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Real name') }}</th>
                        <td>{{ $user->real_name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('ID Card') }}</th>
                        <td>{{ $user->id_card }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('E-mail') }}</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Mobile') }}</th>
                        <td>{{ $user->mobile }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Img') }}</th>
                        <td>
                            @if(\App\Model\File::hasFile($user->img))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($user->img) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Address') }}</th>
                        <td>{{ $user->address }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Role') }}</th>
                        <td>
                            @if(!empty($roles))
                                @foreach($roles as $role)
                                    @if(in_array($role->id, $user->roleIds()))
                                        <div>{{ $role->name }}</div>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>{{ $user->getStatus() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Last login IP') }}</th>
                        <td>{{ $user->last_login_ip }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Last login time') }}</th>
                        <td>{{ $user->last_login_time }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Create Time') }}</th>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop