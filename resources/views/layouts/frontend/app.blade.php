<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')-{{ config('app.name', 'Laravel') }}</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="{{asset('asset/frontend/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('asset/frontend/css/swiper.css')}}" rel="stylesheet">

    <link href="{{asset('asset/frontend/css/ionicons.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link href="{{asset('asset/frontend/css/home/styles.css')}}" rel="stylesheet">
    <link href="{{asset('asset/frontend/css/home/responsive.css')}}" rel="stylesheet">
    @stack('css')
</head>

<body>

    @include('layouts.frontend.include.header')

    @yield('content')

    @include('layouts.frontend.include.footer')


    <!-- SCIPTS -->

    <script src="{{asset('asset/frontend/js/jquery-3.1.1.min.js')}}"></script>

    <script src="{{asset('asset/frontend/js/tether.min.js')}}"></script>

    <script src="{{asset('asset/frontend/js/bootstrap.js')}}"></script>

    <script src="{{asset('asset/frontend/js/swiper.js')}}"></script>

    <script src="{{asset('asset/frontend/js/scripts.js')}}"></script>



    <!-- Toastr Js -->
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}

    {{--Toastr Error massage show in laravel validation--}}
    <script>
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error('{{$error}}', 'Error', {
                closeButton:true,
                progressBar:true,
            });
        @endforeach
    @endif
    </script>

    @stack('js')
</body>

</html>