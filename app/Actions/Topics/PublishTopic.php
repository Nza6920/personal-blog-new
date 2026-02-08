<?php

namespace App\Actions\Topics;

use App\Models\Topic;

class PublishTopic
{
    public function handle(Topic $topic): Topic
    {
        $topic->is_published = true;
        $topic->save();

        return $topic;
    }
}
