# Rapidez sitemap

Rapidez sitemap index through Eventy filters

## Installation

```
composer require rapidez/sitemap
```

## Views

You can publish the views with:
```
php artisan vendor:publish --tag=rapidez-sitemap-views
```

## Adding Additional Sitemap Indexes with Eventy

If you have additional indexes, such as CMS pages or other custom routes, you can dynamically add them to your sitemap index using the `rapidez.site.index` filter provided by Eventy.

To do this, simply add the following code to the appropriate place in your application (e.g., in a service provider or a dedicated sitemap configuration file):  

```php
use TorMorten\Eventy\Facades\Eventy;

Eventy::addFilter('rapidez.site.index', function ($sitemaps) {
    // Add your custom sitemap URL here
    $sitemaps[] = [
        'url' => url('/some-dynamic-url.xml'),
        'updated_at' => now()->toDateTimeString(),
    ];

    return $sitemaps;
});
```

With this filter in place, the URL `/some-dynamic-url.xml` will be added to your sitemap index, allowing you to dynamically include additional sections of your site, such as CMS-generated pages, product categories, or other custom data sources.

## License

GNU General Public License v3. Please see [License File](LICENSE) for more information.
