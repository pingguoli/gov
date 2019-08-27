@extends('frontend::layouts.default')

@section('title', '个人中心')

@section('style')
    @include('frontend::member._css')
@stop

@section('content')
    <div class="login register">
        <div class="row">
            <div class="col col-3">
                @include('frontend::project._left', ['activeProject' => 'team'])
            </div>
            <div class="col col-9">
                <div class="row">
                    <div class="col col-12">
                        <div class="card">
                            @include('frontend::team._common')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="rightZD">
                        <form action="" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div>
                                <label for="name">战队名称</label>
                                <div class="inlines">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="">
                                    @if($errors->has('name'))
                                        <span class="red">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label>战队LOGO</label>
                                <div class="upload chunk-upload">
                                    <input type="hidden" class="img"  name="img" value="">
                                    <img class="img_show" src="" />
                                    <label class="file-box" for="file1">选择文件<input class="file-input img_upload" id="file1" type="file" /></label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-warning progressbar" role="progressbar" style="width: 0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="form-text text-info output"></p>
                                    @if($errors->has('logo'))
                                        {{ $errors->first('logo') }}
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="">创建</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @include('frontend::member._js')
@stop