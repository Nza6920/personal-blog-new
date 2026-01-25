@if (Session::has('message'))
    <div class="mb-4 flex items-start justify-between gap-4 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-900 shadow-sm dark:border-blue-900/40 dark:bg-blue-950/40 dark:text-blue-100">
        <span>{{ Session::get('message') }}</span>
        <button type="button" class="text-blue-400 transition hover:text-blue-600 dark:text-blue-200 dark:hover:text-white" onclick="this.closest('div').remove()" aria-label="关闭">
            ×
        </button>
    </div>
@endif

@if (Session::has('success'))
    <div class="mb-4 flex items-start justify-between gap-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-100">
        <span>{{ Session::get('success') }}</span>
        <button type="button" class="text-emerald-400 transition hover:text-emerald-600 dark:text-emerald-200 dark:hover:text-white" onclick="this.closest('div').remove()" aria-label="关闭">
            ×
        </button>
    </div>
@endif

@if (Session::has('danger'))
    <div class="mb-4 flex items-start justify-between gap-4 rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-900 shadow-sm dark:border-rose-900/40 dark:bg-rose-950/40 dark:text-rose-100">
        <span>{{ Session::get('danger') }}</span>
        <button type="button" class="text-rose-400 transition hover:text-rose-600 dark:text-rose-200 dark:hover:text-white" onclick="this.closest('div').remove()" aria-label="关闭">
            ×
        </button>
    </div>
@endif
