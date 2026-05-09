<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalSetting extends Model
{
    protected $fillable = [
        'home_bio',
        'home_avatar',
        'home_profile_title',
        'home_profile_section',
        'home_profile_tags',
    ];

    protected function casts(): array
    {
        return [
            'home_profile_tags' => 'array',
        ];
    }

    public static function defaultBio(): string
    {
        return 'Stay hungry, Stay foolish.';
    }

    public static function defaultAvatar(): string
    {
        return asset('uploads/images/system/avatar.jpg');
    }

    public static function defaultProfileTitle(): string
    {
        return __('home.profile.title');
    }

    public static function defaultProfileSection(): string
    {
        return __('home.profile.description');
    }

    /**
     * @return array<int, string>
     */
    public static function defaultProfileTags(): array
    {
        $tags = __('home.tech_stack.items');

        return is_array($tags) ? $tags : [];
    }
}
