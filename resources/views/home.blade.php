@extends('layouts.app')

@php
    $metaTitle = __('home.meta.title');
    $metaDescription = __('home.meta.description');
    $profileLinks = [
        [
            'label' => __('home.actions.github'),
            'href' => 'https://github.com/Nza6920',
            'icon' => 'icon-github',
        ],
        [
            'label' => __('home.actions.search'),
            'href' => '#',
            'icon' => 'icon-search',
            'class' => 'js-search-toggle',
        ],
        [
            'label' => __('home.actions.rss'),
            'href' => route('feeds.main'),
            'icon' => 'icon-rss',
        ],
    ];
    $techStack = __('home.tech_stack.items');
@endphp

@section('title', $metaTitle)

@section('meta')
    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ route('home.show') }}">
    <meta property="og:image" content="{{ asset('uploads/images/system/niu.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ asset('uploads/images/system/niu.png') }}">
    <link rel="canonical" href="{{ route('home.show') }}">
    <link rel="alternate" type="application/rss+xml" title="{{ __('home.actions.rss') }}" href="{{ route('feeds.main') }}">
@endsection

@section('styles')
    <style>
        #fh5co-aside {
            width: 30%;
            background-image:
                linear-gradient(180deg, rgba(10, 14, 20, 0.12), rgba(10, 14, 20, 0.82)),
                url('{{ asset('uploads/images/system/image_1.jpg') }}');
            background-position: center center;
        }

        #fh5co-main-content {
            margin-left: 30%;
        }

        #fh5co-aside .overlay {
            background:
                radial-gradient(circle at top, rgba(88, 132, 255, 0.16), transparent 38%),
                linear-gradient(180deg, rgba(6, 11, 17, 0.08), rgba(6, 11, 17, 0.74));
            opacity: 1;
        }

        #fh5co-aside nav.home-profile-nav {
            position: relative;
            top: auto;
            bottom: auto !important;
            padding: 0;
        }

        #fh5co-aside nav.home-profile-nav ul {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #fh5co-aside nav.home-profile-nav ul li {
            display: inline-flex;
            align-items: center;
            margin: 0;
        }

        #fh5co-aside nav.home-profile-nav ul li a,
        .home-theme-toggle {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.88);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }

        #fh5co-aside nav.home-profile-nav ul li a {
            font-size: 16px;
            line-height: 1;
            text-transform: none;
        }

        .home-theme-toggle {
            cursor: pointer;
            padding: 0;
            font-size: 16px;
        }

        .home-theme-toggle i {
            display: block;
            line-height: 1;
        }

        #fh5co-aside nav.home-profile-nav ul li a:hover,
        .home-theme-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.24);
            color: #fff;
            transform: translateY(-1px);
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
            background: #0D1117;
            color: #e6edf5;
        }

        .theme-dark #page {
            background: #0D1117;
        }

        .theme-dark a {
            color: #c8d9ff;
        }

        .theme-dark .fh5co-post .home-article-entry {
            background: #12171D;
            border-color: rgba(148, 163, 184, 0.14);
            box-shadow: 0 18px 38px rgba(0, 0, 0, 0.24);
        }

        .theme-dark .fh5co-post {
            background: #0D1117;
        }

        .theme-dark .home_footer {
            background: #0D1117;
            color: rgba(230, 237, 245, 0.74);
        }

        .theme-dark .home_footer a {
            color: rgba(200, 217, 255, 0.9);
        }

        .theme-dark .fh5co-post .home-article-entry:hover {
            box-shadow: 0 22px 44px rgba(0, 0, 0, 0.3);
            border-color: rgba(96, 165, 250, 0.24);
        }

        .theme-dark .home-article-card-content h2 a,
        .theme-dark .home-article-card-content a {
            color: #fff;
        }

        .theme-dark .home-article-card-content h2 a:hover,
        .theme-dark .home-article-card-content a:hover {
            color: #c8d9ff;
        }

        .theme-dark .home-article-card-date,
        .theme-dark .home-article-card-meta-separator,
        .theme-dark .home-article-card-excerpt {
            color: rgba(230, 237, 245, 0.74);
        }

        .theme-dark .home-article-card-cover {
            background:
                linear-gradient(180deg, rgba(2, 6, 23, 0.16), rgba(2, 6, 23, 0.48)),
                linear-gradient(135deg, #07111f, #0d2740 58%, #0f4c5c);
        }

        .theme-dark .home-profile-chip,
        .theme-dark .home-profile-action {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
        }

        .fh5co-post .fh5co-entry > div h2 {
            font-weight: 200;
        }

        .fh5co-post .home-article-entry > div h2 {
            margin-bottom: 0;
        }

        .fh5co-post {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 8px 12px 0;
        }

        .fh5co-post .home-article-entry {
            display: grid;
            grid-template-columns: minmax(204px, 252px) minmax(0, 1fr);
            column-gap: 24px;
            align-items: start;
            padding: 16px 18px;
            overflow: visible;
            border-radius: 18px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.96));
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
            transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
        }

        .fh5co-post .home-article-entry:hover {
            transform: translateY(-2px);
            border-color: rgba(88, 132, 255, 0.16);
            box-shadow: 0 22px 42px rgba(15, 23, 42, 0.12);
        }

        .fh5co-post .home-article-entry > div {
            width: auto;
            float: none;
            margin-right: 0;
        }

        .home-article-card-cover {
            position: relative;
            align-self: center;
            width: 100%;
            max-width: 252px;
            aspect-ratio: 16 / 9;
            border-radius: 12px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(5, 12, 24, 0.08), rgba(5, 12, 24, 0.28)),
                linear-gradient(135deg, #0f1b31, #143b5f 58%, #1d6b7f);
        }

        .home-article-card-cover img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .home-article-card-content {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-self: center;
            min-width: 0;
            width: 100%;
            padding: 6px 18px 6px 0;
        }

        .home-article-card-meta {
            display: inline-flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }

        .home-article-card-date {
            display: inline-flex;
            align-items: center;
            color: #667085;
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 0;
        }

        .home-article-card-meta-separator {
            display: inline-flex;
            align-items: center;
            align-self: center;
            color: #98a2b3;
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 0;
        }

        .home-article-card-content h2 {
            margin-top: 0;
            margin-bottom: 0;
            font-size: clamp(24px, 2.8vw, 31px);
            line-height: 1.2;
            font-weight: 300;
        }

        .home-article-card-content h2 a {
            color: #111827;
        }

        .home-article-card-excerpt {
            margin: 12px 0 0;
            color: #667085;
            font-size: 15px;
            line-height: 1.8;
        }

        .home-profile-shell {
            position: relative;
            z-index: 12;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            padding: 28px clamp(20px, 3.8vw, 40px) 34px;
        }

        .home-profile-content {
            margin-top: 28px;
            max-width: 540px;
        }

        .home-profile-hero {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .home-profile-avatar {
            width: 116px;
            height: 116px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 18px 36px rgba(0, 0, 0, 0.26);
        }

        .home-profile-title {
            margin: 0;
            font-size: clamp(28px, 4vw, 36px);
            line-height: 1.08;
            font-weight: 300;
            color: #fff;
        }

        .home-profile-description,
        .home-profile-section-body {
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 15px;
            line-height: 1.85;
        }

        .home-profile-description {
            margin-top: 2px;
        }

        .home-profile-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 26px;
        }

        .home-profile-action {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .home-profile-action:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.24);
            color: #fff;
            transform: translateY(-1px);
        }

        .home-profile-divider {
            margin: 24px 0 18px;
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.04));
        }

        .home-profile-sections {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .home-profile-section-title {
            margin: 0 0 8px;
            font-size: 18px;
            line-height: 1.2;
            font-weight: 600;
            color: #dfffd4;
        }

        .home-profile-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .home-profile-chip {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 13px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.11);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.92);
            font-size: 14px;
            line-height: 1;
        }

        .home-search-panel {
            position: fixed;
            top: 33%;
            left: 67%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: rgba(0, 0, 0, 0.75);
            border-radius: 12px;
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

        .home_footer {
            background: #fff;
            color: #667085;
            text-align: center;
            bottom: 0;
            padding: 10px 20px !important;
        }

        .home_footer a {
            color: inherit;
        }

        .home-pagination {
            text-align: center;
        }

        @media screen and (max-width: 1024px) {
            .home-profile-content {
                max-width: 100%;
            }

            .home-search-panel {
                left: 50%;
            }

            .fh5co-post .home-article-entry {
                grid-template-columns: minmax(184px, 216px) minmax(0, 1fr);
                column-gap: 18px;
                padding: 14px 16px;
            }

            .home-article-card-cover {
                max-width: 216px;
            }

            .home-article-card-content {
                padding: 4px 16px 4px 0;
            }
        }

        @media screen and (max-width: 768px) {
            .home-profile-shell {
                min-height: 700px;
                padding: 22px 18px 28px;
            }

            .home-profile-content {
                margin-top: 22px;
            }

            .home-profile-title {
                font-size: 30px;
            }

            .home-profile-summary,
            .home-profile-description,
            .home-profile-section-body {
                line-height: 1.72;
            }

            .home-search-panel {
                top: 22%;
                width: calc(100% - 32px);
                padding: 14px 16px;
            }

            .home-search-panel form {
                width: 100%;
            }

            .home-search-panel input[type="search"] {
                width: 100%;
                min-width: 0;
                font-size: 16px;
            }

            .fh5co-post {
                gap: 14px;
                padding: 6px 8px 0;
            }

            .fh5co-post .home-article-entry {
                grid-template-columns: 1fr;
                row-gap: 14px;
                padding: 14px 12px 18px;
            }

            .home-article-card-cover {
                width: 100%;
                max-width: none;
            }

            .home-article-card-content {
                padding: 0 0 0;
            }

            .home-article-card-content h2 {
                font-size: 24px;
            }
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

            applyTheme(localStorage.getItem(storageKey) ?? 'dark');

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
    <div id="fh5co-aside">
        <div class="overlay"></div>

        <div class="home-profile-shell" data-home-profile-panel>
            <nav class="home-profile-nav" role="navigation" aria-label="{{ __('home.nav.label') }}">
                <ul>
                    <li>
                        <a href="{{ route('home.show') }}" aria-label="{{ __('home.nav.home') }}">
                            <i class="icon-home" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <button type="button" class="home-theme-toggle" aria-label="{{ __('home.nav.theme_toggle') }}" aria-pressed="false">
                            <i class="icon-light-down" aria-hidden="true"></i>
                            <i class="icon-light-up" aria-hidden="true"></i>
                        </button>
                    </li>
                </ul>
            </nav>

            <div class="home-profile-content">
                <div class="home-profile-hero">
                    <img
                        class="home-profile-avatar"
                        src="{{ asset('uploads/images/system/avatar.jpg') }}"
                        alt="{{ __('home.profile.avatar_alt') }}"
                    >

                    <div class="home-profile-copy">
                        <h1 class="home-profile-title">{{ __('home.profile.title') }}</h1>
                    </div>
                </div>

                <div class="home-profile-actions" data-home-profile-actions>
                    @foreach ($profileLinks as $link)
                        <a
                            href="{{ $link['href'] }}"
                            class="home-profile-action {{ $link['class'] ?? '' }}"
                            aria-label="{{ $link['label'] }}"
                            @if (! str_starts_with($link['href'], '#')) target="_blank" rel="noreferrer" @endif
                        >
                            <i class="{{ $link['icon'] }}" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>

                <div class="home-profile-divider" aria-hidden="true"></div>

                <div class="home-profile-sections">
                    <section class="home-profile-section">
                        <h2 class="home-profile-section-title">{{ __('home.about.title') }}</h2>
                        <p class="home-profile-section-body">{{ __('home.profile.description') }}</p>
                    </section>

                    <section class="home-profile-section">
                        <h2 class="home-profile-section-title">{{ __('home.tech_stack.title') }}</h2>
                        <div class="home-profile-tags" data-home-tech-stack>
                            @foreach ($techStack as $tech)
                                <span class="home-profile-chip">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div id="page">
        <div id="fh5co-main-content">
            <div class="fh5co-post">
                @foreach ($topics as $topic)
                    @php
                        $topicCover = $topic->cover_img ?: asset('uploads/images/system/default.jpg');
                    @endphp
                    <div class="fh5co-entry home-article-entry">
                        <div class="home-article-card-cover">
                            <img src="{{ $topicCover }}" alt="{{ $topic->title }}">
                        </div>
                        <div class="home-article-card-content">
                            <div class="home-article-card-meta">
                                <span class="fh5co-post-date home-article-card-date">{{ $topic->created_at->diffForHumans() }}</span>
                                @if ($topic->estimated_read_time)
                                    <span class="home-article-card-meta-separator" aria-hidden="true">•</span>
                                    <span class="fh5co-post-date home-article-card-date">
                                        {{ trans_choice('home.article.read_time', $topic->estimated_read_time, ['count' => $topic->estimated_read_time]) }}
                                    </span>
                                @endif
                            </div>
                            <h2><a href="{{ route('topics.show', $topic) }}">{{ $topic->title }}</a></h2>
                            <p class="home-article-card-excerpt">{{ $topic->excerpt }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="home-pagination">
                    {!! $topics->render() !!}
                </div>
                <footer class="home_footer">
                    <div>
                        &copy; {{ date('Y') }} nza · Running since 2018 · Engineering Notes & Life Notes
                        <br><a href="https://beian.miit.gov.cn/" target="_blank">青ICP备18000982号</a>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <div class="home-search-panel" aria-hidden="true">
        <form method="GET" action="{{ route('home.show') }}" role="search">
            <input type="search" name="keyword" placeholder="{{ __('home.search.placeholder') }}" autocomplete="off" value="{{ $search ?? '' }}">
            <button type="submit" aria-label="{{ __('home.search.submit_label') }}">
                <i class="icon-search" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <div class="gototop gototop--search js-top">
        <a href="#" class="js-search-toggle" aria-label="{{ __('home.actions.search') }}"><i class="icon-search"></i></a>
    </div>
    <div class="gototop js-top">
        <a href="#" class="js-gotop" aria-label="{{ __('home.nav.back_to_top') }}"><i class="icon-arrow-up"></i></a>
    </div>
@endsection
