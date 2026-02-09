@extends('admin.default')

@section('title', $topic->id ? __('admin_ui.editor.edit_topic') : __('admin_ui.editor.new_topic'))

@section('content')
<div class="mx-auto max-w-3xl mt-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                        @if($topic->id)
                            {{ __('admin_ui.editor.edit_topic') }}
                        @else
                            {{ __('admin_ui.editor.new_topic') }}
                        @endif
                    </h2>
                </div>
                <flux:button href="{{ route('admin.show') }}" size="sm">
                    {{ __('admin_ui.editor.back_list') }}
                </flux:button>
            </div>

            <div class="mt-6">
                @include('error.error')

                @if($topic->id)
                    <form action="{{ route('admin.topics.update', $topic->id)}}" method="post" accept-charset="UTF-8"
                          enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="_method" value="put">
                        @else
                            <form action="{{ route('admin.store' )}}" method="post" accept-charset="UTF-8"
                                  enctype="multipart/form-data" class="space-y-6">
                                @endif

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <flux:input
                                    id="title"
                                    name="title"
                                    :label="__('admin_ui.editor.title_label')"
                                    :placeholder="__('admin_ui.editor.title_placeholder')"
                                    value="{{ old('title', $topic->title ) }}"
                                    required
                                />

                                <flux:textarea
                                    id="editor"
                                    name="body"
                                    :label="__('admin_ui.editor.body_label')"
                                    rows="10"
                                    :placeholder="__('admin_ui.editor.body_placeholder')"
                                    required
                                >{{ old('body', $topic->body ) }}</flux:textarea>

                                <flux:select name="body_type" id="body_type" :label="__('admin_ui.editor.body_type_label')">
                                    <option
                                        value="MARKDOWN" @selected(old('body_type', $topic->body_type ?? 'MARKDOWN') === 'MARKDOWN')>
                                        {{ __('admin_ui.editor.body_type_markdown') }}
                                    </option>
                                    <option
                                        value="HTML" @selected(old('body_type', $topic->body_type ?? 'MARKDOWN') === 'HTML')>
                                        {{ __('admin_ui.editor.body_type_html') }}
                                    </option>
                                </flux:select>

                                <div class="space-y-2" x-data="{ selectedBackgroundName: '{{ __('admin_ui.editor.background_upload_no_file') }}' }">
                                    <label for="background"
                                           class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ __('admin_ui.editor.background_label') }}</label>
                                    <input
                                        id="background"
                                        type="file"
                                        name="background"
                                        class="hidden"
                                        x-ref="backgroundInput"
                                        aria-label="{{ __('admin_ui.editor.background_label') }}"
                                        x-on:change="selectedBackgroundName = $event.target.files.length ? $event.target.files[0].name : '{{ __('admin_ui.editor.background_upload_no_file') }}'"
                                    >
                                    <div class="flex flex-wrap items-center gap-3">
                                        <flux:button type="button" size="sm" variant="filled" color="slate" x-on:click="$refs.backgroundInput.click()">
                                            {{ __('admin_ui.editor.background_upload_button') }}
                                        </flux:button>
                                        <span class="text-xs text-slate-500 dark:text-slate-400" x-text="selectedBackgroundName"></span>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('admin_ui.editor.background_upload_hint') }}</p>
                                    @if($topic->background)
                                        <img
                                            class="h-32 rounded-xl border border-slate-200 object-cover shadow-sm dark:border-slate-800"
                                            src="{{ $topic->background }}" alt="{{ __('admin_ui.editor.background_preview_alt') }}">
                                    @endif
                                </div>

                                <div class="flex items-center justify-end gap-3">
                                    <flux:button type="submit" variant="primary" color="slate">
                                        {{ __('admin_ui.editor.save') }}
                                    </flux:button>
                                </div>
                            </form>
            </div>
        </div>
    </div>

    <button
        type="button"
        aria-label="{{ __('admin_ui.editor.back_to_top_aria') }}"
        title="{{ __('admin_ui.editor.back_to_top') }}"
        class="fixed bottom-6 right-6 z-40 inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white/95 text-slate-700 shadow-lg backdrop-blur transition hover:-translate-y-0.5 hover:bg-white hover:text-slate-900 dark:border-slate-700 dark:bg-slate-900/95 dark:text-slate-200 dark:hover:bg-slate-900 dark:hover:text-white"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    >
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10.53 3.22a.75.75 0 0 0-1.06 0l-5 5a.75.75 0 1 0 1.06 1.06L9.25 5.56V16a.75.75 0 0 0 1.5 0V5.56l3.72 3.72a.75.75 0 1 0 1.06-1.06l-5-5Z" clip-rule="evenodd" />
        </svg>
    </button>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/easymde/easymde.min.css') }}">
    <style>
        .EasyMDEContainer .editor-toolbar {
            position: -webkit-sticky;
            position: sticky;
            top: var(--editor-toolbar-offset, 0px);
            z-index: 40;
            background-color: #ffffff;
        }

        .EasyMDEContainer .editor-toolbar.fullscreen {
            position: fixed;
            top: 0;
            z-index: 70;
        }

        .EasyMDEContainer .CodeMirror-fullscreen,
        .EasyMDEContainer .editor-preview-side {
            z-index: 69;
        }

        .easymde-dark .editor-toolbar {
            background-color: #0f172a;
            border-color: #1f2937;
        }

        .easymde-dark .editor-toolbar a {
            color: #e2e8f0;
        }

        .easymde-dark .editor-toolbar a:hover,
        .easymde-dark .editor-toolbar a.active {
            background-color: #1e293b;
            color: #ffffff;
        }

        .easymde-dark .CodeMirror,
        .easymde-dark .CodeMirror-scroll {
            background-color: #0b1220;
            color: #e2e8f0;
        }

        .easymde-dark .CodeMirror-cursor {
            border-left: 1px solid #e2e8f0;
        }

        .easymde-dark .editor-statusbar {
            background-color: #0f172a;
            border-color: #1f2937;
            color: #94a3b8;
        }

        .easymde-dark .editor-preview,
        .easymde-dark .editor-preview-side {
            background-color: #0b1220;
            color: #e2e8f0;
        }
    </style>
@stop

@section('scripts')
    <script src="{{ asset('vendor/easymde/easymde.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editorElement = document.getElementById('editor');

            if (!editorElement) {
                return;
            }

        const easyMde = new EasyMDE({
            element: editorElement,
            forceSync: true,
            theme: document.documentElement.classList.contains('dark') ? 'easymde-dark' : 'easymde',
            imageUploadFunction: function (file, onSuccess, onError) {
                    const formData = new FormData();
                    formData.append('upload_file', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch("{{ route('admin.upload_image') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(function (response) {
                            return response.json();
                        })
                        .then(function (data) {
                            if (data && data.success && data.file_path) {
                                onSuccess(data.file_path);
                            } else {
                                onError((data && data.msg) ? data.msg : "{{ __('admin_ui.editor.image_upload_failed') }}");
                            }
                        })
                        .catch(function () {
                            onError("{{ __('admin_ui.editor.image_upload_failed') }}");
                        });
                }
            });

        const applyEditorTheme = function () {
            const container = easyMde.codemirror.getWrapperElement().closest('.EasyMDEContainer');
            if (!container) {
                return;
            }
            if (document.documentElement.classList.contains('dark')) {
                container.classList.add('easymde-dark');
                easyMde.codemirror.setOption('theme', 'easymde-dark');
            } else {
                container.classList.remove('easymde-dark');
                easyMde.codemirror.setOption('theme', 'easymde');
            }
        };

        const setToolbarOffset = function () {
            const container = easyMde.codemirror.getWrapperElement().closest('.EasyMDEContainer');
            if (!container) {
                return;
            }

            const header = document.querySelector('header');
            const offset = header ? Math.ceil(header.getBoundingClientRect().height) + 8 : 8;
            container.style.setProperty('--editor-toolbar-offset', offset + 'px');
        };

            applyEditorTheme();
            setToolbarOffset();

            const observer = new MutationObserver(applyEditorTheme);
            observer.observe(document.documentElement, {attributes: true, attributeFilter: ['class']});
            window.addEventListener('resize', setToolbarOffset);
        });
    </script>
@stop
