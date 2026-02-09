@extends('admin.default')
@section('title', '个人资料')
@section('content')
    <div class="flex min-h-[calc(100vh-200px)] items-center justify-center">
        <div class="w-full max-w-3xl rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @include('error.error')
            <div class="p-6">
                <form id="profile-update-form" method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <img
                                src="{{ $user->avatar }}"
                                alt="用户头像"
                                class="h-14 w-14 rounded-full border border-slate-200 object-cover shadow-sm dark:border-slate-700"
                            >
                            <div>
                                <div class="text-lg font-semibold text-slate-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <input
                                id="avatar"
                                type="file"
                                name="avatar"
                                accept="image/*"
                                class="block w-full text-xs text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-700 dark:text-slate-300 dark:file:bg-white dark:file:text-slate-900 dark:hover:file:bg-slate-200"
                            >
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <flux:input
                            label="用户名"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                        />
                        <flux:input
                            label="邮箱"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            required
                        />
                    </div>

                    <div class="flex justify-end">
                        <x-confirm-modal
                            name="confirm-profile-update-modal"
                            title="确认保存资料？"
                            message="将更新你的头像、用户名和邮箱信息。"
                            target-form-id="profile-update-form"
                            trigger-label="保存资料"
                            trigger-variant="filled"
                            trigger-color="slate"
                            confirm-label="确认保存"
                            confirm-variant="primary"
                            confirm-color="emerald"
                        />
                    </div>
                </form>
            </div>

            <div class="border-t border-slate-100 px-6 py-5 dark:border-slate-800">
                <form id="profile-password-form" method="post" action="{{ route('admin.profile.password') }}" class="grid gap-4 sm:grid-cols-2">
                    @csrf
                    <flux:input
                        label="当前密码"
                        name="current_password"
                        type="password"
                        autocomplete="current-password"
                        viewable
                        required
                    />
                    <flux:input
                        label="新密码"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        viewable
                        required
                    />
                    <flux:input
                        label="确认新密码"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        viewable
                        required
                    />
                    <div class="flex items-end justify-end sm:justify-start">
                        <x-confirm-modal
                            name="confirm-password-update-modal"
                            title="确认修改密码？"
                            message="修改后请使用新密码重新登录后台。"
                            target-form-id="profile-password-form"
                            trigger-label="修改密码"
                            trigger-variant="filled"
                            confirm-label="确认修改"
                            confirm-variant="primary"
                            confirm-color="emerald"
                        />
                    </div>
                </form>
            </div>

            <div class="border-t border-slate-100 px-6 py-5 dark:border-slate-800">
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">双因素认证</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">为后台登录增加一次动态验证码校验。</p>
                        </div>
                        @if ($user->two_factor_secret)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">已启用</span>
                        @else
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">未启用</span>
                        @endif
                    </div>

                    @if ($user->two_factor_secret)
                        <div class="space-y-3">
                            <div class="max-w-xs rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
                                {!! $user->twoFactorQrCodeSvg() !!}
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">使用认证器应用扫描二维码，然后在登录时输入 6 位验证码。</p>
                        </div>

                        <div class="space-y-2">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">恢复码</p>
                            <div class="grid gap-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-700 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-200">
                                @foreach ($user->recoveryCodes() as $recoveryCode)
                                    <code>{{ $recoveryCode }}</code>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <x-confirm-modal
                                name="refresh-two-factor-recovery-codes-modal"
                                title="确认刷新恢复码？"
                                message="刷新后旧恢复码将全部失效，请及时保存新的恢复码。"
                                :action="url('/user/two-factor-recovery-codes')"
                                trigger-label="刷新恢复码"
                                trigger-variant="filled"
                                confirm-label="确认刷新"
                                confirm-color="emerald"
                                confirm-variant="primary"
                            />

                            <x-confirm-modal
                                name="disable-two-factor-modal"
                                title="确认关闭双因素认证？"
                                message="关闭后登录将不再需要动态验证码。"
                                :action="url('/user/two-factor-authentication')"
                                method="DELETE"
                                trigger-label="关闭双因素认证"
                                trigger-variant="danger"
                                confirm-label="确认关闭"
                                confirm-variant="danger"
                            />
                        </div>
                    @else
                        <x-confirm-modal
                            name="enable-two-factor-modal"
                            title="确认启用双因素认证？"
                            message="启用后请保存恢复码，以防认证器不可用。"
                            :action="url('/user/two-factor-authentication')"
                            trigger-label="启用双因素认证"
                            trigger-variant="filled"
                            confirm-label="确认启用"
                            confirm-variant="primary"
                            confirm-color="emerald"
                        />
                    @endif
                </div>
            </div>

            <div class="border-t border-slate-100 px-6 py-5 dark:border-slate-800">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">创建时间</p>
                        <p class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                            {{ $user->created_at?->format('Y-m-d H:i') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">更新时间</p>
                        <p class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                            {{ $user->updated_at?->format('Y-m-d H:i') ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
