@extends('backend::layout')

@section('title', __('View Menu'))

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
            <h4 class="text-black f-20">{{ __('View Menu') }}</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Parent Menu') }}</th>
                        <td>@if(!empty($menu->parent->title)){{ $menu->parent->title }}@endif</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Icon') }}</th>
                        <td>@if(!empty($menu->icon))<i class="fa {{ $menu->icon }}"></i>@endif</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Name') }}</th>
                        <td>{{ $menu->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Controller / method') }}</th>
                        <td>{{ $menu->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('URL') }}</th>
                        <td>{{ $menu->url }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Sort') }}</th>
                        <td>{{ $menu->sort }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Is displayed as a menu') }}</th>
                        <td>{{ $menu->is_show ? __('Yes') : __('No') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Create Time') }}</th>
                        <td>{{ $menu->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $menu->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop