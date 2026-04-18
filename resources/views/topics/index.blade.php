@php
    $topicTitle = $topic->title . ' | Niu 的个人博客';
    $topicDescription = make_excerpt(clean($topic->body), 140);
    $topicUrl = route('topics.show', $topic);
    $topicImage = $topic->background ?: asset('uploads/images/system/niu.png');
@endphp
    <!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $topicDescription }}">
    <meta name="robots" content="index,follow">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $topicTitle }}">
    <meta property="og:description" content="{{ $topicDescription }}">
    <meta property="og:url" content="{{ $topicUrl }}">
    <meta property="og:image" content="{{ $topicImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $topicTitle }}">
    <meta name="twitter:description" content="{{ $topicDescription }}">
    <meta name="twitter:image" content="{{ $topicImage }}">
    <link rel="canonical" href="{{ $topicUrl }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $topicTitle }}</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/icomoon.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="icon" href="{{asset('uploads/images/system/niu.png')}}" type="image/x-icon">
    <style>
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
            top: 1px;
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

        .theme-dark .topic-body {
            color: #e6e6e6;
        }

        .theme-dark .topic-body a {
            color: #fff;
        }

        .theme-dark .topic-body a:hover {
            color: #c9d8ff;
        }

        .theme-dark .topic-body h1,
        .theme-dark .topic-body h2,
        .theme-dark .topic-body h3,
        .theme-dark .topic-body h4,
        .theme-dark .topic-body h5,
        .theme-dark .topic-body h6,
        .theme-dark .topic-body figure {
            color: #ea4c89;
        }

        .theme-dark .topic-body li {
            color: #ccc;
        }

        .theme-dark .topic-body table {
            background: #262b35;
            border-color: #475569;
        }

        .theme-dark .topic-body table th,
        .theme-dark .topic-body table td {
            color: #f8fafc;
            border-color: #475569;
        }

        .theme-dark .topic-body table th {
            background: #313744;
        }

        .theme-dark .topic-body table tr {
            background: #262b35;
        }

        .theme-dark .topic-body table tr:nth-child(2n) {
            background: #2c313d;
        }

        .topic-body p code,
        .topic-body li code,
        .topic-body td code,
        .topic-body blockquote code,
        .topic-body h1 code,
        .topic-body h2 code,
        .topic-body h3 code,
        .topic-body h4 code,
        .topic-body h5 code,
        .topic-body h6 code {
            color: #2ab4d2;
            font-weight: 600;
        }

        .topic-body pre code {
            color: #352424;
            background: transparent;
            border: 0;
            padding: 0;
            font-weight: inherit;
        }

        .theme-dark .topic-body p code,
        .theme-dark .topic-body li code,
        .theme-dark .topic-body td code,
        .theme-dark .topic-body blockquote code,
        .theme-dark .topic-body h1 code,
        .theme-dark .topic-body h2 code,
        .theme-dark .topic-body h3 code,
        .theme-dark .topic-body h4 code,
        .theme-dark .topic-body h5 code,
        .theme-dark .topic-body h6 code {
            color: #2ab4d2;
        }

        .topic-body pre {
            background-color: #af8b33;
        }

        .topic-body blockquote {
            color: #E0F2FE;
            background-color: #0976a9;
        }

        .topic-body img {
            cursor: zoom-in;
            max-width: 100%;
            height: auto;
        }

        .topic-content-shell {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        #page.topic-index-wrapper {
            overflow: visible;
        }

        #page.topic-index-wrapper #fh5co-main-content {
            max-width: 1352px;
        }

        .topic-toc {
            position: -webkit-sticky;
            position: sticky;
            top: 18px;
            z-index: 20;
            align-self: flex-start;
            padding: 20px 24px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #dbe4ee;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }

        .topic-toc h3 {
            margin: 0 0 14px;
            font-size: 16px;
            color: #0f172a;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .topic-toc ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .topic-toc li + li {
            margin-top: 10px;
        }

        .topic-toc li.topic-toc-item-level-2 a {
            padding-left: 28px;
            font-size: 14px;
        }

        .topic-toc li.topic-toc-item-level-2 a::before {
            left: 12px;
            width: 5px;
            height: 5px;
        }

        .topic-toc a {
            position: relative;
            display: block;
            padding-left: 16px;
            color: #475569;
            text-decoration: none;
            transition: color 180ms ease;
        }

        .topic-toc a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #cbd5e1;
            transform: translateY(-50%);
            transition: transform 180ms ease, background-color 180ms ease;
        }

        .topic-toc a:hover,
        .topic-toc a.is-active {
            color: #0f172a;
        }

        .topic-toc a.is-active::before {
            background: #ea4c89;
            transform: translateY(-50%) scale(1.15);
        }

        .topic-body h1[id],
        .topic-body h2[id] {
            scroll-margin-top: 32px;
        }

        .theme-dark .topic-toc {
            background: #20242d;
            border-color: #3b4250;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.24);
        }

        .theme-dark .topic-toc h3,
        .theme-dark .topic-toc a.is-active,
        .theme-dark .topic-toc a:hover {
            color: #f8fafc;
        }

        .theme-dark .topic-toc a {
            color: #cbd5e1;
        }

        .theme-dark .topic-toc li.topic-toc-item-level-1 a,
        .theme-dark .topic-toc li.topic-toc-item-level-1 a.is-active,
        .theme-dark .topic-toc li.topic-toc-item-level-1 a:hover {
            color: #f8fafc;
        }

        .theme-dark .topic-toc li.topic-toc-item-level-2 a {
            color: #e2e8f0;
        }

        .theme-dark .topic-toc a::before {
            background: #64748b;
        }

        .theme-dark .topic-toc a.is-active::before {
            background: #ea4c89;
        }

        @media (min-width: 992px) {
            .topic-content-shell {
                flex-direction: row;
                align-items: flex-start;
                gap: 92px;
            }

            .topic-body {
                flex: 1 1 auto;
                min-width: 0;
            }

            .topic-toc {
                top: 28px;
                width: 360px;
                flex: 0 0 360px;
            }
        }

        .image-preview-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.85);
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 180ms ease, visibility 180ms ease;
        }

        .image-preview-overlay.is-active {
            display: flex;
            opacity: 1;
            visibility: visible;
        }

        .image-preview-overlay img {
            max-width: 90vw;
            max-height: 90vh;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
            transform: scale(0.96);
            transition: transform 200ms ease;
            cursor: grab;
            user-select: none;
        }

        .image-preview-overlay.is-active img {
            transform: scale(1);
        }

        .image-preview-overlay.is-dragging img {
            cursor: grabbing;
        }
    </style>
</head>
<body class="single">
<div class="fh5co-loader"></div>

<div id="page" class="topic-index-wrapper">
    @if(!$topic->background)
        <div id="fh5co-aside" style="background-image: url({{ asset('uploads/images/system/default.jpg') }})"
             data-stellar-background-ratio="0.5">
            @else
                <div id="fh5co-aside" style="background-image: url({{ $topic->background }})"
                     data-stellar-background-ratio="0.5">
                    @endif
                    <div class="overlay"></div>
                    <nav role="navigation">
                        <ul>
                            <li><a href="{{ route('home.show') }}"><i class="icon-home"></i></a></li>
                            <li>
                                <button type="button" class="home-theme-toggle" aria-label="Toggle theme"
                                        aria-pressed="false">
                                    <i class="icon-light-down" aria-hidden="true"></i>
                                    <i class="icon-light-up" aria-hidden="true"></i>
                                </button>
                            </li>
                        </ul>
                    </nav>
                    <div class="page-title">
                        <h2 class="text-center">
                            {{ $topic->title }}
                        </h2>
                        <span>{{ date("F . d . Y",  strtotime($topic->created_at)) }}</span>
                    </div>
                </div>
                <div id="fh5co-main-content">
                    <div class="fh5co-post">
                        <div class="fh5co-entry padding">
                            <div class="topic-content-shell">
                                @if (count($topicToc))
                                    <aside class="topic-toc" data-topic-toc aria-label="{{ __('topic.navigation_label') }}">
                                        <h3>{{ __('topic.table_of_contents') }}</h3>
                                        <ul>
                                            @foreach ($topicToc as $item)
                                                <li class="topic-toc-item-level-{{ $item['level'] }}">
                                                    <a href="#{{ $item['id'] }}" data-topic-toc-link="{{ $item['id'] }}">
                                                        {{ $item['title'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </aside>
                                @endif
                                <div class="topic-body">
                                    {!! $topicBodyHtml !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fh5co-navigation">
                    @if(!$next)
                        <div class="fh5co-cover prev fh5co-cover-sm"
                             style="background-image: url({{ asset('uploads/images/system/default.jpg') }})">
                            <a class="copy" href="{{ route('home.show') }}">
                                @elseif(!$next->background)
                                    <div class="fh5co-cover prev fh5co-cover-sm"
                                         style="background-image: url({{ asset('uploads/images/system/default.jpg') }})">
                                        <a class="copy" href="{{ route('topics.show', $next->id) }}">
                                            @else
                                                <div class="fh5co-cover prev fh5co-cover-sm"
                                                     style="background-image: url({{ $next->background }})">
                                                    <a class="copy" href="{{ route('topics.show', $next) }}">
                                                        @endif
                                                        <div class="display-t">
                                                            <div class="display-tc">
                                                                <div>
                                                                    <span class="behind_post">上一篇</span>
                                                                    @if(!$next)
                                                                        <h2>没有上一篇啦</h2>
                                                                    @else
                                                                        <h2>{{ $next->title }}</h2>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                                @if(!$behind)
                                                    <div class="fh5co-cover next fh5co-cover-sm"
                                                         style="background-image: url({{ asset('uploads/images/system/default.jpg') }})">
                                                        <a class="copy" href="{{ route('home.show') }}">
                                                            @elseif(!$behind->background)
                                                                <div class="fh5co-cover next fh5co-cover-sm"
                                                                     style="background-image: url({{ asset('uploads/images/system/default.jpg') }})">
                                                                    <a class="copy"
                                                                       href="{{ route('topics.show', $behind->id) }}">
                                                                        @else
                                                                            <div class="fh5co-cover next fh5co-cover-sm"
                                                                                 style="background-image: url({{ $behind->background }})">
                                                                                <a class="copy"
                                                                                   href="{{ route('topics.show', $behind) }}">
                                                                                    @endif
                                                                                    <div class="display-t">
                                                                                        <div class="display-tc">
                                                                                            <div>
                                                                                                <span class="next_post">下一篇</span>
                                                                                                @if(!$behind)
                                                                                                    <h2>
                                                                                                        没有下一篇啦</h2>
                                                                                                @else
                                                                                                    <h2>{{ $behind->title }}</h2>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                </div>

                                                                <footer class="home_footer">
                                                                    <div>
                                                                        &copy;Niu Blog 2026 .Powered By Niu
                                                                        <br><a href="https://beian.miit.gov.cn/"
                                                                               target="_blank">青ICP备18000982号</a>
                                                                    </div>
                                                                </footer>

                                                                <div class="gototop js-top">
                                                                    <a href="#" class="js-gotop"><i
                                                                            class="icon-arrow-up"></i></a>
                                                                </div>
                                                    </div>
                                                    <div class="image-preview-overlay" aria-hidden="true">
                                                        <img src="" alt="preview">
                                                    </div>
                                                    <script src="/js/jquery.min.js"></script>
                                                    <script src="/js/jquery.easing.1.3.js"></script>
                                                    <script src="/js/bootstrap.min.js"></script>
                                                    <script src="/js/jquery.waypoints.min.js"></script>
                                                    <script src="/js/jquery.stellar.min.js"></script>
                                                    <script src="/js/main.js"></script>
                                                    <script src="/js/modernizr-2.6.2.min.js"></script>
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

                                                            const $toc = $('[data-topic-toc]');
                                                            const $tocLinks = $toc.find('[data-topic-toc-link]');
                                                            const headings = $tocLinks.map(function () {
                                                                const id = $(this).data('topicTocLink');
                                                                return document.getElementById(id);
                                                            }).get().filter(Boolean);
                                                            let activeSectionId = null;
                                                            let pendingSectionId = null;

                                                            function setActiveSection(id) {
                                                                if (!id) {
                                                                    return;
                                                                }

                                                                activeSectionId = id;

                                                                $tocLinks.each(function () {
                                                                    const $link = $(this);
                                                                    const isActive = $link.data('topicTocLink') === id;
                                                                    $link.toggleClass('is-active', isActive);

                                                                    if (isActive) {
                                                                        $link.attr('aria-current', 'true');
                                                                    } else {
                                                                        $link.removeAttr('aria-current');
                                                                    }
                                                                });
                                                            }

                                                            function setHash(sectionId) {
                                                                if (!sectionId) {
                                                                    return;
                                                                }

                                                                const nextHash = '#' + sectionId;

                                                                if (window.location.hash === nextHash) {
                                                                    return;
                                                                }

                                                                window.history.replaceState(null, '', nextHash);
                                                            }

                                                            if ($tocLinks.length) {
                                                                const getObserverCandidateId = function () {
                                                                    if (!headings.length) {
                                                                        return null;
                                                                    }

                                                                    const viewportOffset = 56;
                                                                    const headingsAboveOffset = headings.filter(function (heading) {
                                                                        return heading.getBoundingClientRect().top <= viewportOffset;
                                                                    });

                                                                    if (headingsAboveOffset.length) {
                                                                        return headingsAboveOffset[headingsAboveOffset.length - 1].id;
                                                                    }

                                                                    return headings[0].id;
                                                                };

                                                                const syncFromHash = function () {
                                                                    const hash = window.location.hash.replace(/^#/, '');

                                                                    if (hash && document.getElementById(hash)) {
                                                                        setActiveSection(hash);
                                                                        return;
                                                                    }

                                                                    syncActiveSection();
                                                                };

                                                                $tocLinks.on('click', function (event) {
                                                                    event.preventDefault();

                                                                    const sectionId = $(this).data('topicTocLink');
                                                                    const target = document.getElementById(sectionId);

                                                                    if (!target) {
                                                                        return;
                                                                    }

                                                                    pendingSectionId = sectionId;
                                                                    setActiveSection(sectionId);
                                                                    target.scrollIntoView({
                                                                        behavior: 'smooth',
                                                                        block: 'start',
                                                                    });
                                                                    setHash(sectionId);
                                                                });

                                                                if ('IntersectionObserver' in window) {
                                                                    const observer = new IntersectionObserver(function () {
                                                                        const candidateId = getObserverCandidateId();

                                                                        if (!candidateId) {
                                                                            return;
                                                                        }

                                                                        if (pendingSectionId) {
                                                                            if (candidateId !== pendingSectionId) {
                                                                                setActiveSection(pendingSectionId);
                                                                                return;
                                                                            }

                                                                            pendingSectionId = null;
                                                                        }

                                                                        if (candidateId !== activeSectionId) {
                                                                            setActiveSection(candidateId);
                                                                        }

                                                                        setHash(candidateId);
                                                                    }, {
                                                                        root: null,
                                                                        rootMargin: '-56px 0px -60% 0px',
                                                                        threshold: [0, 1],
                                                                    });

                                                                    headings.forEach(function (heading) {
                                                                        observer.observe(heading);
                                                                    });
                                                                } else {
                                                                    $(window).on('scroll resize', function () {
                                                                        const candidateId = getObserverCandidateId();

                                                                        if (!candidateId) {
                                                                            return;
                                                                        }

                                                                        if (pendingSectionId) {
                                                                            if (candidateId !== pendingSectionId) {
                                                                                setActiveSection(pendingSectionId);
                                                                                return;
                                                                            }

                                                                            pendingSectionId = null;
                                                                        }

                                                                        setActiveSection(candidateId);
                                                                        setHash(candidateId);
                                                                    });
                                                                }

                                                                $(window).on('hashchange', syncFromHash);
                                                                syncFromHash();
                                                            }

                                                            const $overlay = $('.image-preview-overlay');
                                                            const $preview = $overlay.find('img');
                                                            const minScale = 0.5;
                                                            const maxScale = 5;
                                                            const scaleStep = 0.1;
                                                            let currentScale = 1;
                                                            let isDragging = false;
                                                            let startX = 0;
                                                            let startY = 0;
                                                            let translateX = 0;
                                                            let translateY = 0;

                                                            function applyTransform() {
                                                                const scale = currentScale.toFixed(2);
                                                                $preview.css('transform', 'translate(' + translateX + 'px, ' + translateY + 'px) scale(' + scale + ')');
                                                            }

                                                            $(document).on('click', '.topic-body img', function (event) {
                                                                event.preventDefault();
                                                                const src = $(this).attr('src');
                                                                if (!src) {
                                                                    return;
                                                                }
                                                                currentScale = 1;
                                                                translateX = 0;
                                                                translateY = 0;
                                                                $preview.attr('src', src);
                                                                applyTransform();
                                                                $overlay.addClass('is-active').attr('aria-hidden', 'false');
                                                                $('body').css('overflow', 'hidden');
                                                            });

                                                            $overlay.on('click', function (event) {
                                                                if (event.target === $preview[0] || isDragging) {
                                                                    return;
                                                                }
                                                                $overlay.removeClass('is-active').attr('aria-hidden', 'true');
                                                                $preview.attr('src', '');
                                                                currentScale = 1;
                                                                translateX = 0;
                                                                translateY = 0;
                                                                $('body').css('overflow', '');
                                                            });

                                                            $overlay.on('wheel', function (event) {
                                                                if (!$overlay.hasClass('is-active')) {
                                                                    return;
                                                                }
                                                                event.preventDefault();
                                                                if (event.originalEvent.deltaY < 0) {
                                                                    currentScale = Math.min(maxScale, currentScale + scaleStep);
                                                                } else {
                                                                    currentScale = Math.max(minScale, currentScale - scaleStep);
                                                                }
                                                                applyTransform();
                                                            });

                                                            $preview.on('mousedown', function (event) {
                                                                if (!$overlay.hasClass('is-active')) {
                                                                    return;
                                                                }
                                                                if (currentScale <= 1) {
                                                                    return;
                                                                }
                                                                event.preventDefault();
                                                                isDragging = true;
                                                                startX = event.clientX - translateX;
                                                                startY = event.clientY - translateY;
                                                                $overlay.addClass('is-dragging');
                                                            });

                                                            $(document).on('mousemove', function (event) {
                                                                if (!isDragging) {
                                                                    return;
                                                                }
                                                                translateX = event.clientX - startX;
                                                                translateY = event.clientY - startY;
                                                                applyTransform();
                                                            });

                                                            $(document).on('mouseup', function () {
                                                                if (!isDragging) {
                                                                    return;
                                                                }
                                                                isDragging = false;
                                                                $overlay.removeClass('is-dragging');
                                                            });

                                                            $(document).on('keydown', function (event) {
                                                                if (event.key === 'Escape' && $overlay.hasClass('is-active')) {
                                                                    $overlay.trigger('click');
                                                                }
                                                            });
                                                        });
                                                    </script>
</body>
</html>
