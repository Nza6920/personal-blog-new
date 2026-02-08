<?php

namespace App\Actions\Sitemap;

use App\Models\Topic;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap
{
    public function handle(string $path): void
    {
        Sitemap::create()
            ->add(
                Url::create(route('home.show'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(1.0)
            )
            ->add(Topic::query()->latest('id')->get())
            ->writeToFile($path);
    }
}
