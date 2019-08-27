@extends('errors::layout')

@section('title', __("Forbidden"))

@section('message')
    <h2 class="headline text-yellow">403</h2>
    <div>
        <h3><i class="fa fa-warning text-yellow"></i>{{__('Forbidden')}}</h3>
        <p>{{__('Sorry, you are forbidden from accessing this page.')}}</p>
    </div>
@stop
