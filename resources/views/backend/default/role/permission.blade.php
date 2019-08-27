@extends('backend::layout')

@section('title', '授权角色')



@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="tile">
                <h3 class="tile-title f-20 ml15">授权角色</h3>
                <form class="form-horizontal" method="post">
                    <div class="tile-body">
                        {{ csrf_field() }}
                        <div class="form-group row form-group2">
                            <label class="control-label col-md-3 col-md-33 control-label2">{{ __('Name') }}</label>
                            <div class="col-md-8 col-md-88">
                                {{ $role->name }}
                            </div>
                        </div>
                        <div class="form-group row form-group3">
                            <div class="col-md-1 pt1rem">{{ __('Authority') }}</div>
                            <div class="col-md-2 pt1rem pt1rem2 animated-checkbox">
                                <label>
                                    <input type="checkbox" id="role-select-all"><span class="label-text">{{ __('Full selected / None selected') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 pt1rem ">
                                @if(!empty($permissions))
                                    @foreach($permissions as $first)
                                        <div class="row animated-checkbox">
                                            <div class="col-md-2">
                                                <label>
                                                    <input type="checkbox" name="permissions[]" class="role-checkbox" @if(is_array(old('permissions')) && in_array($first['id'], old('permissions')) || !is_array(old('permissions')) && in_array($first['id'], $role->permissionIds())) checked @endif value="{{ $first['id'] }}"><span class="label-text">{{ $first['title'] }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-11 offset-1">
                                            @if(!empty($first['children']) && is_array($first['children']))
                                                @foreach($first['children'] as $second)
                                                <div class="row animated-checkbox">
                                                    <div class="col-md-2">
                                                        <label>
                                                            <input type="checkbox" name="permissions[]" class="role-checkbox role-checkbox-{{ $first['id'] }}" @if(is_array(old('permissions')) && in_array($second['id'], old('permissions')) || !is_array(old('permissions')) && in_array($second['id'], $role->permissionIds())) checked @endif value="{{ $second['id'] }}"><span class="label-text">{{ $second['title'] }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-11 offset-1">
                                                    @if(!empty($second['children']) && is_array($second['children']))
                                                        @foreach($second['children'] as $third)
                                                        <div class="row animated-checkbox">
                                                            <div class="col-md-2">
                                                                <label>
                                                                    <input type="checkbox" name="permissions[]" class="role-checkbox role-checkbox-{{ $first['id'] }} role-checkbox-{{ $second['id'] }}" @if(is_array(old('permissions')) && in_array($third['id'], old('permissions'))  || !is_array(old('permissions')) && in_array($third['id'], $role->permissionIds())) checked @endif value="{{ $third['id'] }}"><span class="label-text">{{ $third['title'] }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                @if($errors->has('menus'))
                                    <div class="form-control-feedback text-danger">{{ $errors->first('menus') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <div class="row">
                            <div class="col-md-8 col-md-88 col-md-offset-3">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Save') }}
                                </button>
                                &nbsp;&nbsp;&nbsp;
                                <a class="btn btn-secondary" href="javascript:history.back(-1);">
                                    <i class="fa fa-fw fa-lg fa-times-circle"></i>{{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    (function () {
        $(function () {
            $('#role-select-all').on('click', function () {
                var isChecked = $(this).prop('checked');

                if (isChecked) {
                    /* 选中 */
                    $('.role-checkbox').prop('checked', true);
                } else {
                    /* 取消选中 */
                    $('.role-checkbox').prop('checked', false);
                }
            });

            $('.role-checkbox').on('click', function () {
                var isChecked = $(this).prop('checked');
                var val = $(this).val();

                if (isChecked) {
                    /* 选中 */
                    $('.role-checkbox-' + val).prop('checked', true);
                } else {
                    /* 取消选中 */
                    $('.role-checkbox-' + val).prop('checked', false);
                }
            });
        })
    })(jQuery)
</script>
@stop