@extends('backend::layout')

@section('title', '更改密码')

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">更改密码</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('orig_password')) has-error @endif">
                        <label class="control-label">原密码</label>
                        <input class="form-control" name="orig_password" type="password" placeholder="原密码">
                        @if($errors->has('orig_password'))
                            <span class="help-block">{{ $errors->first('orig_password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('password')) has-error @endif">
                        <label class="control-label">{{ __('Password') }}</label>
                        <input class="form-control" name="password" type="password" placeholder="{{ __('Password') }}">
                        @if($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                        <label class="control-label">{{ __('Confirm Password') }}</label>
                        <input class="form-control" name="password_confirmation" type="password" placeholder="{{ __('Confirm Password') }}">
                        @if($errors->has('password_confirmation'))
                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        @endif
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