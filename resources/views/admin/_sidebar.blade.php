<aside class="mt-0 space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:sticky lg:top-24">
    <div class="space-y-1">
        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">管理工具</p>
    </div>

    <flux:button href="{{ route('admin.create') }}" variant="primary" color="slate" class="w-full">
        新建文章
    </flux:button>

    <flux:button href="{{ route('admin.logs.index') }}" variant="primary" color="slate" class="w-full">
        日志查看
    </flux:button>

    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4 text-xs text-slate-500 dark:border-slate-700 dark:bg-slate-950/40 dark:text-slate-400">
        这里可以放草稿、快捷入口或统计信息。
    </div>
</aside>
