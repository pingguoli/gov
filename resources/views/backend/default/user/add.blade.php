@extends('backend::layout')

@section('title', __('New Account'))

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('New Account') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('username')) has-error @endif">
                        <label class="control-label">{{ __('Account') }}</label>
                        <input class="form-control " name="username" type="text" placeholder="{{ __('Account') }}" value="{{ old('username') }}">
                        @if($errors->has('username'))
                            <span class="help-block">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                </div>
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
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label">{{ __('Username') }}</label>
                        <input class="form-control" name="name" type="text" placeholder="{{ __('Username') }}" value="{{ old('name') }}">
                        @if($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('id_card')) has-error @endif">
                        <label class="control-label">{{ __('ID Card') }}</label>
                        <input class="form-control" name="id_card" type="text" placeholder="{{ __('ID Card') }}" value="{{ old('id_card') }}">
                        @if($errors->has('id_card'))
                            <span class="help-block">{{ $errors->first('id_card') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                        <label class="control-label">{{ __('E-mail') }}</label>
                        <input class="form-control" name="email" type="text" placeholder="{{ __('E-mail') }}" value="{{ old('email') }}">
                        @if($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('mobile')) has-error @endif">
                        <label class="control-label">{{ __('Mobile') }}</label>
                        <input class="form-control" name="mobile" type="text" placeholder="{{ __('Mobile') }}" value="{{ old('mobile') }}">
                        @if($errors->has('mobile'))
                            <span class="help-block">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('img')) has-error @endif">
                        <label class="control-label">{{ __('Img') }}</label>
                        <input name="img" type="file">
                        @if($errors->has('img'))
                            <span class="help-block">{{ $errors->first('img') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('address')) has-error @endif">
                        <label class="control-label">{{ __('Address') }}</label>
                        <textarea class="form-control" name="address" rows="4" placeholder="{{ __('Address') }}">{{ old('address') }}</textarea>
                        @if($errors->has('address'))
                            <span class="help-block">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                        <label class="control-label">{{ __('Type') }}</label>
                        <select class="form-control" name="type">
                            <option value="">{{__('-- Please Selected --')}}</option>
                            <option value="1" @if(old('type') == 1) selected @endif>{{__('Player Account')}}</option>
                            <option value="2" @if(old('type') == 2) selected @endif>{{__('Referee Account')}}</option>
                            <option value="3" @if(old('type') == 3) selected @endif>{{__('Club Account')}}</option>
                        </select>
                        @if($errors->has('type'))
                            <span class="help-block">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('club_id')) has-error @endif">
                        <label class="control-label">{{ __('Club') }}</label>
                        <select class="form-control" name="club_id">
                            <option value="">{{__('-- Please Selected --')}}</option>
                            @if(!empty($clubs))
                                @foreach($clubs as $club)
                                    <option value="{{$club->id}}" @if(old('club_id') == $club->id) selected @endif>{{$club->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('club_id'))
                            <span class="help-block">{{ $errors->first('club_id') }}</span>
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