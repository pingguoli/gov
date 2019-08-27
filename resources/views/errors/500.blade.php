@extends('errors::layout')

@section('title', __('Error'))

@section('message')
    <h2 class="headline text-yellow">500</h2>
    <div>
        <h3><i class="fa fa-warning text-yellow"></i>{{__('Whoops!')}}</h3>
        <p>{{__('Whoops, something went wrong on our servers.')}}</p>
    </div>
@stop
