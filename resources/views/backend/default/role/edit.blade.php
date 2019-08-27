@extends('backend::layout')

@section('title', __('Edit Role'))

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('Edit Role') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label">{{ __('Name') }}</label>
                        <input class="form-control " name="name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name') ?: $role->name }}">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Type') }}</label>
                        <div>
                            {{ $role->getType() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer m-b-2">
                <div class="col-lg-4">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fa fa-check"></i> {{ __('Save') }}
                    </button>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-default btn-sm" href="javascript:history.back(-1);">
                        <i class="fa fa-undo"></i> {{ __('Back') }}
                    </a>
                </div>
            </div>
            <!-- /.box-footer -->
        </div>
    </form>
@stop