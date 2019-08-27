@extends('backend::layout')

@section('title', '编辑运动员')

@section('content')
    @if(!$verifyManager)
        <div class="alert alert-warning" role="alert">{{ $notice }}</div>
    @endif
    <form method="post" id="check-form">
        {{ csrf_field() }}
        <input type="hidden" id="current_password" name="current_password">
        <input type="hidden" id="verify_password" name="verify_password">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('Edit Account') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('password')) has-error @endif">
                        <label class="control-label">{{ __('Password') }}</label>
                        <input class="form-control" name="password" type="password" placeholder="{{ __('Password') }}">
                        @if($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                        <label class="control-label">{{ __('Confirm Password') }}</label>
                        <input class="form-control" name="password_confirmation" type="password" placeholder="{{ __('Confirm Password') }}">
                        @if($errors->has('password_confirmation'))
                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('nickname')) has-error @endif">
                        <label class="control-label">{{ __('Nickname') }}</label>
                        <input class="form-control" name="nickname" type="text" placeholder="{{ __('Nickname') }}" value="{{ old('nickname') ?: $user->nickname }}">
                        @if($errors->has('nickname'))
                            <span class="help-block">{{ $errors->first('nickname') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label">{{ __('Username') }}</label>
                        <input class="form-control" name="name" type="text" placeholder="{{ __('Username') }}" value="{{ old('name') ?: $user->name }}">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('id_card')) has-error @endif">
                        <label class="control-label">{{ __('ID Card') }}</label>
                        <input class="form-control" name="id_card" type="text" placeholder="{{ __('ID Card') }}" value="{{ old('id_card') ?: $user->id_card }}">
                        @if($errors->has('id_card'))
                            <span class="help-block">{{ $errors->first('id_card') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Sex') }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('sex') == 1 || old('sex') === null && $user->sex == 1) checked @endif name="sex">
                                {{ __('Male') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="2" @if(old('sex') == 2 || old('sex') === null && $user->sex == 2) checked @endif name="sex">
                                {{ __('Female') }}
                            </label>
                        </div>
                        @if($errors->has('status'))
                            <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('birthday')) has-error @endif">
                        <label class="control-label">{{ __('Birthday') }}</label>
                        <input class="form-control" name="birthday" type="text" placeholder="{{ __('Birthday') }}" value="{{ old('birthday') ?: $user->birthday }}">
                        @if($errors->has('birthday'))
                            <span class="help-block">{{ $errors->first('birthday') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                        <label class="control-label">{{ __('E-mail') }}</label>
                        <input class="form-control" name="email" type="text" placeholder="{{ __('E-mail') }}" value="{{ old('email') ?: $user->email }}">
                        @if($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('mobile')) has-error @endif">
                        <label class="control-label">{{ __('Mobile') }}</label>
                        <input class="form-control" name="mobile" type="text" placeholder="{{ __('Mobile') }}" value="{{ old('mobile') ?: $user->mobile }}">
                        @if($errors->has('mobile'))
                            <span class="help-block">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('address')) has-error @endif">
                        <label class="control-label">{{ __('Address') }}</label>
                        <textarea class="form-control" name="address" rows="4" placeholder="{{ __('Address') }}">{{ old('address') ?: $user->address }}</textarea>
                        @if($errors->has('address'))
                            <span class="help-block">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('nationality')) has-error @endif">
                        <label class="control-label">国籍</label>
                        <select class="form-control" name="nationality">
                            <option value="">{{__('-- Please Selected --')}}</option>
                            @foreach(\App\Support\Enum::$nationality as $key => $title)
                                <option value="{{ $key }}" {{ old('nationality') == $key || old('nationality') === null && $user->nationality == $key ? 'selected' : '' }}>{{ __($title) }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('nationality'))
                            <span class="help-block">{{ $errors->first('nationality') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('education')) has-error @endif">
                        <label class="control-label">学历</label>
                        <select class="form-control" name="education">
                            <option value="">{{__('-- Please Selected --')}}</option>
                            @foreach(\App\Support\Enum::$education as $key => $title)
                                <option value="{{ $key }}" {{ old('education') == $key || old('education') === null && $user->education == $key ? 'selected' : '' }}>{{ __($title) }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('education'))
                            <span class="help-block">{{ $errors->first('education') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                        <label class="control-label">{{ __('Type') }}</label>
                        <select class="form-control" name="type">
                            <option value="">{{__('-- Please Selected --')}}</option>
                            @foreach(\App\Model\User::$types as $key => $title)
                                <option value="{{ $key }}" {{ old('type') == $key || old('type') === null && $user->type == $key ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('type'))
                            <span class="help-block">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('img')) has-error @endif">
                        <label class="control-label">照片</label>
                        <div class="chunk-upload">
                            <input type="hidden" class="img"  name="img" value="{{ old('img') ?: $user->img }}">
                            <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('img') ?: $user->img, asset('images/photo-default.jpg')) }}" />
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="form-text text-info output"></p>
                            <input type="file" class="img_upload">
                        </div>
                        @if($errors->has('img'))
                            <span class="help-block">{{ $errors->first('img') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">证件类型</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('id_card_type') == 1 || old('id_card_type') === null && $user->id_card_type == 1) checked @endif name="id_card_type">
                                身份证
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="2" @if(old('id_card_type') == 2 || old('id_card_type') === null && $user->id_card_type == 2) checked @endif name="id_card_type">
                                户口
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="3" @if(old('id_card_type') == 3 || old('id_card_type') === null && $user->id_card_type == 3) checked @endif name="id_card_type">
                                护照
                            </label>
                        </div>
                        @if($errors->has('id_card_type'))
                            <span class="help-block text-danger">{{ $errors->first('id_card_type') }}</span>
                        @endif
                    </div>
                </div>

                <div class="card_types card_type1" style="{{ old('id_card_type') == 1 || $user->id_card_type == 1 ? '' : 'display:none;' }}">
                    <div class="col-lg-4">
                        <div class="form-group @if($errors->has('id_card_face')) has-error @endif">
                            <label class="control-label">身份证头像面</label>
                            <div class="chunk-upload">
                                <input type="hidden" class="img"  name="id_card_face" value="{{ old('id_card_face') ?: $user->id_card_face }}">
                                <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('id_card_face') ?: $user->id_card_face, asset('images/photo-default.jpg')) }}" />
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="form-text text-info output"></p>
                                <input type="file" class="img_upload">
                            </div>
                            @if($errors->has('id_card_face'))
                                <span class="help-block">{{ $errors->first('id_card_face') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group @if($errors->has('id_card_nation')) has-error @endif">
                            <label class="control-label">身份证国徽面</label>
                            <div class="chunk-upload">
                                <input type="hidden" class="img"  name="id_card_nation" value="{{ old('id_card_nation') ?: $user->id_card_nation }}">
                                <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('id_card_nation') ?: $user->id_card_nation, asset('images/photo-default.jpg')) }}" />
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="form-text text-info output"></p>
                                <input type="file" class="img_upload">
                            </div>
                            @if($errors->has('id_card_nation'))
                                <span class="help-block">{{ $errors->first('id_card_nation') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card_types card_type2" style="{{ old('id_card_type') == 2 || $user->id_card_type == 2 ? '' : 'display:none;' }}">
                    <div class="col-lg-4">
                        <div class="form-group @if($errors->has('house_img')) has-error @endif">
                            <label class="control-label">户口照片</label>
                            <div class="chunk-upload">
                                <input type="hidden" class="img"  name="house_img" value="{{ old('house_img') ?: $user->house_img }}">
                                <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('house_img') ?: $user->house_img, asset('images/photo-default.jpg')) }}" />
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="form-text text-info output"></p>
                                <input type="file" class="img_upload">
                            </div>
                            @if($errors->has('house_img'))
                                <span class="help-block">{{ $errors->first('house_img') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card_types card_type3" style="{{ old('id_card_type') == 3 || $user->id_card_type == 3 ? '' : 'display:none;' }}">
                    <div class="col-lg-4">
                        <div class="form-group @if($errors->has('passport_img')) has-error @endif">
                            <label class="control-label">护照照片</label>
                            <div class="chunk-upload">
                                <input type="hidden" class="img"  name="passport_img" value="{{ old('passport_img') ?: $user->passport_img }}">
                                <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('passport_img') ?: $user->passport_img, asset('images/photo-default.jpg')) }}" />
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="form-text text-info output"></p>
                                <input type="file" class="img_upload">
                            </div>
                            @if($errors->has('passport_img'))
                                <span class="help-block">{{ $errors->first('passport_img') }}</span>
                            @endif
                        </div>
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

    <!-- Modal -->
    <div class="modal fade" id="showChanges" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">确认修改</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body text-danger" id="changesMessage">

                        </div>
                        <div class="card-footer">
                            <div class="col">
                                <div class="form-group">
                                    <label for="set_current_password" class="control-label">当前用户密码</label>
                                    <input class="form-control" id="set_current_password" type="password" placeholder="当前用户密码">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="set_verify_password" class="control-label">审核人@if($verifyManager) ({{ $verifyManager->nickname ?: $verifyManager->username }})@endif密码</label>
                                    <input class="form-control" id="set_verify_password" type="password" placeholder="审核人密码">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-remove"></i> 取消</button>
                    <button type="button" id="saveShowChanges" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> 确定</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        !function ($) {
            $(function () {
                $('.img_upload').chunkUpload({
                    processUrl: '{{ route('admin.process') }}',
                    uploadUrl: '{{ route('admin.uploading') }}',
                });

                $('input[name="id_card_type"]').on('change', function () {
                    $('input[name="id_card_type"]').each(function (index, ele) {
                        if ($(ele).prop('checked')) {
                            var key = $(ele).val();
                            $('.card_types').hide();
                            $('.card_type' + key).show();
                        }
                    });

                    return false;
                });

                var isSubmit = false;
                $('#check-form').on('submit', function () {
                    if (isSubmit) {
                        isSubmit = false;
                        var currentPass = $('#set_current_password');
                        var verifyPass = $('#set_verify_password');

                        currentPass.parents('.form-group').removeClass('has-error');
                        verifyPass.parents('.form-group').removeClass('has-error');
                        if (currentPass.val() === '') {
                            currentPass.parents('.form-group').addClass('has-error');
                            return false;
                        }
                        if (verifyPass.val() === '') {
                            verifyPass.parents('.form-group').addClass('has-error');
                            return false;
                        }

                        $('#current_password').val(currentPass.val());
                        $('#verify_password').val(verifyPass.val());
                    } else {
                        var $this = $(this);
                        var data = $this.serializeArray();
                        $.ajax({
                            url: '{{ route('admin.user.check', ['id' => $user->id]) }}',
                            type: "POST",
                            data: data,
                            dataType: "json",
                            success: function (rst) {
                                if (rst.status === 200) {
                                    var messages = $('#changesMessage');
                                    messages.html('');
                                    if (rst.changes !== undefined && $.isPlainObject(rst.changes)) {
                                        $.each(rst.changes, function (key, item) {
                                            if ($.isPlainObject(item)) {
                                                messages.append('<div class="row">' +
                                                    '<div class="col col-3">' + item.name + '</div>' +
                                                    '<div class="col">' + item.orig + ' --> ' + item.new + '</div>' +
                                                    '</div>');
                                            } else {
                                                messages.append('<div class="row">' +
                                                    '<div class="col col-3"></div>' +
                                                    '<div class="col">' + item + '</div>' +
                                                    '</div>');
                                            }

                                        });
                                    } else {
                                        messages.append('<div>没有修改任何内容</div>');
                                    }

                                    $('#showChanges').modal();
                                } else {
                                    $.ShowErrorMsg(rst);
                                }
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                $.ShowErrorMsg(XMLHttpRequest);
                            }
                        });

                        return false;
                    }
                });

                $('#saveShowChanges').on('click', function () {
                    isSubmit = true;
                    $('#check-form').submit();
                });
            });
        }(jQuery);
    </script>
@stop