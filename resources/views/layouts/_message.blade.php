@php
    $showSession = $showSession ?? true;
    $showErrors = $showErrors ?? true;
@endphp

@if ($showErrors && $errors->any())
    <div class="mb-4 mt-3 flex items-start justify-between gap-4 rounded-2xl border border-[#da7060] bg-[#da7060] px-4 py-3.5 text-[15px] font-medium leading-6 text-rose-950 shadow-sm ring-1 ring-rose-100/70 dark:border-[#da7060] dark:bg-[#da7060] dark:text-rose-950 dark:ring-rose-900/40">
        <ul class="list-disc space-y-1.5 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-md text-current transition hover:bg-black/10 hover:text-current dark:hover:bg-white/10" onclick="this.closest('div').remove()" aria-label="{{ __('admin_ui.common.close') }}">
            ×
        </button>
    </div>
@endif

@if ($showSession && Session::has('message'))
    <div class="mb-4 mt-3 flex items-start justify-between gap-4 rounded-2xl border border-[#d79e47] bg-[#d79e47] px-4 py-3.5 text-[15px] font-semibold leading-6 text-blue-950 shadow-sm ring-1 ring-blue-100/70 dark:border-[#d79e47] dark:bg-[#d79e47] dark:text-blue-950 dark:ring-blue-900/40">
        <span>{{ Session::get('message') }}</span>
        <button type="button" class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-md text-current transition hover:bg-black/10 hover:text-current dark:hover:bg-white/10" onclick="this.closest('div').remove()" aria-label="{{ __('admin_ui.common.close') }}">
            ×
        </button>
    </div>
@endif

@if ($showSession && Session::has('success'))
    <div class="mb-4 mt-3 flex items-start justify-between gap-4 rounded-2xl border border-[#5bab3f] bg-[#5bab3f] px-4 py-3.5 text-[15px] font-semibold leading-6 text-emerald-950 shadow-sm ring-1 ring-emerald-100/70 dark:border-[#5bab3f] dark:bg-[#5bab3f] dark:text-emerald-950 dark:ring-emerald-900/40">
        <span>{{ Session::get('success') }}</span>
        <button type="button" class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-md text-current transition hover:bg-black/10 hover:text-current dark:hover:bg-white/10" onclick="this.closest('div').remove()" aria-label="{{ __('admin_ui.common.close') }}">
            ×
        </button>
    </div>
@endif

@if ($showSession && Session::has('danger'))
    <div class="mb-4 mt-3 flex items-start justify-between gap-4 rounded-2xl border border-[#da7060] bg-[#da7060] px-4 py-3.5 text-[15px] font-semibold leading-6 text-rose-950 shadow-sm ring-1 ring-rose-100/70 dark:border-[#da7060] dark:bg-[#da7060] dark:text-rose-950 dark:ring-rose-900/40">
        <span>{{ Session::get('danger') }}</span>
        <button type="button" class="mt-0.5 inline-flex h-7 w-7 items-center justify-center rounded-md text-current transition hover:bg-black/10 hover:text-current dark:hover:bg-white/10" onclick="this.closest('div').remove()" aria-label="{{ __('admin_ui.common.close') }}">
            ×
        </button>
    </div>
@endif
