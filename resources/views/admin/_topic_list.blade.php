@if (count($topics))
    <ul class="media-list">
        @foreach ($topics as $topic)
            <li class="media">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object img-thumbnail" style="width: 82px; height: 82px;" src="{{ $user->avatar }}" title="{{ $user->name }}">
                    </a>
                </div>
                <div class="media-body">
                    <div class="media-heading">
                        <a href="{{ route('topics.show', $topic) }}" title="{{ $topic->title }}" style="color:black">
                            {{ $topic->title }}
                        </a>
                    </div>
                    <div class="media-body meta">
                        <a href="#" title="作者" style="color:rgb(102, 102, 102);">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            {{ $topic->user->name }}
                        </a>
                        <span> • </span>
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span class="timeago" title="最后活跃于">{{ $topic->created_at->diffForHumans() }}</span>
                        <form id="delete_form" action="{{ route('admin.destroy', $topic->id)}}" method="post">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
                        </form>
                        <a href="{{ route('admin.edit', $topic->id) }}"><button class="btn btn-primary pull-right">编辑</button></a>
                    </div>
                </div>
            </li>
            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </ul>
@else
   <div class="empty-block">暂无数据 ~_~ </div>
@endif
