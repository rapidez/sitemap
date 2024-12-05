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

## Sitemap Generation

To generate the sitemap manually, use:
```bash
php artisan rapidez:sitemap:generate
```

If you'd like to schedule the sitemap generation you can add the `rapidez:sitemap:generate` command in `routes/console.php`, for more information see [Task Scheduling](https://laravel.com/docs/11.x/scheduling)

```php
Schedule::command('rapidez:sitemap:generate')->twiceDaily(0, 12);
```

## Hooking into the Generation Action

When the `rapidez:sitemap:generate` command runs, an Eventy action `rapidez.sitemap.generate` is triggered.

You can hook into this generation process by adding an action in the `boot` method of your service provider:
```php
Eventy::addAction('rapidez.sitemap.generate', fn() => DoMagicHere(), 20, 1);
```

## Adding Additional Sitemap Indexes with Eventy

If you have additional indexes, such as CMS pages or other custom routes, you can dynamically add them to your sitemap index based on the Store ID using the `rapidez.site.{storeId}` filter provided by Eventy.

To do this, simply add the following code to the appropriate place in your application (e.g., in a service provider or a dedicated sitemap configuration file):  

```php
use TorMorten\Eventy\Facades\Eventy;

Eventy::addFilter('rapidez.sitemap.{storeId}', function ($sitemaps) {
    // Add your custom sitemap URL here
    $sitemaps[] = [
        'loc' => url('/some-dynamic-url.xml'),
        'lastmod' => now()->toDateTimeString(),
    ];

    return $sitemaps;
});
```

With this filter in place, the URL `/some-dynamic-url.xml` will be added to your sitemap index, allowing you to dynamically include additional sections of your site, such as CMS-generated pages, product categories, or other custom data sources.

## License

GNU General Public License v3. Please see [License File](LICENSE) for more information.
