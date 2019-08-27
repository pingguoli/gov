@extends('backend::layout')

@section('title', __('System setting'))

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('System setting') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Debug mode') }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('debug') == 1 || old('debug') === null && array_key_exists('debug', $setting) && $setting['debug'] == 1) checked @endif name="debug">
                                {{ __('Open') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if(old('debug') !== null && old('debug') == 0  || old('status') === null && array_key_exists('debug', $setting) && $setting['debug'] == 0) checked @endif name="debug">
                                {{ __('Close') }}
                            </label>
                        </div>
                        @if($errors->has('debug'))
                            <span class="help-block text-danger">{{ $errors->first('debug') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('log_level')) has-error @endif">
                        <label class="control-label">{{ __('Log level') }}</label>
                        <select class="form-control" name="log_level">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            <option value="debug" @if(old('log_level') == 'debug' || old('log_level') === null && array_key_exists('log_level', $setting) && $setting['log_level'] == 'debug') selected @endif>{{ __('Debug') }}</option>
                            <option value="info" @if(old('log_level') == 'info' || old('log_level') === null && array_key_exists('log_level', $setting) && $setting['log_level'] == 'info') selected @endif>{{ __('Info') }}</option>
                            <option value="notice" @if(old('log_level') == 'notice' || old('log_level') === null && array_key_exists('log_level', $setting) && $setting['log_level'] == 'notice') selected @endif>{{ __('Notice') }}</option>
                            <option value="warning" @if(old('log_level') == 'warning' || old('log_level') === null && array_key_exists('log_level', $setting) && $setting['log_level'] == 'warning') selected @endif>{{ __('Warning') }}</option>
                            <option value="error" @if(old('log_level') == 'error' || old('log_level') === null && array_key_exists('log_level', $setting) && $setting['log_level'] == 'error') selected @endif>{{ __('Error') }}</option>
                        </select>
                        @if($errors->has('log_level'))
                            <div class="help-block">{{ $errors->first('log_level') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('log_max_files')) has-error @endif">
                        <label class="control-label">{{ __('Number of log files retained') }}</label>
                        <input class="form-control " name="log_max_files" type="text" placeholder="{{ __('Number of log files retained') }}" value="{{ old('log_max_files') ?: (old('log_max_files') === null && array_key_exists('log_max_files', $setting) ? $setting['log_max_files'] : '') }}">
                        @if($errors->has('log_max_files'))
                            <span class="help-block">{{ $errors->first('log_max_files') }}</span>
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