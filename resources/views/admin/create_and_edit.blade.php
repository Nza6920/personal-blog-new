@extends('admin.default')

@section('content')

<div class="container" style="position: relative; left: -120px;">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    @if($topic->id)
                        编辑话题
                    @else
                        新建话题
                    @endif
                </h2>

                <hr>

                @include('error.error')

                @if($topic->id)
                    <form action="{{ route('admin.update', $topic->id)}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="put">
                @else
                    <form action="{{ route('admin.store' )}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required/>
                    </div>

                    <div class="form-group">
                        <textarea name="body" class="form-control" id="editor" rows="3" placeholder="请填入至少三个字符的内容。" required>{{ old('body', $topic->body ) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="body_type">文本类型</label>
                        <select name="body_type" id="body_type" class="form-control">
                            <option value="HTML" @selected(old('body_type', $topic->body_type ?? 'HTML') === 'HTML')>HTML</option>
                            <option value="MARKDOWN" @selected(old('body_type', $topic->body_type) === 'MARKDOWN')>MARKDOWN</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="avatar-label">背景图片</label>
                        <input type="file" name="background">
                        @if($topic->background)
                            <br>
                            <img class="thumbnail img-responsive" src="{{ $topic->background }}" width="200" />
                        @endif
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

    <script>
    $(document).ready(function(){
        new EasyMDE({
            element: document.getElementById('editor'),
            forceSync: true,
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
                    .then(function (response) { return response.json(); })
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
    });
    </script>

@stop
