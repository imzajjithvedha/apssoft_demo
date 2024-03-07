<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} | @yield('title')</title>
        <link rel="icon" href="{{ asset('/storage/logo.png') }}">

        @stack('before-styles')
            <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
            <link href="{{ asset('css/data_table.css') }}" rel="stylesheet">
            <link href="{{ asset('css/jquery_ui.css') }}" rel="stylesheet">
            <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        @stack('after-styles')
    </head>

    <body>
        <div id="app">
            @include('layouts.navigation')

            <div class="wrapper">
                @auth
                    @if(auth()->user()->role == 'admin')
                        @include('includes.sidebar')
                    @endif
                @endauth

                <div class="content">
                    @yield('content')
                </div>
            </div>

            @stack('before-scripts')
                <script src="{{ asset('js/jquery.js') }}"></script>
                <script src="{{ asset('js/jquery_ui.js') }}"></script>
                <script src="{{ asset('js/bootstrap.js') }}"></script>
                <script src="{{ asset('js/select2.js') }}"></script>
                <script src="{{ asset('js/data_table.js') }}"></script>
                <script src="{{ asset('js/sidebar.js') }}"></script>
                <script src="{{ asset('js/main.js') }}"></script>
            @stack('after-scripts')
        </div>
    </body>

</html>