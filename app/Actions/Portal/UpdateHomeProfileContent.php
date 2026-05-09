<?php

namespace App\Actions\Portal;

use App\Models\PortalSetting;
use Illuminate\Validation\ValidationException;

class UpdateHomeProfileContent
{
    public function handle(string $title, string $section, string $tags): PortalSetting
    {
        $normalizedTags = $this->normalizeTags($tags);

        if ($normalizedTags === []) {
            throw ValidationException::withMessages([
                'home_profile_tags' => __('validation.required', ['attribute' => __('admin_ui.profile.home_profile.tags_label')]),
            ]);
        }

        if (count($normalizedTags) > 20) {
            throw ValidationException::withMessages([
                'home_profile_tags' => __('validation.max.array', [
                    'attribute' => __('admin_ui.profile.home_profile.tags_label'),
                    'max' => 20,
                ]),
            ]);
        }

        foreach ($normalizedTags as $tag) {
            if (mb_strlen($tag) > 50) {
                throw ValidationException::withMessages([
                    'home_profile_tags' => __('validation.max.string', [
                        'attribute' => __('admin_ui.profile.home_profile.tags_label'),
                        'max' => 50,
                    ]),
                ]);
            }
        }

        return PortalSetting::query()->updateOrCreate([], [
            'home_profile_title' => $title,
            'home_profile_section' => $section,
            'home_profile_tags' => $normalizedTags,
        ]);
    }

    /**
     * @return array<int, string>
     */
    private function normalizeTags(string $tags): array
    {
        $parts = preg_split('/[\r\n,]+/', $tags) ?: [];
        $normalized = [];

        foreach ($parts as $part) {
            $tag = trim($part);

            if ($tag === '' || in_array($tag, $normalized, true)) {
                continue;
            }

            $normalized[] = $tag;
        }

        return $normalized;
    }
}
