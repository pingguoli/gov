@extends('backend::layout')

@section('title', '审核战队')

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">审核战队</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">战队名称</label>
                        <div>{{ $team->name }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">战队LOGO</label>
                        <div>
                            @if(\App\Model\File::hasFile($team->logo))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($team->logo) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">审核</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('verify') == 1 || old('verify') === null) checked @endif name="verify">
                                通过
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if((old('verify') !== null && old('verify') == 0)) checked @endif name="verify">
                                驳回
                            </label>
                        </div>
                        @if($errors->has('verify'))
                            <span class="help-block text-danger">{{ $errors->first('verify') }}</span>
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