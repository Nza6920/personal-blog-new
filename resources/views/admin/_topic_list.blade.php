@if (count($topics))
    <div class="space-y-4">
        @foreach ($topics as $topic)
            <article
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                    <img class="h-16 w-16 rounded-xl object-cover ring-1 ring-slate-200 dark:ring-slate-700"
                         src="{{ $topic->user->avatar }}" alt="{{ $topic->user->name }}">
                    <div class="flex-1 space-y-3">
                        <a href="{{ route('admin.topics.show', $topic) }}"
                           class="text-lg font-semibold text-slate-900 transition hover:text-slate-700 dark:text-white dark:hover:text-slate-200">
                            {{ $topic->title }}
                        </a>

                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-slate-400 dark:bg-slate-500"></span>
                                {{ $topic->user->name }}
                            </span>
                            <span class="text-slate-300 dark:text-slate-600">|</span>
                            <span>{{ $topic->created_at->diffForHumans() }}</span>
                            <span class="text-slate-300 dark:text-slate-600">|</span>
                            @if ($topic->is_published)
                                <span class="text-emerald-600 dark:text-emerald-400">
                                    已发布
                                </span>
                            @else
                                <span class="text-red-600 dark:text-red-400">
                                    未发布
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <form action="{{ route('admin.topics.publish', $topic->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <flux:button type="submit" variant="outline" size="sm">
                                    {{ $topic->is_published ? '取消发布' : '发布' }}
                                </flux:button>
                            </form>
                            <flux:button href="{{ route('admin.topics.edit', $topic->id) }}" variant="outline"
                                         size="sm">
                                编辑
                            </flux:button>
                            <x-confirm-modal
                                :name="'delete-topic-'.$topic->id"
                                title="确认删除这篇文章？"
                                message="删除后无法恢复，请谨慎操作。"
                                :action="route('admin.topics.destroy', $topic->id)"
                                method="DELETE"
                                trigger-label="删除"
                                trigger-variant="danger"
                                confirm-label="删除"
                                confirm-variant="danger"
                            />
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@else
    <div
        class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-950/40 dark:text-slate-400">
        暂无数据 ~_~
    </div>
@endif
