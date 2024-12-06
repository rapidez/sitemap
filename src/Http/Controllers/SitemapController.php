<?php

namespace Rapidez\Sitemap\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SitemapController
{
    public function __invoke(): Response
    {
        $storeId = config('rapidez.store');
        $disk = Storage::disk(config('rapidez-sitemap.disk', 'public'));
        $path = trim(config('rapidez-sitemap.path', 'rapidez-sitemaps'), '/');

        $sitemapPath = $path.'/'.$storeId.'/sitemap.xml';

        if (!$disk->exists($sitemapPath)) {
            abort(404);
        }

        return response($disk->get($sitemapPath))
            ->header('Content-Type', 'application/xml');
    }
}
