@extends('errors::layout')

@section('title', __('Too many requests'))

@section('message')
    <h2 class="headline text-yellow">429</h2>
    <div>
        <h3><i class="fa fa-warning text-yellow"></i>{{__('Sorry, you are making too many requests to our servers.')}}</h3>
        <p>{{__('Please try again later.')}}</p>
    </div>
@stop
