@extends('backend::layout')

@section('title', '战队列表')

@section('content')
    <div class="card border-no">
        <div class="card-body">
            <h4 class="text-black f-20">战队列表</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">战队名称</th>
                        <th scope="col">战队LOGO</th>
                        <th scope="col">状态</th>
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
                                <td>
                                    @if(\App\Model\File::hasFile($item->logo))
                                        <div class="profile_pic">
                                            <img src="{{ \App\Model\File::getFileUrl($item->logo) }}" class="img-circle profile_img">
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->getStatus() }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('team/view'))
                                        <a href="{{ route('admin.team.view', ['id' => $item->id]) }}" class="text-primary" title="{{ __('View') }}"><i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('team/verify') && $item->status >= 0 && $item->status <= 1)
                                        <a href="{{ route('admin.team.verify', ['id' => $item->id]) }}" class="text-danger" title="审核"><i class="fa fa-check"></i></a>
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