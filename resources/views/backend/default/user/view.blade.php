@extends('backend::layout')

@section('title', '查看运动员')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="javascript:history.back(-1);" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
                    </p>
                </div>
            </div>
            <h4 class="text-black f-20">{{__('View Account')}}</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">{{ __('Nickname') }}</th>
                        <td>{{ $user->nickname }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Username') }}</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Sex') }}</th>
                        <td>{{ $user->getSex() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('ID Card') }}</th>
                        <td>{{ $user->id_card }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('E-mail') }}</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Mobile') }}</th>
                        <td>{{ $user->mobile }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Birthday') }}</th>
                        <td>{{ $user->birthday }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Img') }}</th>
                        <td>
                            @if(\App\Model\File::hasFile($user->img))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($user->img) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Nationality') }}</th>
                        <td>{{ $user->getNationality() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Address') }}</th>
                        <td>{{ $user->address }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Education') }}</th>
                        <td>{{ $user->getEducation() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Type') }}</th>
                        <td>{{ $user->getType() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">证件类型</th>
                        <td>{{ $user->getIdCardType() }}</td>
                    </tr>
                    @if($user->id_card_type == 1)
                        <tr>
                            <th scope="row">身份证头像面</th>
                            <td>
                                @if(\App\Model\File::hasFile($user->id_card_face))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->id_card_face) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">身份证国徽面</th>
                            <td>
                                @if(\App\Model\File::hasFile($user->id_card_nation))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->id_card_nation) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @elseif($user->id_card_type == 2)
                        <tr>
                            <th scope="row">户口照片</th>
                            <td>
                                @if(\App\Model\File::hasFile($user->house_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->house_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @elseif($user->id_card_type == 3)
                        <tr>
                            <th scope="row">护照照片</th>
                            <td>
                                @if(\App\Model\File::hasFile($user->passport_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->passport_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th scope="row">是否注册完成</th>
                        <td>{{ $user->isComplete() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">注册时间</th>
                        <td>{{ $user->register_time }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Last login IP') }}</th>
                        <td>{{ $user->last_login_ip }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Last login time') }}</th>
                        <td>{{ $user->last_login_time }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop