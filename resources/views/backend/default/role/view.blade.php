@extends('backend::layout')

@section('title', __('View Role'))

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
            <h4 class="text-black f-20">{{ __('View Role') }}</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Name') }}</th>
                        <td>{{ $role->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Type') }}</th>
                        <td>{{ $role->getType() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Authority') }}</th>
                        <td>
                            <div class="col-md-12">
                                @if(!empty($permissions))
                                    @foreach($permissions as $first)
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>
                                                    <input type="checkbox" name="permissions[]" disabled @if(in_array($first['id'], $role->permissionIds())) checked @endif value="{{ $first['id'] }}"><span class="label-text">{{ $first['title'] }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-11 offset-1">
                                            @if(!empty($first['children']) && is_array($first['children']))
                                                @foreach($first['children'] as $second)
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>
                                                                <input type="checkbox" name="permissions[]" disabled @if(in_array($second['id'], $role->permissionIds())) checked @endif value="{{ $second['id'] }}"><span class="label-text">{{ $second['title'] }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-11 offset-1">
                                                        @if(!empty($second['children']) && is_array($second['children']))
                                                            @foreach($second['children'] as $third)
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label>
                                                                            <input type="checkbox" name="permissions[]" disabled @if(in_array($third['id'], $role->permissionIds())) checked @endif value="{{ $third['id'] }}"><span class="label-text">{{ $third['title'] }}</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Create Time') }}</th>
                        <td>{{ $role->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $role->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop