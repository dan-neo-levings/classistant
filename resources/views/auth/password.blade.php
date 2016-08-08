<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/normalize.min.css">
    <link rel="stylesheet" href="../css/login.css">

    <script src="../js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body class="full-background">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


    <div class="wrapper" id="login-area" style="padding-top:60px">



        <img src="{{ asset('images/logo-07.png') }}" alt="Classistant" class="logo" />
        <div class="login-description"><b>Forgotten your password?</b> - don't worry, it happens to the best of us!.<br /><Br />Type in your email below to have a password reset link sent to you.</div>

        <form class="login-form" method="POST" action="email">
            {!! csrf_field() !!}

            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

                 <label for="email"><i class="fa fa-envelope"></i></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">

            <input type="submit" value="Reset Password" />
        </form>
        <div class="extra-links">
            <div class="login-link"><i class="fa fa-lock"></i>Forgotten something?</div> <div class="seperator">|</div>
            <div class="login-link">Got an account?&nbsp;&nbsp;&nbsp; <a href="{{ route('login.form') }}" class="underlined-link">Login Now!</a></div>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script>

    setTimeout(function() {
        console.log("show");
        try {
            document.getElementById("login-area").className += " login-show";
        } catch(e) {
            console.log("No login area");
        }
    }, 100)
    </script>

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