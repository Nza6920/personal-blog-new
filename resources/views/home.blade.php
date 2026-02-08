@extends('layouts.app')
@section('title', 'Niu的个人博客! - 首页')

@section('meta')
    <meta name="description" content="Niu 的个人博客首页，分享技术文章与思考。">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Niu的个人博客! - 首页">
    <meta property="og:description" content="Niu 的个人博客首页，分享技术文章与思考。">
    <meta property="og:url" content="{{ route('home.show') }}">
    <meta property="og:image" content="{{ asset('uploads/images/system/niu.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Niu的个人博客! - 首页">
    <meta name="twitter:description" content="Niu 的个人博客首页，分享技术文章与思考。">
    <meta name="twitter:image" content="{{ asset('uploads/images/system/niu.png') }}">
    <link rel="canonical" href="{{ route('home.show') }}">
    <link rel="alternate" type="application/rss+xml" title="Niu Blog RSS" href="{{ route('feeds.main') }}">
@endsection

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

        .home-search-panel {
            position: fixed;
            top: 33%;
            left: 67%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: rgba(0, 0, 0, 0.75);
            border-radius: 6px;
            padding: 16px 20px;
            display: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .home-search-panel.is-open {
            display: inline-flex;
        }

        .home-search-panel form {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .home-search-panel input[type="search"] {
            width: 480px;
            background: transparent;
            border: 0;
            color: #fff;
            outline: none;
            font-size: 18px;
        }

        .home-search-panel button {
            background: transparent;
            border: 0;
            color: #fff;
            cursor: pointer;
            padding: 0;
            font-size: 20px;
        }

        .home-search-panel ::placeholder {
            color: rgba(255, 255, 255, 0.6);
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

            const $searchToggle = $('.js-search-toggle');
            const $searchPanel = $('.home-search-panel');
            const $searchInput = $searchPanel.find('input[type="search"]');

            $searchToggle.on('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                $searchPanel.toggleClass('is-open');
                const isOpen = $searchPanel.hasClass('is-open');
                $searchPanel.attr('aria-hidden', isOpen ? 'false' : 'true');
                if (isOpen) {
                    $searchInput.focus();
                    $searchInput.select();
                }
            });

            $searchPanel.on('click', function (event) {
                event.stopPropagation();
            });

            $(document).on('click', function () {
                if ($searchPanel.hasClass('is-open')) {
                    $searchPanel.removeClass('is-open').attr('aria-hidden', 'true');
                }
            });

            $(document).on('keydown', function (event) {
                if (event.key === 'Escape' && $searchPanel.hasClass('is-open')) {
                    $searchPanel.removeClass('is-open').attr('aria-hidden', 'true');
                }
            });

            $(document).on('keydown', function (event) {
                const target = event.target;
                const isTypingField = target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement || target?.isContentEditable;
                if (isTypingField) {
                    return;
                }

                if (event.key === '/' || (event.key.toLowerCase() === 'k' && (event.ctrlKey || event.metaKey))) {
                    event.preventDefault();
                    if (!$searchPanel.hasClass('is-open')) {
                        $searchPanel.addClass('is-open').attr('aria-hidden', 'false');
                    }
                    $searchInput.focus();
                    $searchInput.select();
                }
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
                        <br><a href="https://beian.miit.gov.cn/" target="_blank">青ICP备18000982号</a>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <div class="home-search-panel" aria-hidden="true">
        <form method="GET" action="{{ route('home.show') }}" role="search">
            <input type="search" name="keyword" placeholder="搜索文章" autocomplete="off" value="{{ $search ?? '' }}">
            <button type="submit" aria-label="Search">
                <i class="icon-search" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <div class="gototop gototop--search js-top">
        <a href="#" class="js-search-toggle" aria-label="Toggle search"><i class="icon-search"></i></a>
    </div>
    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
    </div>
@endsection
