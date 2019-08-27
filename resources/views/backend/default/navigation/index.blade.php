@extends('backend::layout')

@section('title', '导航列表')

@section('content')
    <div class="card border-no">
        <div class="card-body">
            @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/add'))
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="{{ route('admin.navigation.add') }}" class="btn btn-primary btn-sm">新增导航</a>
                    </p>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-outline-primary @if($positionCode == \App\Model\Navigation::POSITION_DEFAULT) active @endif" href="{{ route('admin.navigation.index') }}">默认导航</a>
                        <a class="btn btn-outline-primary @if($positionCode == \App\Model\Navigation::POSITION_TOP) active @endif" href="{{ route('admin.navigation.index', ['position' => \App\Model\Navigation::POSITION_TOP_FLAG]) }}">顶部导航</a>
                        <a class="btn btn-outline-primary @if($positionCode == \App\Model\Navigation::POSITION_BOTTOM) active @endif" href="{{ route('admin.navigation.index', ['position' => \App\Model\Navigation::POSITION_BOTTOM_FLAG]) }}">底部导航</a>
                    </div>
                </div>
            </div>
            <h4 class="text-black f-20">导航列表</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">名称</th>
                        <th scope="col">类型</th>
                        <th scope="col">链接/分类/单页</th>
                        <th scope="col">是否新建标签</th>
                        <th scope="col">是否显示</th>
                        <th scope="col">排序</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody class="tree-list">
                    @if(isset($list))
                        @foreach($list as $first)
                            <tr class="first-item">
                                <th scope="row" class="open-son" data-id="{{ $first['id'] }}">@if(!empty($first['children']) && is_array($first['children']))<i class="tree-btn fa fa-caret-right"></i> @endif{{ $first['name'] }}</th>
                                <td>
                                {{ \App\Model\Navigation::getType($first['type']) }}
                                </td>
                                <td>{{ \App\Model\Navigation::showTypeVal($first) }}</td>
                                <td>{{ $first['target'] ? __('Yes') : __('No') }}</td>
                                <td>{{ $first['is_show'] ? __('Yes') : __('No') }}</td>
                                <td>{{ $first['sort'] }}</td>
                                <td>{{ $first['created_at'] }}</td>
                                <td>{{ $first['updated_at'] }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/view'))
                                        <a href="{{ route('admin.navigation.view', ['id' => $first['id']]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/edit'))
                                        <a href="{{ route('admin.navigation.edit', ['id' => $first['id']]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/delete'))
                                        <a href="{{ route('admin.navigation.delete', ['id' => $first['id']]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @if(!empty($first['children']) && is_array($first['children']))
                                @foreach($first['children'] as $second)
                                    <tr class="tree-item second-item son-item-{{ $first['id'] }}" style="display: none;">
                                        <th scope="row" class="open-last" data-id="{{ $second['id'] }}">@if(!empty($second['children']) && is_array($second['children']))<i class="tree-btn fa fa-caret-right"></i>@endif &nbsp;&nbsp;&nbsp;&nbsp;{{ $second['name'] }}</th>
                                        <td>
                                            {{ \App\Model\Navigation::getType($second['type']) }}
                                        </td>
                                        <td></td>
                                        <td>{{ $second['target'] ? __('Yes') : __('No') }}</td>
                                        <td>{{ $second['is_show'] ? __('Yes') : __('No') }}</td>
                                        <td>{{ $second['sort'] }}</td>
                                        <td>{{ $second['created_at'] }}</td>
                                        <td>{{ $second['updated_at'] }}</td>
                                        <td>
                                            @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/view'))
                                                <a href="{{ route('admin.navigation.view', ['id' => $second['id']]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                            @endif
                                            @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/edit'))
                                                <a href="{{ route('admin.navigation.edit', ['id' => $second['id']]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                            @endif
                                            @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/delete'))
                                                <a href="{{ route('admin.navigation.delete', ['id' => $second['id']]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @if(!empty($second['children']) && is_array($second['children']))
                                        @foreach($second['children'] as $third)
                                            <tr class="tree-item third-item son-item-{{ $first['id'] }} son-item-{{ $second['id'] }}" style="display: none;">
                                                <th scope="row" data-id="{{ $third['id'] }}"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $third['name'] }}</th>
                                                <td>
                                                    {{ \App\Model\Navigation::getType($third['type']) }}
                                                </td>
                                                <td></td>
                                                <td>{{ $third['target'] ? __('Yes') : __('No') }}</td>
                                                <td>{{ $third['is_show'] ? __('Yes') : __('No') }}</td>
                                                <td>{{ $third['sort'] }}</td>
                                                <td>{{ $third['created_at'] }}</td>
                                                <td>{{ $third['updated_at'] }}</td>
                                                <td>
                                                    @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/view'))
                                                        <a href="{{ route('admin.navigation.view', ['id' => $third['id']]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/edit'))
                                                        <a href="{{ route('admin.navigation.edit', ['id' => $third['id']]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                                    @endif
                                                    @if(!empty($currentAdmin) && $currentAdmin->allow('navigation/delete'))
                                                        <a href="{{ route('admin.navigation.delete', ['id' => $third['id']]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        (function () {
            $(function () {
                $('#open-all').on('click', function () {
                    var hasOpen = $(this).hasClass('open-all-item');
                    if (hasOpen) {
                        /* 关闭 */
                        $('.tree-list .tree-item').hide();
                        $('.tree-list .tree-btn').removeClass('fa-caret-down').addClass('fa-caret-right');
                        $(this).removeClass('open-all-item');
                        $('.tree-list .open-son').removeClass('open-item');
                    } else {
                        /* 打开 */
                        $('.tree-list .tree-item').show();
                        $('.tree-list .tree-btn').removeClass('fa-caret-right').addClass('fa-caret-down');
                        $(this).addClass('open-all-item');
                        $('.tree-list .open-son').addClass('open-item');
                    }
                });

                $('.tree-list .open-son').on('click', function () {
                    var hasOpen = $(this).hasClass('open-item');
                    var id = $(this).data('id');
                    if (hasOpen) {
                        /* 关闭 */
                        $('.tree-list .son-item-' + id).hide();
                        $(this).children('.tree-btn').removeClass('fa-caret-down').addClass('fa-caret-right');
                        $(this).removeClass('open-item');
                        $('.tree-list .son-item-' + id + ' .open-last .tree-btn').removeClass('fa-caret-down').addClass('fa-caret-right');
                        $('.tree-list .son-item-' + id + ' .open-last').removeClass('open-item');
                    } else {
                        /* 打开 */
                        $('.tree-list .second-item.son-item-' + id).show();
                        $(this).children('.tree-btn').removeClass('fa-caret-right').addClass('fa-caret-down');
                        $(this).addClass('open-item');
                    }
                });

                $('.tree-list .open-last').on('click', function () {
                    var hasOpen = $(this).hasClass('open-item');
                    var id = $(this).data('id');
                    if (hasOpen) {
                        /* 关闭 */
                        $('.tree-list .son-item-' + id).hide();
                        $(this).children('.tree-btn').removeClass('fa-caret-down').addClass('fa-caret-right');
                        $(this).removeClass('open-item');
                    } else {
                        /* 打开 */
                        $('.tree-list .son-item-' + id).show();
                        $(this).children('.tree-btn').removeClass('fa-caret-right').addClass('fa-caret-down');
                        $(this).addClass('open-item');
                    }
                });
            });
        })(jQuery);
    </script>
@stop