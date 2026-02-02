@extends('admin.default')

@section('content')
<div class="mx-auto max-w-3xl mt-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">
                        @if($topic->id)
                            编辑话题
                        @else
                            新建话题
                        @endif
                    </h2>
                </div>
                <flux:button href="{{ route('admin.show') }}" size="sm">
                    返回列表
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
                                    label="标题"
                                    placeholder="请填写标题"
                                    value="{{ old('title', $topic->title ) }}"
                                    required
                                />

                                <flux:textarea
                                    id="editor"
                                    name="body"
                                    label="内容"
                                    rows="10"
                                    placeholder="请输入至少三个字符的内容。"
                                    required
                                >{{ old('body', $topic->body ) }}</flux:textarea>

                                <flux:select name="body_type" id="body_type" label="文本类型">
                                    <option
                                        value="MARKDOWN" @selected(old('body_type', $topic->body_type ?? 'MARKDOWN') === 'MARKDOWN')>
                                        MARKDOWN
                                    </option>
                                    <option
                                        value="HTML" @selected(old('body_type', $topic->body_type ?? 'MARKDOWN') === 'HTML')>
                                        HTML
                                    </option>
                                </flux:select>

                                <div class="space-y-2">
                                    <label for="background"
                                           class="text-sm font-medium text-slate-700 dark:text-slate-200">背景图片</label>
                                    <input id="background" type="file" name="background"
                                           class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-700 dark:text-slate-300 dark:file:bg-white dark:file:text-slate-900 dark:hover:file:bg-slate-200">
                                    @if($topic->background)
                                        <img
                                            class="h-32 rounded-xl border border-slate-200 object-cover shadow-sm dark:border-slate-800"
                                            src="{{ $topic->background }}" alt="背景预览">
                                    @endif
                                </div>

                                <div class="flex items-center justify-end gap-3">
                                    <flux:button type="submit" variant="primary" color="slate">
                                        保存
                                    </flux:button>
                                </div>
                            </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/easymde/easymde.min.css') }}">
    <style>
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
            var editorElement = document.getElementById('editor');

            if (!editorElement) {
                return;
            }

        var easyMde = new EasyMDE({
            element: editorElement,
            forceSync: true,
            theme: document.documentElement.classList.contains('dark') ? 'easymde-dark' : 'easymde',
            imageUploadFunction: function (file, onSuccess, onError) {
                    var formData = new FormData();
                    formData.append('upload_file', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('admin.upload_image') }}', {
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
                                onError((data && data.msg) ? data.msg : 'Image upload failed.');
                            }
                        })
                        .catch(function () {
                            onError('Image upload failed.');
                        });
                }
            });

        var applyEditorTheme = function () {
            var container = easyMde.codemirror.getWrapperElement().closest('.EasyMDEContainer');
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

            applyEditorTheme();

            var observer = new MutationObserver(applyEditorTheme);
            observer.observe(document.documentElement, {attributes: true, attributeFilter: ['class']});
        });
    </script>
@stop
