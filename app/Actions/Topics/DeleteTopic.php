<?php

namespace App\Actions\Topics;

use App\Models\Topic;

class DeleteTopic
{
    public function handle(Topic $topic): void
    {
        $topic->delete();
    }
}
