<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($sitemaps ?? [] as $sitemap)
        @if(($sitemap['loc'] ?? false) && ($sitemap['lastmod'] ?? false))
            <sitemap>
                <loc>{{ $sitemap['loc'] }}</loc>
                <lastmod>{{ $sitemap['lastmod'] }}</lastmod>
            </sitemap>
        @endif
    @endforeach
</sitemapindex>
