<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function show(Request $request, Topic $topic)
    {
        if (!$request->routeIs('admin.topics.show')) {
            abort_unless($topic->is_published, 404);
        }

        $navigationTopics = Topic::query();

        if (!$request->routeIs('admin.topics.show')) {
            $navigationTopics->published();
        }

        $behindId = (clone $navigationTopics)->where('id', '<', $topic->id)->max('id');
        $behind = Topic::find($behindId);

        $nextId = (clone $navigationTopics)->where('id', '>', $topic->id)->min('id');
        $next = Topic::find($nextId);

        return view('topics.index', ['topic' => $topic, 'next' => $next, 'behind' => $behind]);
    }
}
