<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Niu的博客') - 博客后台</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{asset('uploads/images/system/niu.png')}}" type="image/x-icon">
    @yield('styles')
  </head>
  <body>

    @include('admin._header')
    <div class="container">
      <div class="col-md-offset-1 col-md-10">
        @include('layouts._message')
        @yield('content')
      </div>
      @include('admin._footer')
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
  </body>
</html>
