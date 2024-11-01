<?php

namespace Rapidez\Sitemap;

use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Eventy;

class SitemapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this
            ->bootRoutes()
            ->bootViews()
            ->bootPublishables()
            ->bootFilters();
    }

    public function bootRoutes() : self
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        return $this;
    }

    public function bootViews() : self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez-sitemap');

        return $this;
    }

    public function bootPublishables() : self
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez-sitemap'),
        ], 'rapidez-sitemap-views');

        return $this;
    }

    public function bootFilters() : self
    {
        Eventy::addFilter('rapidez.site.index', function ($sitemaps) {
            $sitemaps[] = ['loc' => url('/some-dynamic-url.xml'), 'lastmod' => now()->toDateTimeString()];
            return $sitemaps;
        });

        return $this;
    }
}
