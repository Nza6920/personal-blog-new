<?php

namespace App\Actions\Portal;

use App\Models\PortalBioHistory;
use App\Models\PortalSetting;

class UpdatePortalBio
{
    public function handle(string $bio): PortalSetting
    {
        $setting = PortalSetting::query()->first();

        $previousBio = $setting?->home_bio;

        if (! $setting) {
            $setting = new PortalSetting();
        }

        $setting->home_bio = $bio;
        $setting->save();

        if ($previousBio && $previousBio !== $bio) {
            PortalBioHistory::query()->create([
                'bio' => $previousBio,
            ]);
        }

        return $setting;
    }
}
