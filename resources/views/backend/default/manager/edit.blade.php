@extends('backend::layout')

@section('title', __('Edit Manager'))

@section('content')
    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('Edit Manager') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('username')) has-error @endif">
                        <label class="control-label">{{ __('Account') }}</label>
                        <div>{{ old('username')?: $user->username }}</div>
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
                <div class="col-lg-4">
                    <div class="form-group @if($errors->has('type')) has-error @endif">
                        <label class="control-label">{{ __('Type') }}</label>
                        <div>
                            {{ $user->getType() }}
                        </div>
                    </div>
                </div>

                @if($user->type == \App\Model\Admin::TYPE_PROJECT)
                <div id="project" class="col-lg-4">
                    <div class="form-group @if($errors->has('project_id')) has-error @endif">
                        <label class="control-label">项目</label>
                        <select class="form-control" name="project_id">
                            <option value="">{{ __('-- Please Selected --') }}</option>
                            @if(!empty($projects))
                                @foreach($projects as $obj)
                                    <option value="{{ $obj->id }}" @if(old('project_id') == $obj->id || old('project_id') === null && $user->project_id == $obj->id) selected @endif>{{ $obj->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('project_id'))
                            <span class="help-block">{{ $errors->first('project_id') }}</span>
                        @endif
                    </div>
                </div>
                @endif

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Role') }}</label>
                        @if(!empty($roles))
                            @foreach($roles as $role)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="roles[]" @if(is_array(old('roles')) && in_array($role->id, old('roles')) || !is_array(old('roles')) && in_array($role->id, $user->roleIds())) checked @endif value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        @endif
                        @if($errors->has('roles'))
                            <span class="help-block text-danger">{{ $errors->first('roles') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label">{{ __('Status') }}</label>
                        <div class="radio">
                            <label>
                                <input type="radio" value="1" @if(old('status') == 1 || old('status') === null && $user->status == 1) checked @endif name="status">
                                {{ __('Open') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" value="0" @if((old('status') !== null && old('status') == 0) || old('status') === null && $user->status == 0) checked @endif name="status">
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