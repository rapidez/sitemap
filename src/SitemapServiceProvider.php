<?php

namespace Rapidez\Sitemap;

use Illuminate\Support\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this
            ->bootRoutes()
            ->bootViews()
            ->bootPublishables();
    }

    public function bootRoutes(): self
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        return $this;
    }

    public function bootViews(): self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez-sitemap');

        return $this;
    }

    public function bootPublishables(): self
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez-sitemap'),
        ], 'rapidez-sitemap-views');

        return $this;
    }
}
