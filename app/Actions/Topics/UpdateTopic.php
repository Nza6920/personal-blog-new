<?php

namespace App\Actions\Topics;

use App\Handlers\ImageUploadHandler;
use App\Models\Topic;
use Illuminate\Http\UploadedFile;

class UpdateTopic
{
    public function handle(Topic $topic, array $data, ?UploadedFile $background, ImageUploadHandler $uploader): Topic
    {
        $topic->fill($data);
        $topic->body_type = $topic->body_type ?: 'HTML';

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
