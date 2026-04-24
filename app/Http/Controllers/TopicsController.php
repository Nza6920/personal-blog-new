<?php

namespace App\Http\Controllers;

use App\Actions\Topics\BuildTopicTableOfContents;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function show(Request $request, Topic $topic, BuildTopicTableOfContents $buildTopicTableOfContents)
    {
        if (! $request->routeIs('admin.topics.show')) {
            abort_unless($topic->is_published, 404);
        }

        $navigationTopics = Topic::query();

        if (! $request->routeIs('admin.topics.show')) {
            $navigationTopics->published();
        }

        $behind = (clone $navigationTopics)
            ->where(function (Builder $query) use ($topic) {
                $query->where('created_at', '<', $topic->created_at)
                    ->orWhere(function (Builder $query) use ($topic) {
                        $query->where('created_at', $topic->created_at)
                            ->where('id', '<', $topic->id);
                    });
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        $next = (clone $navigationTopics)
            ->where(function (Builder $query) use ($topic) {
                $query->where('created_at', '>', $topic->created_at)
                    ->orWhere(function (Builder $query) use ($topic) {
                        $query->where('created_at', $topic->created_at)
                            ->where('id', '>', $topic->id);
                    });
            })
            ->orderBy('created_at')
            ->orderBy('id')
            ->first();

        $topicContent = $buildTopicTableOfContents->handle($topic);

        return view('topics.index', [
            'topic' => $topic,
            'next' => $next,
            'behind' => $behind,
            'topicBodyHtml' => $topicContent['bodyHtml'],
            'topicToc' => $topicContent['items'],
        ]);
    }
}
