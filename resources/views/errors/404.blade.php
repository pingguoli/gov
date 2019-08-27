@extends('errors::layout')

@section('title', __('Page Not Found'))

@section('message')
    <h2 class="headline text-yellow">404</h2>
    <div>
        <h3><i class="fa fa-warning text-yellow"></i>{{__('Page Not Found')}}</h3>
        <p>{{__('Sorry, the page you are looking for could not be found.')}}</p>
    </div>
@stop
