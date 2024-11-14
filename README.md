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
This package includes a configuration option to control the automatic scheduling of the sitemap generation command.

In the package’s service provider, if `schedule_generate_command` is enabled, the command is scheduled:

```php
if (config('rapidez.sitemap.schedule_generate_command')) {
    Schedule::command('rapidez:sitemap:generate')->twiceDaily(0, 12);
}
```

To disable scheduling, set this in your .env: `RAPIDEZ_SITEMAP_SCHEDULE_GENERATE=false`.

To run the sitemap generation manually, use:
```bash
php artisan rapidez:sitemap:generate
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
