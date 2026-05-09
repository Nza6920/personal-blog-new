<?php

namespace App\Http\Controllers;

use App\Models\PortalSetting;
use App\Models\Topic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(Request $request)
    {
        $search = trim((string) $request->input('keyword', ''));
        $topicsQuery = Topic::query()
            ->published()
            ->with(['user'])
            ->latest('created_at');

        if ($search !== '') {
            $topicsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $topics = $topicsQuery->paginate(6)->appends([
            'keyword' => $search,
        ]);

        $setting = PortalSetting::query()->first();
        $homeBio = $setting?->home_bio ?? PortalSetting::defaultBio();
        $homeAvatar = $setting?->home_avatar ?? PortalSetting::defaultAvatar();
        $homeProfileTitle = $setting?->home_profile_title ?: PortalSetting::defaultProfileTitle();
        $homeProfileSection = $setting?->home_profile_section ?: PortalSetting::defaultProfileSection();
        $homeProfileTags = $setting?->home_profile_tags ?: PortalSetting::defaultProfileTags();

        return view('home', [
            'topics' => $topics,
            'search' => $search,
            'homeBio' => $homeBio,
            'homeAvatar' => $homeAvatar,
            'homeProfileTitle' => $homeProfileTitle,
            'homeProfileSection' => $homeProfileSection,
            'homeProfileTags' => $homeProfileTags,
        ]);
    }
}
