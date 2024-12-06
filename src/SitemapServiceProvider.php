<?php

namespace Rapidez\Sitemap;

use Illuminate\Support\ServiceProvider;
use Rapidez\Sitemap\Commands\GenerateSitemap;

class SitemapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sitemap.php' => config_path('rapidez-sitemap.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSitemap::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez-sitemap');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sitemap.php', 'rapidez-sitemap'
        );
    }
}
