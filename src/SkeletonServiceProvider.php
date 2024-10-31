<?php

namespace VendorName\Skeleton;

use Illuminate\Support\ServiceProvider;

class SkeletonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/rapidez/:package_slug_without_prefix.php', 'rapidez.:package_slug_without_prefix');
    }

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
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        return $this;
    }

    public function bootViews() : self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rapidez-:package_slug_without_prefix');

        return $this;
    }

    public function bootPublishables() : self
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez-:package_slug_without_prefix'),
        ], 'rapidez-:package_slug_without_prefix-views');

        $this->publishes([
            __DIR__.'/../config/rapidez/:package_slug_without_prefix.php' => config_path('rapidez/:package_slug_without_prefix.php'),
        ], 'rapidez-:package_slug_without_prefix-config');

        return $this;
    }

    public function bootFilters() : self
    {
        Eventy::addFilter('index.product.data', function ($data) {
            // Manipulate the data
            return $data;
        });

        Eventy::addFilter('index.product.mapping', fn ($mapping) => array_merge_recursive($mapping ?: [], [
            'properties' => [
                // Additional mappings
            ],
        ]));
    }
}
