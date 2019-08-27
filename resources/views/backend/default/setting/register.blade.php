@extends('backend::layout')

@section('title', '注册设置')

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">注册设置</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('register:money')) has-error @endif">
                        <label class="control-label">注册支付金额</label>
                        <input class="form-control " name="register:money" type="text" placeholder="注册支付金额" value="{{ old('register:money') ?: (old('register:money') === null && array_key_exists('register:money', $setting) ? $setting['register:money'] : '') }}">
                        @if($errors->has('register:money'))
                            <span class="help-block">{{ $errors->first('register:money') }}</span>
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