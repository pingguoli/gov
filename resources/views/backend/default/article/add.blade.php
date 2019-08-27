@extends('backend::layout')

@section('title', '新增文章')

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">新增文章</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('categories')) has-error @endif">
                        <label class="control-label">项目</label>
                        <select class="form-control" multiple name="categories[]">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            @if(!empty($categories))
                                @foreach($categories as $obj)
                                    <option value="{{ $obj->id }}" @if(is_array(old('categories')) && in_array($obj->id, old('categories'))) selected @endif>{{ $obj->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('categories'))
                            <span class="help-block">{{ $errors->first('categories') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('title')) has-error @endif">
                        <label class="control-label">标题</label>
                        <input class="form-control " name="title" type="text" placeholder="标题" value="{{ old('title') }}">
                        @if($errors->has('title'))
                            <span class="help-block">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('subtitle')) has-error @endif">
                        <label class="control-label">副标题</label>
                        <input class="form-control " name="subtitle" type="text" placeholder="副标题" value="{{ old('subtitle') }}">
                        @if($errors->has('subtitle'))
                            <span class="help-block">{{ $errors->first('subtitle') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('keywords')) has-error @endif">
                        <label class="control-label">关键字</label>
                        <input class="form-control " name="keywords" type="text" placeholder="关键字" value="{{ old('keywords') }}">
                        @if($errors->has('keywords'))
                            <span class="help-block">{{ $errors->first('keywords') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('description')) has-error @endif">
                        <label class="control-label">描述</label>
                        <textarea class="form-control" name="description" rows="4" placeholder="描述">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('thumb')) has-error @endif">
                        <label class="control-label">封面</label>
                        <input type="file" name="thumb" class="dropify" />
                        @if($errors->has('thumb'))
                            <span class="help-block">{{ $errors->first('thumb') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="form-group @if($errors->has('content')) has-error @endif">
                        <label class="control-label">内容</label>
                        <textarea class="form-control summernote-editor" name="content">{{ old('content') }}</textarea>
                        @if($errors->has('content'))
                            <span class="help-block">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('author')) has-error @endif">
                        <label class="control-label">作者</label>
                        <input class="form-control " name="author" type="text" placeholder="作者" value="{{ old('author') }}">
                        @if($errors->has('author'))
                            <span class="help-block">{{ $errors->first('author') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('resource')) has-error @endif">
                        <label class="control-label">来源</label>
                        <input class="form-control " name="resource" type="text" placeholder="来源" value="{{ old('resource') }}">
                        @if($errors->has('resource'))
                            <span class="help-block">{{ $errors->first('resource') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('sort')) has-error @endif">
                        <label class="control-label">排序</label>
                        <input class="form-control " name="sort" type="text" placeholder="排序" value="{{ old('sort') }}">
                        @if($errors->has('sort'))
                            <span class="help-block">{{ $errors->first('sort') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">置顶</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('top') === null || old('top') == 1) checked @endif name="top">
                                {{ __('Yes') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if(old('top') !== null && old('top') == 0) checked @endif name="top">
                                {{ __('No') }}
                            </label>
                        </div>
                        @if($errors->has('top'))
                            <span class="help-block text-danger">{{ $errors->first('top') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Status') }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('status') === null || old('status') == 1) checked @endif name="status">
                                {{ __('Open') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if(old('status') !== null && old('status') == 0) checked @endif name="status">
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

@section('script')
    <script>
        !function ($) {
            $(function () {

            });
        }(jQuery);
    </script>
@stop