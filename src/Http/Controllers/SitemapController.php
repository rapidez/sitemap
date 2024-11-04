<?php

namespace Rapidez\Sitemap\Http\Controllers;

use Illuminate\Http\Response;
use TorMorten\Eventy\Facades\Eventy;
use Rapidez\Sitemap\Models\Sitemap;

class SitemapController
{
    public function index(): Response
    {
        // Retrieve cached sitemaps for the current store
        $sitemaps = Sitemap::getCachedByStoreId();

        // Allow additional sitemaps to be added via the Eventy filter
        $sitemaps = Eventy::filter('rapidez.sitemap.index', $sitemaps);

        // Return XML response
        return response()
            ->view('rapidez-sitemap::sitemaps.index', compact('sitemaps'))
            ->header('Content-Type', 'application/xml');
    }
}
