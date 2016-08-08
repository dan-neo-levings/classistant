<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($title)) ? $title : "Classistant" }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" />

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body class="full-background">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


    <div class="wrapper" id="login-area login-show" style="padding-top:60px">



        <img src="{{ asset('images/logo-07.png') }}" alt="Classistant" class="logo" />
        <div class="login-description"><b>Join Classistant</b> - your aid in all organisation of your classes.</div>

        <form class="login-form" method="POST" action="{{ route('register') }}" onsubmit="return attempt()" autocomplete="off">
            {{ csrf_field() }}
              <input style="display:none">
<input type="password" style="display:none">

           <div class="form-group">
                <label for="username" class="{{ ($errors->has('username')) ? 'validation-error' : '' }}"><i class="fa fa-user"></i></label>
                <input type="text" name="username" id="username" placeholder="Full Name" value="{{ old('username') }}"/>
            </div>

            <div class="form-group">
                <label for="email" class="{{ ($errors->has('email')) ? 'validation-error' : '' }}"><i class="fa fa-envelope"></i></label>
                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}"/>
            </div>

            <input type="submit" value="Register" />
        </form>
        <div class="extra-links">
            <div class="login-link">
                <a href="{{ route('lander') }}" >
                    <i class="fa fa-question"></i>
                    <span class="underlined-link">What is Classistant?</span>
                </a>
            </div>
              <div class="seperator">|</div>
            <div class="login-link">Got an account?&nbsp;&nbsp;&nbsp; <a href="{{ route('login.form') }}" class="underlined-link">Login Now!</a></div>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>


    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-61086114-2', 'auto');
      ga('send', 'pageview');

    </script>

        @include('partials/message-boxes')



</body>

</html>