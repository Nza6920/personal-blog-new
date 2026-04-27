<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalSetting extends Model
{
    protected $fillable = ['home_bio', 'home_avatar'];

    public static function defaultBio(): string
    {
        return 'Stay hungry, Stay foolish.';
    }

    public static function defaultAvatar(): string
    {
        return asset('uploads/images/system/avatar.jpg');
    }
}
