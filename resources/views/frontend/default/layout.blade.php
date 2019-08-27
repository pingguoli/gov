<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('css/web.css') }}">

    <title>@yield('title') | {{ config('site.base.name') }}</title>

    @section('style')
    @show

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            @include('frontend::_header')
        </div>
    </div>

    <div class="row">
        <div class="col">
            @section('content')
            @show
        </div>
    </div>

    <div class="row">
        <div class="col">
            @include('frontend::_footer')
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/spark-md5.min.js') }}"></script>
<script src="{{ asset('js/jquery.chunkupload.js') }}"></script>
<script src="{{ asset('js/web.js') }}"></script>
@section('script')
@show
</body>
</html>