@extends('backend::layout')

@section('title', '查看战队')

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
            <h4 class="text-black f-20">查看战队</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">战队名称</th>
                        <td>{{ $team->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">战队LOGO</th>
                        <td>
                            @if(\App\Model\File::hasFile($team->logo))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($team->logo) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>{{ $team->getStatus() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Create Time') }}</th>
                        <td>{{ $team->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $team->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop