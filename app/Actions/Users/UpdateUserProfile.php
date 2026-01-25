<?php

namespace App\Actions\Users;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class UpdateUserProfile
{
    public function handle(User $user, array $data, ?UploadedFile $avatar, ImageUploadHandler $uploader): User
    {
        $user->fill($data);

        if ($avatar && $avatar->isValid()) {
            $result = $uploader->save($avatar, 'avatars', $user->id);
            if ($result) {
                $user->avatar = $result['path'];
            }
        }

        $user->save();

        return $user;
    }
}
