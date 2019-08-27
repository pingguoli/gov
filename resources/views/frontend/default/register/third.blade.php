@extends('frontend::layouts.default')

@section('title', __('Register'))

@section('style')
    @include('frontend::register._css')
@stop

@section('content')
    @include('frontend::layouts._error')

    <!--login-->
    <div class="login register register2 register3">
        <div class="step"><img src="{{ asset('images/step3.jpg') }}" /></div>
        <div class="login-form register1-form">
            <form action="" method="post">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" name="id" value="{{ old('id') ?: $user->id }}">
                <input type="hidden" class="form-control" name="code" value="{{ old('code') ?: $user->code }}">
                <input type="hidden" class="form-control" name="mobile" value="{{ old('mobile') ?: $user->mobile }}">

                <div class="password single"><span>照片</span>
                    <div class="upload chunk-upload">
                        <input type="hidden" class="img"  name="img" value="{{ old('img') ?: $user->img }}">
                        <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('img') ?: $user->img, asset('images/photo-default.jpg')) }}" />
                        <label class="file-box" for="file1">选择文件<input class="file-input img_upload" id="file1" type="file" /></label>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="form-text text-info output"></p>
                        @if($errors->has('img'))
                            {{ $errors->first('img') }}
                        @endif
                    </div>
                </div>
                <div class="forget is-agreen3 single"><span>证件类型</span>
                    <label for="agree"><input id="agree" name="id_card_type"  type="radio" {{ old('id_card_type') == 1 || $user->id_card_type == 1 || (!old('id_card_type') && $user->id_card_type == 0) ? 'checked' : '' }} value="1" /><span></span>身份证</label>
                    <label for="agree2"><input id="agree2" name="id_card_type" type="radio" {{ old('id_card_type') == 2 || $user->id_card_type == 2 ? 'checked' : '' }} value="2" /><span></span>户口</label>
                    <label for="agree3"><input id="agree3" name="id_card_type" type="radio" {{ old('id_card_type') == 3 || $user->id_card_type == 3 ? 'checked' : '' }} value="3" /><span></span>护照</label>
                </div>
                @if($errors->has('id_card_type'))
                    {{ $errors->first('id_card_type') }}
                @endif
                <div class="card_types card_type1" style="{{ old('id_card_type') == 1 || $user->id_card_type == 1 || (!old('id_card_type') && $user->id_card_type == 0) ? '' : 'display:none;' }}">
                    <div class="password single"><span>身份证头像面</span>
                        <div class="upload chunk-upload">
                            <input type="hidden" class="img"  name="id_card_face" value="{{ old('id_card_face') ?: $user->id_card_face }}">
                            <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('id_card_face') ?: $user->id_card_face, asset('images/photo-default.jpg')) }}" />
                            <label class="file-box" for="file2">选择文件<input class="file-input img_upload" id="file2" type="file" /></label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="form-text text-info output"></p>
                            <span class="red">
                            @if($errors->has('id_card_face'))
                                {{ $errors->first('id_card_face') }}
                            @endif
                            </span>
                        </div>
                    </div>
                    <div class="password single"><span>身份证国徽面</span>
                        <div class="upload chunk-upload">
                            <input type="hidden" class="img"  name="id_card_nation" value="{{ old('id_card_nation') ?: $user->id_card_nation }}">
                            <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('id_card_nation') ?: $user->id_card_nation, asset('images/photo-default.jpg')) }}" />
                            <label class="file-box" for="file3">选择文件<input class="file-input img_upload" id="file3" type="file" /></label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="form-text text-info output"></p>
                            <span class="red">
                            @if($errors->has('id_card_nation'))
                                {{ $errors->first('id_card_nation') }}
                            @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card_types card_type2" style="{{ old('id_card_type') == 2 || $user->id_card_type == 2 ? '' : 'display:none;' }}">
                    <div class="password single"><span>户口照片</span>
                        <div class="upload chunk-upload">
                            <input type="hidden" class="img"  name="house_img" value="{{ old('house_img') ?: $user->house_img }}">
                            <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('house_img') ?: $user->house_img, asset('images/photo-default.jpg')) }}" />
                            <label class="file-box" for="file4">选择文件<input class="file-input img_upload" id="file4" type="file" /></label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="form-text text-info output"></p>
                            <span class="red">
                                @if($errors->has('house_img'))
                                    {{ $errors->first('house_img') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card_types card_type3" style="{{ old('id_card_type') == 3 || $user->id_card_type == 3 ? '' : 'display:none;' }}">
                    <div class="password single"><span>护照照片</span>
                        <div class="upload chunk-upload">
                            <input type="hidden" class="img"  name="passport_img" value="{{ old('passport_img') ?: $user->passport_img }}">
                            <img class="img_show" src="{{ \App\Model\File::getFileUrl(old('passport_img') ?: $user->passport_img, asset('images/photo-default.jpg')) }}" />
                            <label class="file-box" for="file5">选择文件<input class="file-input img_upload" id="file5" type="file" /></label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="form-text text-info output"></p>
                            <span class="red">
                            @if($errors->has('passport_img'))
                                {{ $errors->first('passport_img') }}
                            @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="login-submit"><input class="prev" type="button" onclick="location.href='{{ $prev }}'" value="上一步" /><input type="submit" value="下一步" /></div>
            </form>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::register._js')
    <script>
        !function ($) {
            $(function () {
                $('.img_upload').chunkUpload({
                    processUrl: '{{ route('register.process', ['key' => $key]) }}',
                    uploadUrl: '{{ route('register.uploading', ['key' => $key]) }}',
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
            });
        }(jQuery);
    </script>
@stop