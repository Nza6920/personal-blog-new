<?php

use App\Actions\Sitemap\GenerateSitemap;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sitemap:generate', function (GenerateSitemap $generateSitemap) {
    $generateSitemap->handle(public_path('sitemap.xml'));

    $this->info('sitemap.xml generated successfully.');
})->purpose('Generate sitemap.xml for SEO indexing');

Schedule::command('sitemap:generate')->daily();
