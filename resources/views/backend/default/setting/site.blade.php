@extends('backend::layout')

@section('title', __('Site setting'))

@section('content')
    <form method="post">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-lg-4">
                    <h3 class="box-title">{{ __('Site setting') }}</h3>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad-10">
                <ul class="nav nav-tabs" role="tablist" style="display: flex;">
                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#base" role="tab" aria-selected="true"><span class="hidden-xs-down">{{ __('Base Setting') }}</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#seo" role="tab" aria-selected="false"><span class="hidden-xs-down">{{ __('SEO Setting') }}</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#other" role="tab" aria-selected="false"><span class="hidden-xs-down">{{ __('Other Setting') }}</span></a> </li>
                </ul>
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active show" id="base" role="tabpanel">
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('base:name')) has-error @endif">
                                <label class="control-label">{{ __('Site Title') }}</label>
                                <input class="form-control " name="base:name" type="text" placeholder="{{ __('Site Title') }}" value="{{ old('base:name') ?: (old('base:name') === null && array_key_exists('base:name', $setting) ? $setting['base:name'] : '') }}">
                                @if($errors->has('base:name'))
                                    <span class="help-block">{{ $errors->first('base:name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('base:icp')) has-error @endif">
                                <label class="control-label">{{ __('ICP') }}</label>
                                <input class="form-control " name="base:icp" type="text" placeholder="{{ __('ICP') }}" value="{{ old('base:icp') ?: (old('base:icp') === null && array_key_exists('base:icp', $setting) ? $setting['base:icp'] : '') }}">
                                @if($errors->has('base:icp'))
                                    <span class="help-block">{{ $errors->first('base:icp') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('base:copyright')) has-error @endif">
                                <label class="control-label">{{ __('Copyright') }}</label>
                                <input class="form-control " name="base:copyright" type="text" placeholder="{{ __('Copyright') }}" value="{{ old('base:copyright') ?: (old('base:copyright') === null && array_key_exists('base:copyright', $setting) ? $setting['base:copyright'] : '') }}">
                                @if($errors->has('base:copyright'))
                                    <span class="help-block">{{ $errors->first('base:copyright') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('base:address')) has-error @endif">
                                <label class="control-label">{{ __('Address') }}</label>
                                <input class="form-control " name="base:address" type="text" placeholder="{{ __('Address') }}" value="{{ old('base:address') ?: (old('base:address') === null && array_key_exists('base:address', $setting) ? $setting['base:address'] : '') }}">
                                @if($errors->has('base:address'))
                                    <span class="help-block">{{ $errors->first('base:address') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('base:telephone')) has-error @endif">
                                <label class="control-label">{{ __('Telephone') }}</label>
                                <input class="form-control " name="base:telephone" type="text" placeholder="{{ __('Telephone') }}" value="{{ old('base:telephone') ?: (old('base:telephone') === null && array_key_exists('base:telephone', $setting) ? $setting['base:telephone'] : '') }}">
                                @if($errors->has('base:telephone'))
                                    <span class="help-block">{{ $errors->first('base:telephone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('base:email')) has-error @endif">
                                <label class="control-label">{{ __('E-mail') }}</label>
                                <input class="form-control " name="base:email" type="text" placeholder="{{ __('E-mail') }}" value="{{ old('base:email') ?: (old('base:email') === null && array_key_exists('base:email', $setting) ? $setting['base:email'] : '') }}">
                                @if($errors->has('base:email'))
                                    <span class="help-block">{{ $errors->first('base:email') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="seo" role="tabpanel">
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('seo:title')) has-error @endif">
                                <label class="control-label">{{ __('SEO Title') }}</label>
                                <input class="form-control " name="seo:title" type="text" placeholder="{{ __('SEO Title') }}" value="{{ old('seo:title') ?: (old('seo:title') === null && array_key_exists('seo:title', $setting) ? $setting['seo:title'] : '') }}">
                                @if($errors->has('seo:title'))
                                    <span class="help-block">{{ $errors->first('seo:title') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('seo:keywords')) has-error @endif">
                                <label class="control-label">{{ __('SEO Keywords') }}</label>
                                <textarea class="form-control" name="seo:keywords" rows="3" placeholder="{{ __('SEO Keywords') }}">{{ old('seo:keywords') ?: (old('seo:keywords') === null && array_key_exists('seo:keywords', $setting) ? $setting['seo:keywords'] : '') }}</textarea>
                                @if($errors->has('seo:keywords'))
                                    <span class="help-block">{{ $errors->first('seo:keywords') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('seo:description')) has-error @endif">
                                <label class="control-label">{{ __('SEO Description') }}</label>
                                <textarea class="form-control" name="seo:description" rows="3" placeholder="{{ __('SEO Description') }}">{{ old('seo:description') ?: (old('seo:description') === null && array_key_exists('seo:description', $setting) ? $setting['seo:description'] : '') }}</textarea>
                                @if($errors->has('seo:description'))
                                    <span class="help-block">{{ $errors->first('seo:description') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="other" role="tabpanel">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="control-label">{{ __('Captcha') }}</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="1" @if(old('other:captcha') == 1 || old('other:captcha') === null && array_key_exists('other:captcha', $setting) && $setting['other:captcha'] == 1) checked @endif name="other:captcha">
                                        {{ __('Open') }}
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" value="0" @if(old('other:captcha') !== null && old('other:captcha') == 0  || old('other:captcha') === null && array_key_exists('other:captcha', $setting) && $setting['other:captcha'] == 0) checked @endif name="other:captcha">
                                        {{ __('Close') }}
                                    </label>
                                </div>
                                @if($errors->has('other:captcha'))
                                    <span class="help-block text-danger">{{ $errors->first('other:captcha') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('other:paginate')) has-error @endif">
                                <label class="control-label">{{ __('Page number') }}</label>
                                <input class="form-control " name="other:paginate" type="text" placeholder="{{ __('Page number') }}" value="{{ old('other:paginate') ?: (old('other:paginate') === null && array_key_exists('other:paginate', $setting) ? $setting['other:paginate'] : '') }}">
                                @if($errors->has('other:paginate'))
                                    <span class="help-block">{{ $errors->first('other:paginate') }}</span>
                                @endif
                            </div>
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
@stop