@extends('admin.default')
@section('title', '所有文章')
@section('content')
    <div class="grid mt-6 gap-6 lg:grid-cols-[minmax(0,1fr)_280px] lg:items-start">
        <section class="space-y-6">
            <div
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                @include('admin._topic_list', ['topics' => $topics])
            </div>

            <div class="flex justify-center">
                {!! $topics->appends(Request::except('page'))->links() !!}
            </div>
        </section>

        <div class="space-y-6 self-start">
            @include('admin._sidebar')
        </div>
    </div>
@endsection
