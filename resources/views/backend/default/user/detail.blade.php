@extends('backend::layout')

@section('title', '修改历史详情')

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
            <h4 class="text-black f-20">修改历史详情</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">当次修改前详情</th>
                        <th scope="col">下次修改前详情(即修改后)</th>
                        <th scope="col">最新详情</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="@if($afterHistory && $afterHistory->nickname != $history->nickname || $user->nickname != $history->nickname) text-danger @endif">
                        <th scope="row">{{ __('Nickname') }}</th>
                        <td>{{ $history->nickname }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->nickname }} @endif</td>
                        <td>{{ $user->nickname }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->name != $history->name || $user->name != $history->name) text-danger @endif">
                        <th scope="row">{{ __('Username') }}</th>
                        <td>{{ $history->name }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->name }} @endif</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->sex != $history->sex || $user->sex != $history->sex) text-danger @endif">
                        <th scope="row">{{ __('Sex') }}</th>
                        <td>{{ $history->getSex() }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->getSex() }} @endif</td>
                        <td>{{ $user->getSex() }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->id_card != $history->id_card || $user->id_card != $history->id_card) text-danger @endif">
                        <th scope="row">{{ __('ID Card') }}</th>
                        <td>{{ $history->id_card }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->id_card }} @endif</td>
                        <td>{{ $user->id_card }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->email != $history->email || $user->email != $history->email) text-danger @endif">
                        <th scope="row">{{ __('E-mail') }}</th>
                        <td>{{ $history->email }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->email }} @endif</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->mobile != $history->mobile || $user->mobile != $history->mobile) text-danger @endif">
                        <th scope="row">{{ __('Mobile') }}</th>
                        <td>{{ $history->mobile }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->mobile }} @endif</td>
                        <td>{{ $user->mobile }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->birthday != $history->birthday || $user->birthday != $history->birthday) text-danger @endif">
                        <th scope="row">{{ __('Birthday') }}</th>
                        <td>{{ $history->birthday }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->birthday }} @endif</td>
                        <td>{{ $user->birthday }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->img != $history->img || $user->img != $history->img) text-danger @endif">
                        <th scope="row">{{ __('Img') }}</th>
                        <td>
                            @if(\App\Model\File::hasFile($history->img))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($history->img) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($afterHistory && \App\Model\File::hasFile($afterHistory->img))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($afterHistory->img) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </td>
                        <td>
                            @if(\App\Model\File::hasFile($user->img))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($user->img) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->nationality != $history->nationality || $user->nationality != $history->nationality) text-danger @endif">
                        <th scope="row">{{ __('Nationality') }}</th>
                        <td>{{ $history->getNationality() }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->getNationality() }} @endif</td>
                        <td>{{ $user->getNationality() }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->address != $history->address || $user->address != $history->address) text-danger @endif">
                        <th scope="row">{{ __('Address') }}</th>
                        <td>{{ $history->address }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->address }} @endif</td>
                        <td>{{ $user->address }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->education != $history->education || $user->education != $history->education) text-danger @endif">
                        <th scope="row">{{ __('Education') }}</th>
                        <td>{{ $history->getEducation() }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->getEducation() }} @endif</td>
                        <td>{{ $user->getEducation() }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->type != $history->type || $user->type != $history->type) text-danger @endif">
                        <th scope="row">{{ __('Type') }}</th>
                        <td>{{ $history->getType() }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->getType() }} @endif</td>
                        <td>{{ $user->getType() }}</td>
                    </tr>
                    <tr class="@if($afterHistory && $afterHistory->id_card_type != $history->id_card_type || $user->id_card_type != $history->id_card_type) text-danger @endif">
                        <th scope="row">证件类型</th>
                        <td>{{ $history->getIdCardType() }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->getIdCardType() }} @endif</td>
                        <td>{{ $user->getIdCardType() }}</td>
                    </tr>
{{--                    @if($history->id_card_type == 1)--}}
                        <tr class="@if($afterHistory && $afterHistory->id_card_face != $history->id_card_face || $user->id_card_face != $history->id_card_face) text-danger @endif">
                            <th scope="row">身份证头像面</th>
                            <td>
                                @if(\App\Model\File::hasFile($history->id_card_face))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($history->id_card_face) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($afterHistory && \App\Model\File::hasFile($afterHistory->id_card_face))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($afterHistory->id_card_face) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if(\App\Model\File::hasFile($user->id_card_face))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->id_card_face) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr class="@if($afterHistory && $afterHistory->id_card_nation != $history->id_card_nation || $user->id_card_nation != $history->id_card_nation) text-danger @endif">
                            <th scope="row">身份证国徽面</th>
                            <td>
                                @if(\App\Model\File::hasFile($history->id_card_nation))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($history->id_card_nation) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($afterHistory && \App\Model\File::hasFile($afterHistory->id_card_nation))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($afterHistory->id_card_nation) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if(\App\Model\File::hasFile($user->id_card_nation))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->id_card_nation) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
{{--                    @elseif($history->id_card_type == 2)--}}
                        <tr class="@if($afterHistory && $afterHistory->house_img != $history->house_img || $user->house_img != $history->house_img) text-danger @endif">
                            <th scope="row">户口照片</th>
                            <td>
                                @if(\App\Model\File::hasFile($history->house_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($history->house_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($afterHistory && \App\Model\File::hasFile($afterHistory->house_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($afterHistory->house_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if(\App\Model\File::hasFile($user->house_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->house_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
{{--                    @elseif($history->id_card_type == 3)--}}
                        <tr class="@if($afterHistory && $afterHistory->passport_img != $history->passport_img || $user->passport_img != $history->passport_img) text-danger @endif">
                            <th scope="row">护照照片</th>
                            <td>
                                @if(\App\Model\File::hasFile($history->passport_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($history->passport_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($afterHistory && \App\Model\File::hasFile($afterHistory->passport_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($afterHistory->passport_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if(\App\Model\File::hasFile($user->passport_img))
                                    <div class="profile_pic">
                                        <img src="{{ \App\Model\File::getFileUrl($user->passport_img) }}" class="img-circle profile_img">
                                    </div>
                                @endif
                            </td>
                        </tr>
                    {{--@endif--}}
                    <tr>
                        <th scope="row">修改时间</th>
                        <td>{{ $history->history_time }}</td>
                        <td>@if($afterHistory) {{ $afterHistory->history_time }} @endif</td>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">修改人</th>
                        <td>@if($history->admin){{ $history->admin->nickname ?: $history->admin->username }}@endif</td>
                        <td>@if($afterHistory && $afterHistory->admin) {{ $afterHistory->admin->nickname ?: $afterHistory->admin->username }} @endif</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop