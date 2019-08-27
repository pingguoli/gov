@extends('backend::layout')

@section('title', '新增审核设置')

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">新增审核设置</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                        <label for="type" class="control-label">{{ __('Type') }}</label>
                        <select class="form-control" id="type" name="type">
                            <option value="0">{{ __('-- Please Selected --') }}</option>
                            @foreach(\App\Model\Verify::$types as $key => $val)
                                <option value="{{ $key }}" @if(old('type') == $key) selected @endif >{{ $val }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('type'))
                            <div class="help-block">{{ $errors->first('type') }}</div>
                        @endif
                    </div>
                </div>

                <div id="project" class="@if(!in_array(old('type'), \App\Model\Verify::$projectSome)) hide @endif">
                    <div class="col-lg-4">
                        <div class="form-group @if($errors->has('project_id')) has-error @endif">
                            <label for="project_id" class="control-label">项目</label>
                            <select class="form-control" id="project_id" name="project_id">
                                <option value="0">{{ __('-- Please Selected --') }}</option>
                                @if(!empty($projects))
                                    @foreach($projects as $item)
                                        <option value="{{ $item->id }}" @if(old('project_id') == $item->id) selected @endif >{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($errors->has('project_id'))
                                <div class="help-block">{{ $errors->first('project_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('admin_id')) has-error @endif">
                        <label for="admin_id" class="control-label">管理员</label>
                        <select class="form-control" id="admin_id" name="admin_id">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            @if(!empty($managers))
                                @foreach($managers as $item)
                                    <option value="{{ $item->id }}" @if(old('admin_id') == $item->id) selected @endif >{{ $item->nickname ?: $item->username }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('admin_id'))
                            <div class="help-block">{{ $errors->first('admin_id') }}</div>
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
                var someProjects = {};
                @foreach(\App\Model\Verify::$projectSome as $key)
                    someProjects['{{$key}}'] = '{{$key}}';
                @endforeach
                $('#type').on('change', function () {
                    var type = $(this).val();

                    if (someProjects[type] !== undefined) {
                        $('#project').removeClass('hide');
                    } else {
                        $('#project').addClass('hide');
                    }

                    loadManagers();

                    return false;
                });

                $('#project_id').on('change', function () {

                    loadManagers();
                    return false;
                });

                var loadManagers = function () {
                    var type = $('#type').val();
                    var projectId = $('#project_id').val();
                    var adminId = $('#admin_id');
                    adminId.html('');
                    adminId.append('<option value="">' + '{{ __('-- Please Selected --') }}' + '</option>');

                    $.ajax({
                        url: '{{ route('admin.verify.manager') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            type: type,
                            project_id: projectId,
                        },
                        dataType: "json",
                        success: function (res) {
                            if (res.status === 200) {
                                $.each(res.lists, function (key, item) {
                                    adminId.append('<option value="' + key + '">' + item + '</option>');
                                });
                            } else {
                                $.ShowErrorMsg(res);
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            $.ShowErrorMsg(XMLHttpRequest);
                        }

                    });
                };
            });
        }(jQuery);
    </script>
@stop