@extends('admin.default')
@section('title', '所有文章')
@section('content')
<div class="row">
    <div class="col-lg-9 col-md-9 topic-list">
        <div class="panel panel-default">
            <div class="panel-body">
                {{-- 话题列表 --}}
                @include('admin._topic_list', ['topics' => $topics])
                {{-- 分页 --}}
                {!! $topics->appends(Request::except('page'))->render() !!}
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 sidebar">
        @include('admin._sidebar')
    </div>
</div>

@endsection
