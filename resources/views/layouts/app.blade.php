<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'blog by Niu')</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/icomoon.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="icon" href="{{asset('uploads/images/system/niu.png')}}" type="image/x-icon">
    @yield('styles')
  </head>
  <body>
    @yield('content')


    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery.easing.1.3.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.waypoints.min.js"></script>
    <script src="/js/jquery.stellar.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/modernizr-2.6.2.min.js"></script>
    @yield('script')

  </body>
</html>
