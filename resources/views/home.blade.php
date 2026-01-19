@extends('layouts.app')
@section('title', 'Niu的个人博客! - 首页')

@section('styles')
    <style>
        #fh5co-aside nav {
            position: relative;
        }

        #fh5co-aside nav ul li {
            display: inline-flex;
            align-items: center;
            margin-right: 6px;
        }

        #fh5co-aside nav ul li:last-child {
            margin-right: 0;
        }

        .home-theme-toggle {
            position: relative;
            top: 2px;
            background: rgba(255, 255, 255, 0.1);
            border: 0;
            color: rgba(255, 255, 255, 0.5);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: block;
            text-align: center;
            padding: 0;
            font-size: 14px;
            line-height: 30px;
            vertical-align: middle;
        }

        .home-theme-toggle i {
            display: block;
            line-height: 30px;
        }

        .home-theme-toggle:hover {
            background: white;
            color: #000;
        }

        .home-theme-toggle .icon-light-up {
            display: none;
        }

        .theme-dark .home-theme-toggle .icon-light-up {
            display: inline-block;
        }

        .theme-dark .home-theme-toggle .icon-light-down {
            display: none;
        }

        .theme-dark {
            background: #262b35;
            color: #e6e6e6;
        }

        .theme-dark #page {
            background: #262b35;
        }

        .theme-dark a {
            color: #c9d8ff;
        }

        .theme-dark .fh5co-post .fh5co-entry > div a {
            color: #fff;
        }

        .theme-dark .fh5co-post .fh5co-entry > div a:hover {
            color: #c9d8ff;
        }

        .theme-dark .fh5co-entry {
            background: transparent;
            border-color: rgba(255, 255, 255, 0.08);
        }
    </style>
@endsection

@section('script')
    <script>
        $(function () {
            const storageKey = 'theme';
            const $body = $('body');
            const $toggle = $('.home-theme-toggle');

            function applyTheme(value) {
                if (value === 'dark') {
                    $body.addClass('theme-dark');
                    $toggle.attr('aria-pressed', 'true');
                } else {
                    $body.removeClass('theme-dark');
                    $toggle.attr('aria-pressed', 'false');
                }
            }

            applyTheme(localStorage.getItem(storageKey));

            $toggle.on('click', function () {
                const isDark = $body.hasClass('theme-dark');
                const next = isDark ? 'light' : 'dark';
                localStorage.setItem(storageKey, next);
                applyTheme(next);
            });
        });
    </script>
@endsection

@section('content')
    <div class="fh5co-loader"></div>
    <div id="fh5co-aside" style="background-image: url('uploads/images/system/image_1.jpg')">

        <div class="overlay"></div>
        <nav role="navigation">
            <ul>
                <li><a href="{{ route('home.show') }}"><i class="icon-home"></i></a></li>
                <li>
                    <button type="button" class="home-theme-toggle" aria-label="Toggle theme" aria-pressed="false">
                        <i class="icon-light-down" aria-hidden="true"></i>
                        <i class="icon-light-up" aria-hidden="true"></i>
                    </button>
                </li>
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
                <div style="position: relative; left: 42%; top: 96%">
                    {!! $topics->render() !!}
                </div>
                <footer class="home_footer" style="text-align:center; bottom: 0;">
                    <div>
                        &copy;Niu Blog 2026 .Powered By Niu
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
