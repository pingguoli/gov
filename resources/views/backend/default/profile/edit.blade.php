@extends('backend::layout')

@section('title', '编辑个人中心')

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">编辑个人中心</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
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
                    <div class="form-group @if($errors->has('real_name')) has-error @endif">
                        <label class="control-label">{{ __('Real name') }}</label>
                        <input class="form-control" name="real_name" type="text" placeholder="{{ __('Real name') }}" value="{{ old('real_name') ?: $user->real_name }}">
                        @if($errors->has('real_name'))
                            <span class="help-block">{{ $errors->first('real_name') }}</span>
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
                    <div class="form-group @if($errors->has('img')) has-error @endif">
                        <label class="control-label">{{ __('Img') }}</label>
                        <input type="file" name="img" class="dropify" />
                        @if($errors->has('img'))
                            <span class="help-block">{{ $errors->first('img') }}</span>
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