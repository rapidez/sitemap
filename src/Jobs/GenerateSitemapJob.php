<?php

namespace Rapidez\Sitemap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Rapidez\Sitemap\Models\Sitemap;
use Rapidez\Sitemap\Actions\GenerateSitemapAction;
use TorMorten\Eventy\Facades\Eventy;
use Rapidez\Core\Facades\Rapidez;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(protected int $storeId) {}

    public function handle(GenerateSitemapAction $action): void
    {
        Rapidez::setStore($this->storeId);

        // Get sitemaps for the store
        $sitemaps = Sitemap::getCachedByStoreId($this->storeId);

        // Allow additional sitemaps via Eventy filter
        $sitemaps = Eventy::filter('rapidez.sitemap.'.$this->storeId, $sitemaps);

        // Generate sitemap content
        $sitemapContent = $action->createSitemapIndex($sitemaps);

        // Get storage disk and path from config
        $disk = Storage::disk(config('rapidez-sitemap.disk', 'public'));
        $basePath = trim(config('rapidez-sitemap.path', 'rapidez-sitemaps'), '/');

        // Generate store-specific path
        $storePath = $basePath.'/'.$this->storeId;

        // Ensure directory exists and save sitemap
        $disk->put($storePath.'/sitemap.xml', $sitemapContent);

        // Clear cache
        Cache::forget('rapidez.sitemaps.'.$this->storeId);
    }
}
