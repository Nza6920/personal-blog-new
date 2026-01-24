@php
  use League\CommonMark\Environment\Environment;
  use League\CommonMark\MarkdownConverter;

  $markdownConverter = new MarkdownConverter(Environment::createCommonMarkEnvironment());
@endphp
  <!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Niu的个人博客! - 内容</title>
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

    .topic-body img {
      cursor: zoom-in;
      max-width: 100%;
      height: auto;
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
                <button type="button" class="home-theme-toggle" aria-label="Toggle theme" aria-pressed="false">
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
              <div class="topic-body">
                @if ($topic->body_type === 'MARKDOWN')
                  {!! $markdownConverter->convert($topic->body)->getContent() !!}
                @else
                  {!! $topic->body !!}
                @endif
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
                                           target="_blank">青ICP备18000982号-1</a>
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
