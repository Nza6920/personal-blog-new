<footer class="border-t border-slate-200/70 bg-white/70 dark:border-slate-800 dark:bg-slate-900/70">
    <div class="mx-auto flex w-full max-w-6xl flex-col items-start justify-between gap-4 px-6 py-6 text-sm text-slate-500 sm:flex-row sm:items-center">
        <div class="flex items-center gap-3">
            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('uploads/images/system/footer.png') }}" alt="站点图标">
            <a href="https://github.com/Nza6920" class="text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                不积跬步，无以至千里
            </a>
        </div>

        <a href="{{ route('home.show') }}" class="text-slate-600 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
            返回主站
        </a>
    </div>
</footer>
