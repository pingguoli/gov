@extends('backend::layout')

@section('title', '编辑文章')

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">编辑文章</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('title')) has-error @endif">
                        <label class="control-label">标题</label>
                        <input class="form-control " name="title" type="text" placeholder="标题" value="{{ old('title') ?: $page->title }}">
                        @if($errors->has('title'))
                            <span class="help-block">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('subtitle')) has-error @endif">
                        <label class="control-label">副标题</label>
                        <input class="form-control " name="subtitle" type="text" placeholder="副标题" value="{{ old('subtitle') ?: $page->subtitle }}">
                        @if($errors->has('subtitle'))
                            <span class="help-block">{{ $errors->first('subtitle') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('keywords')) has-error @endif">
                        <label class="control-label">关键字</label>
                        <input class="form-control " name="keywords" type="text" placeholder="关键字" value="{{ old('keywords') ?: $page->keywords }}">
                        @if($errors->has('keywords'))
                            <span class="help-block">{{ $errors->first('keywords') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('description')) has-error @endif">
                        <label class="control-label">描述</label>
                        <textarea class="form-control" name="description" rows="4" placeholder="描述">{{ old('description') ?: $page->description }}</textarea>
                        @if($errors->has('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="form-group @if($errors->has('content')) has-error @endif">
                        <label class="control-label">内容</label>
                        <textarea class="form-control summernote-editor" name="content">{{ old('content') ?: $page->content }}</textarea>
                        @if($errors->has('content'))
                            <span class="help-block">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('author')) has-error @endif">
                        <label class="control-label">作者</label>
                        <input class="form-control " name="author" type="text" placeholder="作者" value="{{ old('author') ?: $page->author }}">
                        @if($errors->has('author'))
                            <span class="help-block">{{ $errors->first('author') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('resource')) has-error @endif">
                        <label class="control-label">来源</label>
                        <input class="form-control " name="resource" type="text" placeholder="来源" value="{{ old('resource') ?: $page->resource }}">
                        @if($errors->has('resource'))
                            <span class="help-block">{{ $errors->first('resource') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Status') }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('status') == 1 || old('status') === null && $page->status == 1) checked @endif name="status">
                                {{ __('Open') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if((old('status') !== null && old('status') == 0) || old('status') === null && $page->status == 0) checked @endif name="status">
                                {{ __('Close') }}
                            </label>
                        </div>
                        @if($errors->has('status'))
                            <span class="help-block text-danger">{{ $errors->first('status') }}</span>
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