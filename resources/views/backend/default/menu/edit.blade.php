@extends('backend::layout')

@section('title', __('Edit Menu'))

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('Edit Menu') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('pid')) has-error @endif">
                        <label class="control-label">{{ __('Parent Menu') }}</label>
                        <select class="form-control" name="pid">
                            <option value="0">{{ __('Default top-level') }}</option>
                            @if(!empty($menuOptions))
                                @foreach($menuOptions as $entry)
                                    <option value="{{ $entry->id }}" @if(old('pid') == $entry->id || (old('pid') === null && !empty($menu->pid) && $menu->pid == $entry->id)) selected @endif >{{ $entry->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('pid'))
                            <div class="help-block">{{ $errors->first('pid') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('title')) has-error @endif">
                        <label class="control-label">{{ __('Name') }}</label>
                        <input class="form-control" name="title" type="text" placeholder="{{ __('Name') }}" value="{{ old('title') ?: $menu->title }}">
                        @if($errors->has('title'))
                            <div class="help-block">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label">{{ __('Controller / method') }}</label>
                        <input class="form-control" name="name" type="text" placeholder="{{ __('Controller / method') }}" value="{{ old('name') ?: $menu->name }}">
                        @if($errors->has('name'))
                            <div class="help-block">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('url')) has-error @endif">
                        <label class="control-label">{{ __('URL') }}</label>
                        <input class="form-control" name="url" type="text" placeholder="{{ __('URL') }}" value="{{ old('url') ?: $menu->url }}">
                        @if($errors->has('url'))
                            <div class="help-block">{{ $errors->first('url') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('icon')) has-error @endif">
                        <label class="control-label">{{ __('Icon') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text" id="show-choice-icon">@if(old('icon') ?: $menu->icon)<i class="fa {{ old('icon') ?: $menu->icon }}"></i>@endif</span></div>
                            <input class="form-control" id="select-icon" name="icon" type="text" placeholder="{{ __('Icon') }}" readonly value="{{ old('icon') ?: $menu->icon }}">
                            <div class="input-group-append"><span class="input-group-text" data-toggle="modal" data-target="#icon-modal">{{ __('Choice') }}</span></div>
                            <div class="input-group-append"><span class="input-group-text" id="clear-icon">{{ __('Clear') }}</span></div>
                        </div>
                        @if($errors->has('icon'))
                            <div class="help-block">{{ $errors->first('icon') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('sort')) has-error @endif">
                        <label class="control-label">{{ __('Sort') }}</label>
                        <input class="form-control" name="sort" type="text" placeholder="{{ __('Sort') }}" value="{{ old('sort') ?: $menu->sort }}">
                        @if($errors->has('sort'))
                            <div class="help-block">{{ $errors->first('sort') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Is displayed as a menu') }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('is_show') == 1 || $menu->is_show == 1) checked @endif name="is_show">
                                {{ __('Yes') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if((old('is_show') !== null && old('is_show') == 0) || $menu->is_show == 0) checked @endif name="is_show">
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

@section('overlay')
    <div class="modal fade" id="icon-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Choice Icon') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    @include('backend::faicon')
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        (function () {
            $(function () {
                $('#icon-modal .fa').on('click', function () {
                    var icon = $(this).data('text');
                    $('#select-icon').val(icon);
                    $('#show-choice-icon').html('<i class="fa ' + icon + '"></i>');
                    $('#icon-modal').modal('hide');
                });

                $('#clear-icon').on('click', function () {
                    $('#select-icon').val('');
                    $('#show-choice-icon').html('');
                });
            });
        })(jQuery);
    </script>
@stop