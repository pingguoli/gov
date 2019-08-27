@extends('backend::layout')

@section('title', '运动员列表')

@section('content')
    <div class="card border-no">
        <div class="card-body">
            <h4 class="text-black f-20">运动员列表</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Nickname') }}</th>
                        <th scope="col">{{ __('Username') }}</th>
                        <th scope="col">{{ __('Sex') }}</th>
                        <th scope="col">{{ __('E-mail') }}</th>
                        <th scope="col">{{ __('Mobile') }}</th>
                        <th scope="col">{{ __('Birthday') }}</th>
                        <th scope="col">{{ __('Img') }}</th>
                        <th scope="col">{{ __('Type') }}</th>
                        <th scope="col">是否注册完成</th>
                        <th scope="col">{{ __('Last login time') }}</th>
                        <th scope="col">{{ __('Last login IP') }}</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($users))
                        @foreach($users as $idx => $item)
                            <tr>
                                <th scope="row">{{ $idx + 1 }}</th>
                                <td>{{ $item->nickname }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->getSex() }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->birthday }}</td>
                                <td>
                                    @if(\App\Model\File::hasFile($item->img))
                                        <img src="{{\App\Model\File::getFileUrl($item->img)}}" class="img-circle">
                                    @endif
                                </td>
                                <td>{{ $item->getType() }}</td>
                                <td>{{ $item->isComplete() }}</td>
                                <td>{{ $item->last_login_time }}</td>
                                <td>{{ $item->last_login_ip }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('user/history'))
                                        <a href="{{ route('admin.user.history', ['id' => $item->id]) }}" class="text-warning" title="历史记录"><i class="fa fa-list"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('user/view'))
                                        <a href="{{ route('admin.user.view', ['id' => $item->id]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('user/edit'))
                                        <a href="{{ route('admin.user.edit', ['id' => $item->id]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
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
                    @if(isset($users))
                        {{ $users->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop