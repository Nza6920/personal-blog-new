<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function show(Topic $topic)
    {

        $behindId = Topic::where('id', '<', $topic->id)->max('id');
        $behind = Topic::find($behindId);

        $nextId = Topic::where('id', '>', $topic->id)->min('id');
        $next = Topic::find($nextId);

        return view('topics.index', ['topic' => $topic, 'next' => $next, 'behind' => $behind]);
    }
}
