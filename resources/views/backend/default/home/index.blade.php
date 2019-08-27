@extends('backend::layout')

@section('title', __('Home'))



@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title tile-title2 f-20">{{ __('Product information') }}</h3>
                <table class="table table-striped table2">
                    <tr>
                        <td width="100">{{ __('Product name') }}</td>
                        <td>{{ config('site.base.name') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Core framework') }}</td>
                        <td>Laravel / {{ app()->version() }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Development author') }}</td>
                        <td><a target="_blank" href="{{ config('site.link') }}">{{ config('site.author') }}</a></td>
                    </tr>

                    <tr>
                        <td>{{ __('System time zone') }}</td>
                        <td>{{ config('app.timezone') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Language environment') }}</td>
                        <td>{{ config('app.locale') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('System mode') }}</td>
                        <td>{{ config('app.env') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('System URL') }}</td>
                        <td>{{ config('app.url') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title tile-title2 f-20">{{ __('Server information') }}</h3>
                <table class="table table-striped">
                    <tr>
                        <td width="100">{{ __('Operating system') }}</td>
                        <td>{{ php_uname() }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Running environment') }}</td>
                        <td>{{ array_get($_SERVER, 'SERVER_SOFTWARE') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('PHP Version') }}</td>
                        <td>PHP / {{ PHP_VERSION }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Cache driver') }}</td>
                        <td>{{ config('cache.default') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Session driver') }}</td>
                        <td>{{ config('session.driver') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Queue driver') }}</td>
                        <td>{{ config('queue.default') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('File system') }}</td>
                        <td>{{ config('filesystems.default') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop