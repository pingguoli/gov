@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-12">
                <div class="row">
                    <div class="col col-12">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <fieldset class="form-group row">
                                <legend class="col-form-legend col-sm-6">昵称</legend>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="">
                                    @if($errors->has('name'))
                                        <div class="form-text text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info btn-sm">新建</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
@stop