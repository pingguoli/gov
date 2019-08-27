@extends('backend::layout')

@section('title', __('Menu List'))

@section('content')
    <div class="card border-no">
        <div class="card-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        @if(!empty($currentAdmin) && $currentAdmin->allow('menu/add'))
                            <a href="{{ route('admin.menu.add') }}" class="btn btn-primary btn-sm">{{ __('New Menu') }}</a>
                            &nbsp;&nbsp;&nbsp;
                        @endif
                        <button class="btn btn-default btn-sm" id="open-all">{{ __('Expand or fold all') }}</button>
                    </p>
                </div>
            </div>
            <h4 class="text-black f-20">{{__('Menu List')}}</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Icon') }}</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Controller / method') }}</th>
                        <th scope="col">{{ __('URL') }}</th>
                        <th scope="col">{{ __('Is displayed as a menu') }}</th>
                        <th scope="col">{{ __('Sort') }}</th>
                        <th scope="col">{{ __('Create Time') }}</th>
                        <th scope="col">{{ __('Update Time') }}</th>
                        <th scope="col">{{ __('Options') }}</th>
                    </tr>
                    </thead>
                    <tbody class="tree-list">
                    @if(!empty($menu))
                        @foreach($menu as $first)
                            <tr class="first-item">
                                <th scope="row">{{ $first['id'] }}</th>
                                <td>
                                    @if(!empty($first['icon']))
                                        <i class="fa {{ $first['icon'] }}"></i>
                                    @endif
                                </td>
                                <td class="open-son" data-id="{{ $first['id'] }}">@if(!empty($first['children']) && is_array($first['children']))<i class="tree-btn fa fa-caret-right"></i> @endif{{ $first['title'] }}</td>
                                <td>{{ $first['name'] }}</td>
                                <td>{{ $first['url'] }}</td>
                                <td>{{ $first['is_show'] ? __('Yes') : __('No') }}</td>
                                <td>{{ $first['sort'] }}</td>
                                <td>{{ $first['created_at'] }}</td>
                                <td>{{ $first['updated_at'] }}</td>
                                <td>
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('menu/view'))
                                        <a href="{{ route('admin.menu.view', ['id' => $first['id']]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('menu/edit'))
                                        <a href="{{ route('admin.menu.edit', ['id' => $first['id']]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(!empty($currentAdmin) && $currentAdmin->allow('menu/delete'))
                                        <a href="{{ route('admin.menu.delete', ['id' => $first['id']]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @if(!empty($first['children']) && is_array($first['children']))
                                @foreach($first['children'] as $second)
                                    <tr class="tree-item second-item son-item-{{ $first['id'] }}" style="display: none;">
                                        <th scope="row">{{ $second['id'] }}</th>
                                        <td>
                                            @if(!empty($second['icon']))
                                                <i class="fa {{ $second['icon'] }}"></i>
                                            @endif
                                        </td>
                                        <td class="open-last" data-id="{{ $second['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;@if(!empty($second['children']) && is_array($second['children']))<i class="tree-btn fa fa-caret-right"></i> @endif{{ $second['title'] }}</td>
                                        <td>{{ $second['name'] }}</td>
                                        <td>{{ $second['url'] }}</td>
                                        <td>{{ $second['is_show'] ? __('Yes') : __('No') }}</td>
                                        <td>{{ $second['sort'] }}</td>
                                        <td>{{ $second['created_at'] }}</td>
                                        <td>{{ $second['updated_at'] }}</td>
                                        <td>
                                            @if(!empty($currentAdmin) && $currentAdmin->allow('menu/view'))
                                                <a href="{{ route('admin.menu.view', ['id' => $second['id']]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                            @endif
                                            @if(!empty($currentAdmin) && $currentAdmin->allow('menu/edit'))
                                                <a href="{{ route('admin.menu.edit', ['id' => $second['id']]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                            @endif
                                            @if(!empty($currentAdmin) && $currentAdmin->allow('menu/delete'))
                                                <a href="{{ route('admin.menu.delete', ['id' => $second['id']]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @if(!empty($second['children']) && is_array($second['children']))
                                        @foreach($second['children'] as $third)
                                            <tr class="tree-item third-item son-item-{{ $first['id'] }} son-item-{{ $second['id'] }}" style="display: none;">
                                                <th scope="row">{{ $third['id'] }}</th>
                                                <td>
                                                    @if(!empty($third['icon']))
                                                        <i class="fa {{ $third['icon'] }}"></i>
                                                    @endif
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $third['title'] }}</td>
                                                <td>{{ $third['name'] }}</td>
                                                <td>{{ $third['url'] }}</td>
                                                <td>{{ $third['is_show'] ? __('Yes') : __('No') }}</td>
                                                <td>{{ $third['sort'] }}</td>
                                                <td>{{ $third['created_at'] }}</td>
                                                <td>{{ $third['updated_at'] }}</td>
                                                <td>
                                                    @if(!empty($currentAdmin) && $currentAdmin->allow('menu/view'))
                                                        <a href="{{ route('admin.menu.view', ['id' => $third['id']]) }}" class="text-primary" title="{{ __('View') }}">&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if(!empty($currentAdmin) && $currentAdmin->allow('menu/edit'))
                                                        <a href="{{ route('admin.menu.edit', ['id' => $third['id']]) }}" class="text-info" title="{{ __('Edit') }}">&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                                    @endif
                                                    @if(!empty($currentAdmin) && $currentAdmin->allow('menu/delete'))
                                                        <a href="{{ route('admin.menu.delete', ['id' => $third['id']]) }}" class="text-danger confirm-delete" title="{{ __('Delete') }}">&nbsp;&nbsp;<i class="fa fa-trash-o"></i></a>
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