<?php

namespace App\Actions\Topics;

use App\Models\Topic;

class UnpublishTopic
{
    public function handle(Topic $topic): Topic
    {
        $topic->is_published = false;
        $topic->save();

        return $topic;
    }
}
