@extends('admin.default')
@section('title', __('admin_ui.profile.page_title'))
@section('content')
    <div class="flex min-h-[calc(100vh-200px)] items-start justify-center pt-10">
        <div class="w-full max-w-3xl">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="p-6">
                <form id="profile-update-form" method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <img
                                src="{{ $user->avatar }}"
                                alt="{{ __('admin_ui.profile.avatar_alt') }}"
                                class="h-14 w-14 rounded-full border border-slate-200 object-cover shadow-sm dark:border-slate-700"
                            >
                            <div>
                                <div class="text-lg font-semibold text-slate-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="space-y-2" x-data="{ selectedFileName: '{{ __('admin_ui.profile.avatar_upload_no_file') }}' }">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ __('admin_ui.profile.avatar_upload_label') }}</p>
                            <input
                                id="avatar"
                                type="file"
                                name="avatar"
                                accept="image/*"
                                aria-label="{{ __('admin_ui.profile.avatar_upload_label') }}"
                                class="hidden"
                                x-ref="avatarInput"
                                x-on:change="selectedFileName = $event.target.files.length ? $event.target.files[0].name : '{{ __('admin_ui.profile.avatar_upload_no_file') }}'"
                            >
                            <div class="flex flex-wrap items-center gap-3">
                                <flux:button type="button" size="sm" variant="filled" color="slate" x-on:click="$refs.avatarInput.click()">
                                    {{ __('admin_ui.profile.avatar_upload_button') }}
                                </flux:button>
                                <span class="text-xs text-slate-500 dark:text-slate-400" x-text="selectedFileName"></span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('admin_ui.profile.avatar_upload_hint') }}</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <flux:input
                            :label="__('admin_ui.profile.name_label')"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                        />
                        <flux:input
                            :label="__('admin_ui.profile.email_label')"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            required
                        />
                    </div>

                    <div class="flex justify-end">
                        <x-confirm-modal
                            name="confirm-profile-update-modal"
                            :title="__('admin_ui.profile.modals.update_profile.title')"
                            :message="__('admin_ui.profile.modals.update_profile.message')"
                            target-form-id="profile-update-form"
                            :trigger-label="__('admin_ui.profile.modals.update_profile.trigger')"
                            trigger-variant="filled"
                            trigger-color="slate"
                            :confirm-label="__('admin_ui.profile.modals.update_profile.confirm')"
                            confirm-variant="primary"
                            confirm-color="emerald"
                        />
                    </div>
                </form>
            </div>

            <div class="border-t border-slate-100 px-6 py-5 dark:border-slate-800">
                <form id="profile-home-profile-form" method="post" action="{{ route('admin.profile.home-profile') }}" class="space-y-4">
                    @csrf
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('admin_ui.profile.home_profile.title') }}</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('admin_ui.profile.home_profile.description') }}</p>
                    </div>

                    <flux:input
                        :label="__('admin_ui.profile.home_profile.title_label')"
                        name="home_profile_title"
                        value="{{ old('home_profile_title', $setting?->home_profile_title ?? $defaultHomeProfileTitle) }}"
                        required
                    />

                    <flux:textarea
                        name="home_profile_section"
                        :label="__('admin_ui.profile.home_profile.section_label')"
                        rows="4"
                        required
                    >{{ old('home_profile_section', $setting?->home_profile_section ?? $defaultHomeProfileSection) }}</flux:textarea>

                    @php
                        $homeProfileTagInput = old('home_profile_tags');
                        $initialHomeProfileTags = is_string($homeProfileTagInput)
                            ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $homeProfileTagInput) ?: [])))
                            : $homeProfileTags;
                    @endphp

                    <div
                        x-data="{
                            tags: @js($initialHomeProfileTags),
                            tagInput: '',
                            addTags(value) {
                                value.split(/[\n,]+/).map((tag) => tag.trim()).filter(Boolean).forEach((tag) => {
                                    if (!this.tags.includes(tag)) {
                                        this.tags.push(tag);
                                    }
                                });
                                this.tagInput = '';
                            },
                            removeTag(index) {
                                this.tags.splice(index, 1);
                            },
                        }"
                        class="space-y-2"
                    >
                        <label for="home-profile-tags-input" class="block text-sm font-medium text-slate-700 dark:text-slate-200">
                            {{ __('admin_ui.profile.home_profile.tags_label') }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" name="home_profile_tags" x-bind:value="tags.join('\n')" required>
                        <div
                            class="flex min-h-18 w-full flex-wrap items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm transition focus-within:border-slate-400 focus-within:ring-2 focus-within:ring-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:focus-within:border-slate-500 dark:focus-within:ring-slate-800"
                            data-home-profile-tags-editor
                            x-on:click="$refs.tagInput.focus()"
                        >
                            <template x-for="(tag, index) in tags" :key="tag">
                                <span class="inline-flex min-h-8 items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                                    <span x-text="tag"></span>
                                    <button
                                        type="button"
                                        class="inline-flex h-5 w-5 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-200 hover:text-slate-700 dark:hover:bg-slate-700 dark:hover:text-white"
                                        x-on:click.stop="removeTag(index)"
                                        :aria-label="'{{ __('admin_ui.profile.home_profile.remove_tag_label') }}'.replace(':tag', tag)"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </span>
                            </template>
                            <input
                                id="home-profile-tags-input"
                                type="text"
                                x-ref="tagInput"
                                x-model="tagInput"
                                x-on:keydown.enter.prevent="addTags(tagInput)"
                                x-on:keydown.comma.prevent="addTags(tagInput)"
                                x-on:paste.prevent="addTags($event.clipboardData.getData('text'))"
                                x-on:blur="addTags(tagInput)"
                                class="min-w-56 flex-1 border-0 bg-transparent p-0 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:ring-0 dark:text-white dark:placeholder:text-slate-500"
                                placeholder="{{ __('admin_ui.profile.home_profile.tags_placeholder') }}"
                            >
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('admin_ui.profile.home_profile.tags_hint') }}</p>

                    <div class="flex justify-end">
                        <x-confirm-modal
                            name="confirm-home-profile-update-modal"
                            :title="__('admin_ui.profile.modals.update_home_profile.title')"
                            :message="__('admin_ui.profile.modals.update_home_profile.message')"
                            target-form-id="profile-home-profile-form"
                            :trigger-label="__('admin_ui.profile.modals.update_home_profile.trigger')"
                            trigger-variant="filled"
                            trigger-color="slate"
                            :confirm-label="__('admin_ui.profile.modals.update_home_profile.confirm')"
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
                        :label="__('admin_ui.profile.current_password_label')"
                        name="current_password"
                        type="password"
                        autocomplete="current-password"
                        viewable
                        required
                    />
                    <flux:input
                        :label="__('admin_ui.profile.new_password_label')"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        viewable
                        required
                    />
                    <flux:input
                        :label="__('admin_ui.profile.new_password_confirmation_label')"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        viewable
                        required
                    />
                    <div class="flex items-end justify-end sm:justify-start">
                        <x-confirm-modal
                            name="confirm-password-update-modal"
                            :title="__('admin_ui.profile.modals.update_password.title')"
                            :message="__('admin_ui.profile.modals.update_password.message')"
                            target-form-id="profile-password-form"
                            :trigger-label="__('admin_ui.profile.modals.update_password.trigger')"
                            trigger-variant="filled"
                            :confirm-label="__('admin_ui.profile.modals.update_password.confirm')"
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
                            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('admin_ui.profile.two_factor.title') }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('admin_ui.profile.two_factor.description') }}</p>
                        </div>
                        @if ($user->two_factor_secret)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">{{ __('admin_ui.profile.two_factor.enabled') }}</span>
                        @else
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">{{ __('admin_ui.profile.two_factor.disabled') }}</span>
                        @endif
                    </div>

                    @if ($user->two_factor_secret)
                        <div class="space-y-3">
                            <div class="inline-block w-fit rounded-xl border border-slate-200 bg-white p-2 dark:border-slate-700 dark:bg-slate-900">
                                {!! $user->twoFactorQrCodeSvg() !!}
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('admin_ui.profile.two_factor.qr_tip') }}</p>
                        </div>

                        <div class="space-y-2">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ __('admin_ui.profile.two_factor.recovery_codes') }}</p>
                            <div class="grid gap-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-700 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-200">
                                @foreach ($user->recoveryCodes() as $recoveryCode)
                                    <code>{{ $recoveryCode }}</code>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <x-confirm-modal
                                name="refresh-two-factor-recovery-codes-modal"
                                :title="__('admin_ui.profile.modals.refresh_recovery_codes.title')"
                                :message="__('admin_ui.profile.modals.refresh_recovery_codes.message')"
                                :action="url('/user/two-factor-recovery-codes')"
                                :trigger-label="__('admin_ui.profile.modals.refresh_recovery_codes.trigger')"
                                trigger-variant="filled"
                                :confirm-label="__('admin_ui.profile.modals.refresh_recovery_codes.confirm')"
                                confirm-color="emerald"
                                confirm-variant="primary"
                            />

                            <x-confirm-modal
                                name="disable-two-factor-modal"
                                :title="__('admin_ui.profile.modals.disable_two_factor.title')"
                                :message="__('admin_ui.profile.modals.disable_two_factor.message')"
                                :action="url('/user/two-factor-authentication')"
                                method="DELETE"
                                :trigger-label="__('admin_ui.profile.modals.disable_two_factor.trigger')"
                                trigger-variant="danger"
                                :confirm-label="__('admin_ui.profile.modals.disable_two_factor.confirm')"
                                confirm-variant="danger"
                            />
                        </div>
                    @else
                        <x-confirm-modal
                            name="enable-two-factor-modal"
                            :title="__('admin_ui.profile.modals.enable_two_factor.title')"
                            :message="__('admin_ui.profile.modals.enable_two_factor.message')"
                            :action="url('/user/two-factor-authentication')"
                            :trigger-label="__('admin_ui.profile.modals.enable_two_factor.trigger')"
                            trigger-variant="filled"
                            :confirm-label="__('admin_ui.profile.modals.enable_two_factor.confirm')"
                            confirm-variant="primary"
                            confirm-color="emerald"
                        />
                    @endif
                </div>
            </div>

            <div class="border-t border-slate-100 px-6 py-5 dark:border-slate-800">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ __('admin_ui.profile.created_at_label') }}</p>
                        <p class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                            {{ $user->created_at?->format('Y-m-d H:i') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ __('admin_ui.profile.updated_at_label') }}</p>
                        <p class="mt-2 text-sm font-medium text-slate-900 dark:text-white">
                            {{ $user->updated_at?->format('Y-m-d H:i') ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
