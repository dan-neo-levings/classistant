@extends('master')

@section('head')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ (isset($title)) ? $title : "Classistant" }}</title>
        <meta name="description" content="Classistant is your organiser organiser of all your classes - all in one screen! Lesson Plan generation, storage and assistance.">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <!-- FONT AWESOME CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!-- NORMALISE CSS -->
        <link rel="stylesheet" href="{{ asset('/css/normalize.min.css') }}">

        <!--NORMAL CSS RULES -->
        <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

        <!-- INTRO JS CSS -->
        <link rel="stylesheet" href="{{ asset('/css/introjs/introjs.min.css') }}">

        <!-- FAVICON -->
        <link rel="icon" href="{{ asset('/favicon.ico') }}" />

        <!-- MODERNIZR -->
        <script src="{{ asset('/js/vendor/modernizr-2.8.3.min.js') }}"></script>

        <!-- VEX BOX -->
        <link rel="stylesheet" href="{{ asset('/css/vex/vex.css') }}" />
        <link rel="stylesheet" href="{{ asset('/css/vex/vex-theme-os.css') }}" />

         <!-- JQUERY -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        @yield('extra-head')
@endsection

@section('body')



    @include('partials/nav')

    <main class="clearfix">
        @yield('main')
    </main>



    <!-- vex scripts -->
    <script src="{{ asset('/js/vex/vex.combined.min.js') }}"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os';</script>

    <!-- moment JS -->
    <script src="{{ asset('/js/moment.js') }}"></script>

    <!-- intro js -->
    <script src="{{ asset('/js/introjs/intro.min.js') }}"
    <!-- custom js -->
    <script src="{{ asset('/js/plugins.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>

    @yield('extra-scripts')

    @include('partials/message-boxes')
@endsection