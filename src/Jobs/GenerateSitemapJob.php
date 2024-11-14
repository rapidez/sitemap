<?php

namespace Rapidez\Sitemap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Rapidez\Sitemap\Models\Sitemap;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(protected int $storeId) {}

    public function handle(): void
    {
        Sitemap::getCachedByStoreId($this->storeId);
    }
}
