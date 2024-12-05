<?php

namespace Rapidez\Sitemap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Rapidez\Sitemap\Models\Sitemap;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(protected int $storeId) {}

    public function handle(): void
    {
        $cacheKey = 'rapidez.sitemaps.'.$this->storeId;
        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
        Sitemap::getCachedByStoreId($this->storeId);
    }
}
