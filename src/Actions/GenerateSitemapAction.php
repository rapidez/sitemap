<?php

namespace Rapidez\Sitemap\Actions;

class GenerateSitemapAction
{
    public function createSitemapIndex(array $sitemapIndexes): string
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($sitemapIndexes as $sitemapIndex) {
            $sitemap .= $this->addUrl($sitemapIndex['loc'] ?? null, $sitemapIndex['lastmod'] ?? null);
        }

        $sitemap .= '</sitemapindex>';

        return $sitemap;
    }

    public function createSitemapUrlset(array $sitemapUrls): string
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';

        foreach ($sitemapUrls as $sitemapUrl) {
            $sitemap .= $this->addUrl($sitemapUrl['loc'] ?? null, $sitemapUrl['lastmod'] ?? null, false);
        }

        $sitemap .= '</urlset>';

        return $sitemap;
    }

    public function addUrl(?string $url = null, ?string $lastMod = null, bool $isIndex = true): string
    {
        $sitemap = $isIndex ? '<sitemap>' : '<url>';

        if ($url) {
            $sitemap .= '<loc>'.url($url).'</loc>';
        }

        if ($lastMod) {
            $sitemap .= '<lastmod>'.substr($lastMod, 0, 10).'</lastmod>';
        }

        $sitemap .= $isIndex ? '</sitemap>' : '</url>';

        return $sitemap;
    }
}
