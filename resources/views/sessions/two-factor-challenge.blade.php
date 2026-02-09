<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Niu Blog - Two Factor Challenge</title>
    <link rel="icon" href="{{ asset('uploads/images/system/niu.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <div class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(16,185,129,0.2),transparent_60%),radial-gradient(circle_at_bottom,rgba(14,165,233,0.18),transparent_55%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(120deg,rgba(15,23,42,0.9),rgba(15,23,42,0.6))]"></div>

        <div class="relative flex min-h-screen items-center justify-center px-6 py-12">
            <div class="w-full max-w-md space-y-8 rounded-2xl border border-slate-800/60 bg-slate-900/70 p-8 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.9)] backdrop-blur">
                <div class="space-y-2 text-center">
                    <h1 class="text-3xl font-semibold text-slate-100">Two factor verification</h1>
                    <p class="text-sm text-slate-400">Enter your authenticator code or use a recovery code.</p>
                </div>

                @include('error.error')

                <form method="post" action="{{ url('/two-factor-challenge') }}" class="space-y-5">
                    @csrf

                    <flux:input
                        id="code"
                        name="code"
                        label="Authenticator code"
                        placeholder="123456"
                        autocomplete="one-time-code"
                    />

                    <flux:input
                        id="recovery_code"
                        name="recovery_code"
                        label="Recovery code"
                        placeholder="Use this if OTP is unavailable"
                        autocomplete="off"
                    />

                    <button type="submit" class="w-full rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-white">
                        Verify and continue
                    </button>
                </form>

                <div class="text-center text-xs text-slate-500">
                    If you lost your device, use one of your recovery codes.
                </div>
            </div>
        </div>
    </div>

    @fluxScripts
</body>
</html>
