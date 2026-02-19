<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalSetting extends Model
{
    protected $fillable = ['home_bio'];

    public static function defaultBio(): string
    {
        return 'Stay hungry, Stay foolish.';
    }
}
