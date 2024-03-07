<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} | @yield('title')</title>
        <link rel="icon" href="{{ asset('/storage/logo.png') }}">

        <link href="{{ url('css/main.css') }}" rel="stylesheet">

        @stack('before-styles')
            <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link href="{{ asset('css/guest.css') }}" rel="stylesheet">
        @stack('after-styles')
    </head>

    <body>
        <div class="guest-page">
            <a href="{{ route('login') }}">
                <img src="{{ url('/storage/logo.png') }}" alt="Logo" class="logo">
            </a>

            <div class="form">
                @yield('content')
            </div>
        </div>


        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.js') }}"></script>
        <script>
            $("#toggle-password").click(function () {
                $(this).toggleClass("bi-eye-slash-fill bi-eye-fill");
                
                if($("#password").attr("type") == "password") {
                    $("#password").attr("type", "text");
                }
                else {
                    $("#password").attr("type", "password");
                }
            });
        </script>

    </body>
</html>