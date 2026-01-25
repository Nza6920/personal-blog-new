@extends('admin.default')
@section('title', '个人资料')
@section('content')
    <div class="flex min-h-[calc(100vh-200px)] items-center justify-center">
        <div class="w-full max-w-3xl rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @include('error.error')
            <div class="p-6">
                <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
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
                        <flux:button size="sm" variant="filled" color="slate" type="submit">
                            保存资料
                        </flux:button>
                    </div>
                </form>
            </div>

            <div class="border-t border-slate-100 px-6 py-5 dark:border-slate-800">
                <form method="post" action="{{ route('admin.profile.password') }}" class="grid gap-4 sm:grid-cols-2">
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
                        <flux:button size="sm" variant="filled" type="submit">
                            修改密码
                        </flux:button>
                    </div>
                </form>
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
