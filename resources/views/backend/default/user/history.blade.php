@extends('backend::layout')

@section('title', '历史记录')

@section('content')
    <div class="card border-no">
        <div class="card-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="javascript:history.back(-1);" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
                    </p>
                </div>
            </div>
            <h4 class="text-black f-20">历史记录</h4>
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
                        <th scope="col">记录时间</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($histories))
                        @foreach($histories as $idx => $item)
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
                                <td>{{ $item->history_time }}</td>
                                <td>
                                    <a href="{{ route('admin.user.detail', ['id' => $item->id]) }}" class="text-primary" title="{{ __('View') }}"><i class="fa fa-eye"></i></a>
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
                    @if(isset($histories))
                        {{ $histories->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop