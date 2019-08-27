@extends('backend::layout')

@section('title', __('New Role'))

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('New Role') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label">{{ __('Name') }}</label>
                        <input class="form-control " name="name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                        <label class="control-label">{{ __('Type') }}</label>
                        @if($currentAdmin->isSystem())
                            <div class="radio">
                                <label>
                                    <input type="radio" value="0" @if(old('type') === null || old('type') == 0) checked @endif name="type">
                                    系统
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" @if(old('type') == 1) checked @endif name="type">
                                    平台
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="2" @if(old('type') == 2) checked @endif name="type">
                                    项目
                                </label>
                            </div>
                            <span class="help-block text-danger">请谨慎选择,一旦填写将无法更改!</span>
                        @else
                            <div>
                                {{ $currentAdmin->getPermissionType() }}
                            </div>
                            <span class="help-block text-danger">只能新增此类型</span>
                        @endif


                        @if($errors->has('type'))
                            <span class="help-block">{{ $errors->first('type') }}</span>
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