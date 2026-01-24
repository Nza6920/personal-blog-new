<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Niu Blog - Admin Login</title>
    <link rel="icon" href="{{ asset('uploads/images/system/niu.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <div class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(56,189,248,0.18),transparent_60%),radial-gradient(circle_at_bottom,rgba(248,113,113,0.16),transparent_55%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(120deg,rgba(15,23,42,0.9),rgba(15,23,42,0.6))]"></div>

        <div class="relative flex min-h-screen items-center justify-center px-6 py-12">
            <div class="w-full max-w-md space-y-8 rounded-2xl border border-slate-800/60 bg-slate-900/70 p-8 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.9)] backdrop-blur">
                <div class="space-y-2 text-center">
                    <h1 class="text-3xl font-semibold text-slate-100">Welcome back</h1>
                    <p class="text-sm text-slate-400">Sign in to continue managing your blog.</p>
                </div>

                @include('error.error')
                @include('layouts._message')

                <form method="post" action="{{ route('login') }}" id="form_login" class="space-y-5">
                    @csrf

                    <flux:input
                        id="username"
                        name="username"
                        label="Username"
                        placeholder="Enter your username"
                        autocomplete="off"
                        required
                    />

                    <flux:input
                        id="password"
                        name="password"
                        type="password"
                        label="Password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    />

                    <button type="submit" class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-white">
                        Sign in
                    </button>
                </form>

                <div class="text-center text-xs text-slate-500">
                    Tip: Use your admin credentials to access the dashboard.
                </div>
            </div>
        </div>
    </div>

    @fluxScripts
</body>
</html>
