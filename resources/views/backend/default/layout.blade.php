<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ config('site.base.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- v4.1.3 -->
    <link rel="stylesheet" href="{{ asset('0pole/bootstrap/css/bootstrap.min.css')}}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('0pole/img/favicon-16x16.png')}}">

    <!-- Google Font -->
    <link href="{{asset('0pole/css/google/font.css')}}" rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('0pole/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('0pole/css/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('0pole/css/et-line-font/et-line-font.css')}}">
    <link rel="stylesheet" href="{{ asset('0pole/css/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('0pole/css/simple-lineicon/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('0pole/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{ asset('0pole/css/sweetalert.css')}}">

    <!-- dropify -->
    <link rel="stylesheet" href="{{ asset('0pole/plugins/dropify/dropify.min.css') }}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('0pole/plugins/summernote/summernote-bs4.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('0pole/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('0pole/js/respond.min.js') }}"></script>
    <![endif]-->

    @section('style')
    @show
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper boxed-wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="{{ route('admin.index') }}" class="logo blue-bg">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{{ asset('0pole/img/logo-small.png') }}" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="{{ asset('0pole/img/logo.png') }}" alt=""></span> </a>
        <!-- Header Navbar -->
        @section('nav')
        <nav class="navbar blue-bg navbar-static-top">
            <!-- Sidebar toggle button-->
            <ul class="nav navbar-nav pull-left">
                <li><a class="sidebar-toggle" data-toggle="push-menu" href="#"></a> </li>
            </ul>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account  -->
                    <li class="dropdown user user-menu p-ph-res">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="@if(!empty($currentAdmin)) {{ \App\Model\File::getFileUrl($currentAdmin->img, asset('0pole/img/img1.jpg')) }} @else {{ asset('0pole/img/img1.jpg') }} @endif" class="user-image" alt="">
                            <span class="hidden-xs">
                                @if(!empty($currentAdmin->nickname))
                                    {{ $currentAdmin->nickname }}
                                @elseif(!empty($currentAdmin->username))
                                    {{ $currentAdmin->username }}
                                @else
                                    {{ __('Anonymous') }}
                                @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <div class="pull-left user-img">
                                    <img src="@if(!empty($currentAdmin)) {{ \App\Model\File::getFileUrl($currentAdmin->img, asset('0pole/img/img1.jpg')) }} @else {{ asset('0pole/img/img1.jpg') }} @endif" class="img-responsive img-circle" alt="">
                                </div>
                                <p class="text-left">
                                    @if(!empty($currentAdmin->nickname))
                                        {{ $currentAdmin->nickname }}
                                    @elseif(!empty($currentAdmin->username))
                                        {{ $currentAdmin->username }}
                                    @else
                                        {{ __('Anonymous') }}
                                    @endif
                                    <small></small>
                                </p>
                            </li>
                            <li><a href="{{ route('admin.profile') }}"><i class="icon-profile-male"></i>{{ __('Profile') }}</a></li>
                            <li><a href="{{ route('admin.profile.password') }}"><i class="icon-lock"></i>更改密码</a></li>
                            <li><a href="{{ route('admin.logout') }}"><i class="fa fa-power-off"></i>{{ __('Logout') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        @show
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="image text-center">
                    <img src="@if(!empty($currentAdmin)) {{ \App\Model\File::getFileUrl($currentAdmin->img, asset('0pole/img/img1.jpg')) }} @else {{ asset('0pole/img/img1.jpg') }} @endif" class="img-circle" alt="">
                </div>
                <div class="info">
                    <p>
                        @if(!empty($currentAdmin->nickname))
                            {{ $currentAdmin->nickname }}
                        @elseif(!empty($currentAdmin->username))
                            {{ $currentAdmin->username }}
                        @else
                            {{ __('Anonymous') }}
                        @endif
                    </p>
                    <a href="#"><i class="fa fa-envelope"></i></a>
                    <a href="{{ route('admin.logout') }}"><i class="fa fa-power-off"></i></a>
                </div>
            </div>

            <!-- sidebar menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li>
                    <a href="{{route('admin.index')}}">
                        <i class="fa fa-home"></i>
                        <span>{{__('Home')}}</span>
                    </a>
                </li>
                @section('menu')
                    @if(!empty($menusTree))
                        @foreach($menusTree as $item)
                            @if(!empty($item['children']) && is_array($item['children']))
                                <li class="treeview @if(!empty($item['active'])) active @endif">
                                    <a href="#">
                                        <i class="fa @if(!empty($item['icon'])) {{ $item['icon'] }} @endif"></i>
                                        <span>@if(!empty($item['title'])) {{ $item['title'] }} @endif</span>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    </a>
                                    <ul class="treeview-menu">
                                        @foreach($item['children'] as $son)
                                            @if(!empty($son['children']) && is_array($son['children']))
                                                <li  class="treeview @if(!empty($son['active'])) active @endif">
                                                    <a href="#">
                                                        <i class="fa fa-angle-right"></i>
                                                        @if(!empty($son['title'])) {{ $son['title'] }} @endif
                                                        <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                                                    </a>
                                                    <ul class="treeview-menu">
                                                        @foreach($son['children'] as $third)
                                                            <li @if(!empty($third['active'])) class="active" @endif>
                                                                <a href="@if(!empty($third['name'])) {{ url(config('admin.prefix') . '/' . $third['name']) }} @elseif(!empty($third['url'])) {{ $third['url'] }} @endif">
                                                                    <i class="fa fa-angle-right"></i>
                                                                    @if(!empty($third['title'])) {{ $third['title'] }} @endif
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li @if(!empty($son['active'])) class="active" @endif>
                                                    <a href="@if(!empty($son['name'])) {{ url(config('admin.prefix') . '/' . $son['name']) }} @elseif(!empty($son['url'])) {{ $son['url'] }} @endif">
                                                        <i class="fa fa-angle-right"></i>
                                                        @if(!empty($son['title'])) {{ $son['title'] }} @endif
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li @if(!empty($son['active'])) class="active" @endif>
                                    <a href="@if(!empty($item['name'])) {{ url(config('admin.prefix') . '/' . $item['name']) }} @elseif(!empty($item['url'])) {{ $item['url'] }} @endif" @if(!empty($item['active'])) class="active" @endif>
                                        <i class="fa @if(!empty($item['icon'])) {{ $item['icon'] }} @endif"></i>
                                        <span>@if(!empty($item['title'])) {{ $item['title'] }} @endif</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @show
            </ul>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header sty-one">
            @section('breadcrumb')
                <h1>
                    @if(!empty($currentMenu))
                        <i class="fa @if(!empty($currentMenu->icon)) {{ $currentMenu->icon }} @endif "></i>
                        {{ $currentMenu->title }}
                    @elseif(!empty($title))
                        {{ $title }}
                    @endif
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.index') }}">{{__('Home')}}</a></li>
                    @if(!empty($breadcrumb))
                        @foreach($breadcrumb as $menu)
                            <li>
                                <i class="fa fa-angle-right"></i>
                                @if(!empty($menu->name))
                                    <a href="{{ url(config('admin.prefix') . '/' . $menu->name) }}">
                                        @if(!empty($menu->title)) {{ $menu->title }} @endif
                                    </a>
                                @else
                                    @if(!empty($menu->title)) {{ $menu->title }} @endif
                                @endif
                            </li>
                        @endforeach
                    @endif
                    @if(!empty($currentMenu))
                        <li>
                            <i class="fa fa-angle-right"></i>
                            @if(!empty($currentMenu->title)) {{ $currentMenu->title }} @endif
                        </li>
                    @endif
                </ol>
            @show
        </div>

        <!-- Main content -->
        <div class="content">
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
            @section('content')
            @show
        </div>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        @section('footer')
            <div class="pull-right hidden-xs">Version 1.0</div>
            Copyright © 2018 - {{ date('Y') }} <a href="{{config('site.link')}}">{{config('site.author')}}</a> All rights reserved.
        @show
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab"></div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

@section('overlay')
@show

<!-- jQuery 3 -->
<script src="{{ asset('0pole/js/jquery.min.js')}}"></script>
<script src="{{ asset('0pole/plugins/popper/popper.min.js') }}"></script>

<!-- v4.0.0-alpha.6 -->
<script src="{{ asset('0pole/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- template -->
<script src="{{ asset('0pole/js/bizadmin.js')}}"></script>

<!-- dropify -->
<script src="{{ asset('0pole/plugins/dropify/dropify.min.js') }}"></script>

<!-- summernote -->
<script src="{{ asset('0pole/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('0pole/plugins/summernote/lang/summernote-zh-CN.js') }}"></script>

<script src="{{ asset('0pole/js/sweetalert.min.js')}}"></script>
<script src="{{ asset('js/spark-md5.min.js') }}"></script>
<script src="{{ asset('js/jquery.chunkupload.js') }}"></script>
<script src="{{ asset('js/jquery.showerrormsg.js') }}"></script>

<script type="text/javascript">
    !function () {
        $(function () {
            // 图片拖拽
            $('.dropify').dropify({
                messages: {
                    default: '将文件拖放到此处或点击',
                    replace: '拖放或单击可替换',
                    remove:  '删除',
                    error:   '哎呀，出现了一些错误'
                }
            });

            // 文本编辑器
            $('.summernote-editor').summernote({
                height: 250,
                minHeight: null,
                maxHeight: null,
                lang: 'zh-CN',
                focus: false,
                callbacks: {
                    // 上传图片
                    onImageUpload: function (files) {
                        var $that = $(this);
                        var form = new FormData();
                        form.append('file', files[0]);
                        form.append('type', 'image');
                        form.append('_token', '{{ csrf_token() }}');
                        $.ajax({
                            url: '{{ route('admin.upload') }}',
                            type: 'POST',
                            data: form,
                            dataType: 'json',
                            async: false,
                            processData: false,
                            contentType: false,
                            success: function (rst) {
                                if (rst.error) {
                                    swal({
                                        title: "上传失败",
                                        text: rst.error,
                                        type: "warning",
                                        confirmButtonText: "{{ __('Ok') }}",
                                    });
                                } else {
                                    $that.summernote('insertImage', rst.url);
                                }
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                swal({
                                    title: "上传失败",
                                    type: "warning",
                                    confirmButtonText: "{{ __('Ok') }}",
                                });
                            }
                        });
                    }
                }
            });

            // 删除确认
            $('.confirm-delete').on('click', function () {
                var url = $(this).attr('href');
                if (url === '') {
                    return false;
                }

                swal({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('Are you sure to delete? Once deleted, it will be lost forever!') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Yes, delete it!') }}",
                    cancelButtonText: "{{ __('No, please cancel it!') }}"
                }, function (isConfirm) {
                    if (isConfirm) {
                        location.href = url;
                    }
                });

                return false;
            });
        });
    }(jQuery);
</script>

@section('script')
@show
</body>
</html>



