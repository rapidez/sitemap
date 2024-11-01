<?php

namespace Rapidez\Sitemap\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Rapidez\Core\Models\Model;
use Illuminate\Support\Collection;
use Illuminate\Http\Client\Response;
use SimpleXMLElement;

class Sitemap extends Model
{
    protected $table = 'sitemap';

    public static function getCachedByStoreId(): ?array
    {
        $cacheKey = 'sitemaps.' . config('rapidez.store');

        return Cache::rememberForever($cacheKey, function () {
            return self::where('store_id', config('rapidez.store'))
                ->get()
                ->flatMap(fn($sitemap) => self::getSitemapsFromIndex($sitemap->toArray()))
                ->toArray();
        });
    }

    protected static function getSitemapsFromIndex(array $sitemap): array
    {
        $sitemapUrl = config('rapidez.magento_url') . $sitemap['sitemap_path'] . $sitemap['sitemap_filename'];

        try {
            $sitemapXml = simplexml_load_file($sitemapUrl, SimpleXMLElement::class, LIBXML_NOERROR | LIBXML_NOWARNING);
            if ($sitemapXml === false) {
                throw new \RuntimeException('Failed to load sitemap XML.');
            }
            $sitemapOutput = json_decode(json_encode($sitemapXml), true);

            return $sitemapOutput['sitemap'] ?? [
                ['loc' => $sitemapUrl, 'lastmod' => $sitemap['sitemap_time']]
            ];
        } catch (\Exception $e) {
            \Log::error("Error loading sitemap from URL: $sitemapUrl", ['exception' => $e]);
            return [];
        }
    }
}
