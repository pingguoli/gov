<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ __('Login') }} | {{ config('site.base.name') }}</title>

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('0pole/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('0pole/js/respond.min.js') }}"></script>
    <![endif]-->

</head>
<body class="login-page">
<div class="login-box">
    <div class="login-box-body">
        <h3 class="login-box-msg">{{ __('Login') }}</h3>
        <form action="{{route('admin.login')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control sty1" placeholder="{{ __('Account') }}" value="{{old('username')}}">
                @if($errors->has('username'))
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control sty1" placeholder="{{ __('Password') }}">
                @if($errors->has('password'))
                    <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            @if(!empty(config('site.other.captcha')))
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <input class="form-control sty1" placeholder="{{ __('Captcha') }}" type="text" name="captcha">
                        <div class="input-group-addon">
                            <img src="{{captcha_src()}}" style="cursor: pointer;" onclick="this.src='{{ captcha_src() }}' + Math.random()">
                        </div>
                    </div>
                    @if($errors->has('captcha'))
                        <span class="help-block text-danger">{{ $errors->first('captcha') }}</span>
                    @endif
                </div>
            @endif
            @if(session()->has('error'))
                <div class="form-group has-feedback">
                    <span class="help-block text-danger">{{ session()->get('error') }}</span>
                </div>
            @endif
            <div>
                <div class="col-xs-4 m-t-1">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('0pole/js/jquery.min.js')}}"></script>

<!-- v4.0.0-alpha.6 -->
<script src="{{ asset('0pole/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- template -->
<script src="{{ asset('0pole/js/bizadmin.js')}}"></script>

<!-- NeoAdmin for demo purposes -->
<script src="{{ asset('0pole/js/demo.js')}}"></script>
</body>
</html>