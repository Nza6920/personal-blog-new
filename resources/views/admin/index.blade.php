@extends('admin.default')
@section('title', '所有文章')
@section('content')
    <div class="grid mt-6 gap-6 lg:grid-cols-[minmax(0,1fr)_280px] lg:items-start">
        <section class="space-y-6">
            <div
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="lg:sticky lg:top-24 z-10 -mx-6 pb-6 bg-white dark:bg-slate-900">
                    <form method="get" action="{{ route('admin.show') }}" class="w-full pb-6">
                        <flux:input
                            id="admin-search"
                            class="w-full"
                            name="search"
                            value="{{ $search }}"
                            kbd="⌘K/Ctrl+K"
                            icon="magnifying-glass"
                            placeholder="Search..."
                        />
                    </form>
                </div>

                @include('admin._topic_list', ['topics' => $topics])
            </div>

            <div class="flex justify-center">
                {!! $topics->appends(Request::except('page'))->links() !!}
            </div>
        </section>

        <div class="space-y-6 self-start lg:self-stretch">
            @include('admin._sidebar')
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('keydown', function (event) {
            var isShortcut = (event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k';
            if (!isShortcut) {
                return;
            }

            var searchInput = document.getElementById('admin-search');
            if (!searchInput) {
                return;
            }

            event.preventDefault();
            searchInput.focus();
            searchInput.select();
        });

        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('admin-search');
            if (!searchInput) {
                return;
            }

            var platform = (navigator.userAgentData && navigator.userAgentData.platform) || navigator.platform || '';
            var isMac = /Mac|iPhone|iPad|iPod/.test(platform);
            var kbdLabel = searchInput.closest('[data-flux-input]')?.querySelector('span.pointer-events-none');

            if (!kbdLabel) {
                return;
            }

            kbdLabel.textContent = isMac ? '⌘K' : 'Ctrl+K';
        });
    </script>
@endsection
