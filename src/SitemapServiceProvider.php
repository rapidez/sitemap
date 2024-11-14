<?php

namespace Rapidez\Sitemap;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\ServiceProvider;
use Rapidez\Sitemap\Commands\GenerateSitemap;

class SitemapServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootCommands()
            ->bootRoutes()
            ->bootViews()
            ->bootPublishables();
    }

    public function bootCommands(): self
    {
        $this->commands([
            GenerateSitemap::class
        ]);

        if (config('rapidez.sitemap.schedule_generate_command')) {
            Schedule::command('rapidez:sitemap:generate')->twiceDaily(0, 12);
        }

        return $this;
    }

    public function bootConfig() : self
    {
        $this->mergeConfigFrom(__DIR__.'/../config/rapidez/sitemap.php', 'rapidez.sitemap');

        return $this;
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
