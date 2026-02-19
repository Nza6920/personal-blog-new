@extends('admin.default')

@section('title', __('admin_ui.portal.page_title'))

@section('content')
    <div class="flex min-h-[calc(100vh-200px)] items-start justify-center pt-10">
        <div class="w-full max-w-3xl">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ __('admin_ui.portal.heading') }}</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('admin_ui.portal.subheading') }}</p>
                        </div>
                        <flux:button href="{{ route('admin.show') }}" size="sm">
                            {{ __('admin_ui.portal.back_list') }}
                        </flux:button>
                    </div>

                    <form id="portal-update-form" method="post" action="{{ route('admin.portal.update') }}" class="mt-6 space-y-6">
                        @csrf
                        <flux:input
                            name="home_bio"
                            :label="__('admin_ui.portal.bio_label')"
                            :placeholder="__('admin_ui.portal.bio_placeholder')"
                            value="{{ old('home_bio', $setting?->home_bio ?? $defaultBio) }}"
                            required
                        />
                        @if($bioHistory->isNotEmpty())
                            <div
                                class="flex flex-wrap items-center gap-2"
                                x-data="{
                                    copied: false,
                                    copy(value) {
                                        if (!navigator.clipboard) {
                                            return;
                                        }
                                        navigator.clipboard.writeText(value).then(() => {
                                            this.copied = true;
                                            setTimeout(() => { this.copied = false; }, 1500);
                                        });
                                    }
                                }"
                            >
                                @foreach($bioHistory as $bio)
                                    <button
                                        type="button"
                                        class="inline-flex cursor-pointer items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600 transition hover:border-slate-300 hover:bg-white dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-800"
                                        x-on:click="copy($el.dataset.bio)"
                                        data-bio="{{ $bio }}"
                                        title="{{ __('admin_ui.portal.copy_hint') }}"
                                        aria-label="{{ __('admin_ui.portal.copy_hint') }}"
                                    >
                                        {{ $bio }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('admin_ui.portal.bio_hint') }}</p>

                        <div class="flex items-center justify-end">
                            <x-confirm-modal
                                name="confirm-portal-update-modal"
                                :title="__('admin_ui.portal.modal.title')"
                                :message="__('admin_ui.portal.modal.message')"
                                target-form-id="portal-update-form"
                                :trigger-label="__('admin_ui.portal.save')"
                                trigger-variant="filled"
                                trigger-color="slate"
                                :confirm-label="__('admin_ui.portal.modal.confirm')"
                                confirm-variant="primary"
                                confirm-color="emerald"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
