@extends('errors::layout')

@section('title', __('Service Unavailable'))

@section('message')
    <h2 class="headline text-yellow">503</h2>
    <div>
        <h3><i class="fa fa-warning text-yellow"></i>{{__('Be right back.')}}</h3>
        <p>{{__('Sorry, we are doing some maintenance. Please check back soon.')}}</p>
    </div>
@stop