<!DOCTYPE html>
<html lang="zh-Hans">
<head>
    <title>@yield('title', 'Niu 的博客 - 后台')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('uploads/images/system/niu.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css'])
    @fluxAppearance
    @yield('styles')
</head>
<body class="m-0 p-0 min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
<div class="flex min-h-screen flex-col pt-0">
    @include('admin._header')

    <main class="flex-1">
        <div class="mx-auto w-full max-w-6xl px-6 pb-8 pt-18">
            @include('layouts._message', ['showSession' => true, 'showErrors' => true])
            @yield('content')
        </div>
    </main>

    @include('admin._footer')
</div>

@fluxScripts
@vite(['resources/js/app.js'])
@yield('scripts')
</body>
</html>
