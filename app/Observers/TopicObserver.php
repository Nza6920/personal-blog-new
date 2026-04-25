<?php

namespace App\Observers;

use App\Actions\Topics\CalculateEstimatedReadTime;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic): void
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
        $topic->estimated_read_time = app(CalculateEstimatedReadTime::class)
            ->handle($topic->body, $topic->body_type);
    }
}
