<?php

namespace App\Actions\Topics;

use App\Handlers\ImageUploadHandler;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class CreateTopic
{
    public function handle(User $user, array $data, ?UploadedFile $background, ImageUploadHandler $uploader): Topic
    {
        $topic = new Topic;
        $topic->fill($data);
        $topic->body_type = $topic->body_type ?: 'HTML';
        $topic->is_published = false;
        $topic->user_id = $user->id;

        if ($background && $background->isValid()) {
            $result = $uploader->save($background, 'background', $topic->id);
            if ($result) {
                $topic->background = $result['path'];
            }
        }

        $topic->save();

        return $topic;
    }
}
