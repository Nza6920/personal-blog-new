<header class="fixed inset-x-0 top-0 z-50 w-full border-b border-slate-200/70 bg-white/80 backdrop-blur dark:border-slate-800 dark:bg-slate-900/70">
    <div class="mx-auto w-full max-w-6xl px-6 py-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <a class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white" href="{{ route('admin.show') }}">
                博客后台
            </a>

            <div class="flex flex-wrap items-center gap-3">
                <div class="hidden items-center sm:flex">
                    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                        <flux:radio value="light" icon="sun" />
                        <flux:radio value="dark" icon="moon" />
                        <flux:radio value="system" icon="computer-desktop" />
                    </flux:radio.group>
                </div>
                <div class="flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs leading-none text-slate-700 shadow-xs dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-2">
                        <img src="{{ Auth::user()->avatar }}" class="h-7 w-7 rounded-md border border-slate-200 object-cover dark:border-slate-700" alt="用户头像">
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                    </a>
                    <form action="{{ route('logout') }}" method="post">
                        @method('DELETE')
                        @csrf
                        <flux:button type="submit" variant="ghost" size="sm">
                            退出
                        </flux:button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>



