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
            ->latest('id');

        if ($search !== '') {
            $topicsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $topics = $topicsQuery->paginate(10)->appends([
            'keyword' => $search,
        ]);

        $homeBio = PortalSetting::query()->value('home_bio') ?? PortalSetting::defaultBio();

        return view('home', [
            'topics' => $topics,
            'search' => $search,
            'homeBio' => $homeBio,
        ]);
    }
}
