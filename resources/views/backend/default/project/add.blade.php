@extends('backend::layout')

@section('title', '新增项目')

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">新增项目</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('type_id')) has-error @endif">
                        <label for="type_id" class="control-label">项目类型</label>
                        <select class="form-control" id="type_id" name="type_id">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            @if(!empty($projectTypes))
                                @foreach($projectTypes as $item)
                                    <option value="{{ $item->id }}" @if(old('type_id') == $item->id) selected @endif >{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('type_id'))
                            <div class="help-block">{{ $errors->first('type_id') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('code')) has-error @endif">
                        <label class="control-label">唯一标识(英文)</label>
                        <input class="form-control " name="code" type="text" placeholder="唯一标识(英文)" value="{{ old('code') }}">
                        @if($errors->has('code'))
                            <span class="help-block">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label">{{ __('Name') }}</label>
                        <input class="form-control " name="name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
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