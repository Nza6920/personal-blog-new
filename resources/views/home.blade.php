@extends('layouts.app')
@section('title', 'Niu的个人博客! - 首页')

@section('content')
    <div class="fh5co-loader"></div>
    <div id="fh5co-aside" style="background-image: url('uploads/images/system/image_1.jpg')">

      <div class="overlay"></div>
      <nav role="navigation">
        <ul>
          <li><a href="{{ route('home.show') }}"><i class="icon-home"></i></a></li>
        </ul>
      </nav>

      <div class="sentence">
        {{-- <h2 >白天搬砖,晚上砌梦想.</h2> --}}
        <h1>Stay hungry, Stay foolish.</h1>
      </div>

      <div class="featured">
        <span>Hi:</span>
        <h1><a href="https://github.com/Nza6920">I'm Niu</a></h1>
      </div>
    </div>
  <div id="page">
    <div id="fh5co-main-content">
      <div class="fh5co-post">

        @foreach ($topics as $topic)
          <div class="fh5co-entry padding">
            <img src="{{ $topic->user->avatar }}" alt="Free HTML5 Bootstrap Template by FreeHTML5.co">
            <div>
              <span class="fh5co-post-date">{{ $topic->created_at->diffForHumans() }}</span>
              <h2><a href="{{ route('topics.show',$topic) }}">{{ $topic->title }}</a></h2>
              <p>{{ $topic->excerpt }}</p>
            </div>
          </div>
        @endforeach
        <div style="position: relative; left: 42%; top: 95%">
          {!! $topics->render() !!}
        </div>
        <footer class="home_footer" style="text-align:center; bottom: 0;">
          <div >
            &copy;Niu Blog 2021 .Powered By Niu
              <br><a href="https://beian.miit.gov.cn/" target="_blank">青ICP备18000982号-1</a>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
  </div>
@endsection
