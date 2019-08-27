@extends('errors::layout')

@section('title', __('Page Expired'))

@section('message')
    <h2 class="headline text-yellow">419</h2>
    <div>
        <h3><i class="fa fa-warning text-yellow"></i>{{__('Sorry, your session has expired. Please refresh and try again.')}}</h3>
        <p>{{__('Please refresh and try again.')}}</p>
    </div>
@stop
