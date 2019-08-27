@extends('backend::layout')

@section('title', '新增导航')

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">新增导航</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('position')) has-error @endif">
                        <label class="control-label">导航位置</label>
                        <select class="form-control" id="position" name="position">
                            @foreach(\App\Model\Navigation::$positions as $key => $title)
                                <option value="{{ $key }}" @if(old('position') == $key || old('position') === null && $key == \App\Model\Navigation::POSITION_DEFAULT) selected @endif >{{ $title }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('position'))
                            <div class="help-block">{{ $errors->first('position') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('parent_id')) has-error @endif">
                        <label class="control-label">上级导航</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="0">无上级</option>
                            @if(!empty($navigationOptions))
                                @foreach($navigationOptions as $entry)
                                    <option value="{{ $entry->id }}" @if(old('parent_id') == $entry->id) selected @endif >{{ $entry->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('parent_id'))
                            <div class="help-block">{{ $errors->first('parent_id') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label">名称</label>
                        <input class="form-control" name="name" type="text" placeholder="名称" value="{{ old('name') }}">
                        @if($errors->has('name'))
                            <div class="help-block">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                        <label class="control-label">类型</label>
                        <select class="form-control" id="type" name="type">
                            @foreach(\App\Model\Navigation::$types as $key => $title)
                                <option value="{{ $key }}" @if(old('type') == $key || old('type') === null && $key == \App\Model\Navigation::TYPE_LINK) selected @endif >{{ $title }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('type'))
                            <div class="help-block">{{ $errors->first('type') }}</div>
                        @endif
                    </div>
                </div>
                <div id="link" class="type-change col-lg-4 @if(old('type') !== null && old('type') != \App\Model\Navigation::TYPE_LINK) hide @endif">
                    <div class="form-group @if($errors->has('link')) has-error @endif">
                        <label class="control-label">链接</label>
                        <input class="form-control" name="link" type="text" placeholder="链接" value="{{ old('link') }}">
                        @if($errors->has('link'))
                            <div class="help-block">{{ $errors->first('link') }}</div>
                        @endif
                    </div>
                </div>
                <div id="category" class="type-change col-lg-4 @if(old('type') === null || old('type') != \App\Model\Navigation::TYPE_CATEGORY) hide @endif">
                    <div class="form-group @if($errors->has('category_id')) has-error @endif">
                        <label class="control-label">分类</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            @if(!empty($categories))
                                @foreach($categories as $entry)
                                    <option value="{{ $entry->id }}" @if(old('category_id') == $entry->id) selected @endif >{{ $entry->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('category_id'))
                            <div class="help-block">{{ $errors->first('category_id') }}</div>
                        @endif
                    </div>
                </div>
                <div id="page" class="type-change col-lg-4 @if(old('type') === null || old('type') != \App\Model\Navigation::TYPE_PAGE) hide @endif">
                    <div class="form-group @if($errors->has('page_id')) has-error @endif">
                        <label class="control-label">单页</label>
                        <select class="form-control" id="page_id" name="page_id">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            @if(!empty($pages))
                                @foreach($pages as $entry)
                                    <option value="{{ $entry->id }}" @if(old('page_id') == $entry->id) selected @endif >{{ $entry->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('page_id'))
                            <div class="help-block">{{ $errors->first('page_id') }}</div>
                        @endif
                    </div>
                </div>
                <div id="article" class="type-change col-lg-4 @if(old('type') === null || old('type') != \App\Model\Navigation::TYPE_ARTICLE) hide @endif">
                    <div class="form-group @if($errors->has('article_id')) has-error @endif">
                        <label class="control-label">文章</label>
                        <select class="form-control" id="article_id" name="article_id">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            @if(!empty($artiles))
                                @foreach($artiles as $entry)
                                    <option value="{{ $entry->id }}" @if(old('article_id') == $entry->id) selected @endif >{{ $entry->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('article_id'))
                            <div class="help-block">{{ $errors->first('article_id') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">是否新建标签</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('target') === null || old('target') == 1) checked @endif name="target">
                                {{ __('Yes') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if(old('target') !== null && old('target') == 0) checked @endif name="target">
                                {{ __('No') }}
                            </label>
                        </div>
                        @if($errors->has('target'))
                            <div class="help-block text-danger">{{ $errors->first('target') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('sort')) has-error @endif">
                        <label class="control-label">排序</label>
                        <input class="form-control" name="sort" type="text" placeholder="排序" value="{{ old('sort') ?: 100 }}">
                        @if($errors->has('sort'))
                            <div class="help-block">{{ $errors->first('sort') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">是否显示</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('is_show') === null || old('is_show') == 1) checked @endif name="is_show">
                                {{ __('Yes') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if(old('is_show') !== null && old('is_show') == 0) checked @endif name="is_show">
                                {{ __('No') }}
                            </label>
                        </div>
                        @if($errors->has('is_show'))
                            <div class="help-block text-danger">{{ $errors->first('is_show') }}</div>
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
        !function () {
            $(function () {
                $('#position').on('change', function () {
                    var val = $(this).val();

                    var parent = $('#parent_id');
                    parent.html('');
                    parent.append('<option value="0">无上级</option>');

                    $.ajax({
                        url: '{{ route('admin.navigation.parent') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            position: val,
                            id: 0,
                        },
                        dataType: "json",
                        success: function (res) {
                            if (res.status === 200) {
                                $.each(res.lists, function (key, item) {
                                    parent.append('<option value="' + item.id + '">' + item.name + '</option>');
                                });
                            } else {
                                $.ShowErrorMsg(res);
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            $.ShowErrorMsg(XMLHttpRequest);
                        }

                    });

                    return false;
                });

                $('#type').on('change', function () {
                    var val = $(this).val();

                    $('.type-change').addClass('hide');
                    if (val === '{{ \App\Model\Navigation::TYPE_LINK }}') {
                        $('#link').removeClass('hide');
                    } else if (val === '{{ \App\Model\Navigation::TYPE_CATEGORY }}') {
                        $('#category').removeClass('hide');
                    } else if (val === '{{ \App\Model\Navigation::TYPE_PAGE }}') {
                        $('#page').removeClass('hide');
                    } else if (val === '{{ \App\Model\Navigation::TYPE_ARTICLE }}') {
                        $('#article').removeClass('hide');
                    }

                    return false;
                });
            });
        }(jQuery);
    </script>
@stop