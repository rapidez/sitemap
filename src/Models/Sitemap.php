<?php

namespace Rapidez\Sitemap\Models;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Rapidez\Core\Models\Model;
use Rapidez\Core\Models\Scopes\ForCurrentStoreWithoutLimitScope;
use RuntimeException;
use SimpleXMLElement;

class Sitemap extends Model
{
    protected $table = 'sitemap';

    protected $primaryKey = 'sitemap_id';

    protected static function booting()
    {
        static::addGlobalScope(new ForCurrentStoreWithoutLimitScope('sitemap_id'));
    }

    public static function getByStoreId(int $storeId): ?array
    {
        return self::get()
                ->flatMap(fn ($sitemap) => self::getSitemapsFromIndex($sitemap->toArray()))
                ->toArray();
    }

    protected static function getSitemapsFromIndex(array $sitemap): array
    {
        $sitemapUrl = config('rapidez.magento_url').$sitemap['sitemap_path'].$sitemap['sitemap_filename'];

        try {
            $sitemapXml = simplexml_load_file($sitemapUrl, SimpleXMLElement::class, LIBXML_NOERROR | LIBXML_NOWARNING);

            if ($sitemapXml === false) {
                throw new RuntimeException('Failed to load sitemap XML.');
            }

            $sitemapOutput = json_decode(json_encode($sitemapXml) ?: '', true);

            return $sitemapOutput['sitemap'] ?? [
                ['loc' => $sitemapUrl, 'lastmod' => $sitemap['sitemap_time']],
            ];
        } catch (Exception $e) {
            Log::error("Error loading sitemap from URL: $sitemapUrl", ['exception' => $e]);

            return [];
        }
    }
}
