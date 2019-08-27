<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@yield('title') | {{ config('site.base.name') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="{{ config('site.seo.keywords') }}">
    <meta name="description" content="{{ config('site.seo.description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/bootstrap-4.1.2/bootstrap.min.css') }}">
    <link href="{{ asset('plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.3.4/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.3.4/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.3.4/animate.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">

    @section('style')
    @show
</head>
<body>

@include('frontend::layouts._header')

@section('content')
@show

@include('frontend::layouts._footer')


<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('styles/bootstrap-4.1.2/popper.js') }}"></script>
<script src="{{ asset('styles/bootstrap-4.1.2/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TweenMax.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/TimelineMax.min.js') }}"></script>
<script src="{{ asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/animation.gsap.min.js') }}"></script>
<script src="{{ asset('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
<script src="{{ asset('plugins/OwlCarousel2-2.3.4/owl.carousel.js') }}"></script>
<script src="{{ asset('plugins/easing/easing.js') }}"></script>
<script src="{{ asset('plugins/progressbar/progressbar.min.js') }}"></script>
<script src="{{ asset('plugins/parallax-js-master/parallax.min.js') }}"></script>


<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/spark-md5.min.js') }}"></script>
<script src="{{ asset('js/jquery.chunkupload.js') }}"></script>

@section('script')
@show
</body>
</html>