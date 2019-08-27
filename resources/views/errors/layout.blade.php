<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ config('site.base.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="keywords" content="" />

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('0pole/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('0pole/js/respond.min.js') }}"></script>
    <![endif]-->

</head>
<body class="lockscreen">
<div>
    <div class="error-page text-center">
        @yield('message')
        <!-- /.error-content -->
    </div>
    <div class="lockscreen-footer text-center m-t-3">Copyright © 2018 - {{ date('Y') }} <a href="{{config('site.link')}}">{{config('site.author')}}</a> All rights reserved.</div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('0pole/js/jquery.min.js')}}"></script>

<!-- v4.0.0-alpha.6 -->
<script src="{{ asset('0pole/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- template -->
<script src="{{ asset('0pole/js/bizadmin.js')}}"></script>

<script src="{{ asset('0pole/js/sweetalert.min.js')}}"></script>
</body>
</html>