# Rapidez sitemap

Rapidez sitemap index through Eventy filters

## Installation

```
composer require rapidez/sitemap
```

## Configuration

You can publish the configuration file with:
```bash
php artisan vendor:publish --tag=config --provider="Rapidez\Sitemap\SitemapServiceProvider"
```

This will create a `config/rapidez-sitemap.php` file where you can configure:
- `disk`: The Laravel filesystem disk to use (defaults to 'public')
- `path`: The path within the disk where sitemaps will be stored (defaults to root)

Make sure the specified disk is properly configured in your application's `config/filesystems.php`.

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

This command will generate `sitemap.xml` for the default store and `sitemap_{store_id}.xml` for additional stores in your configured storage location.

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
        'url' => 'your-custom-sitemap.xml',
        'lastmod' => now()->toDateString(),
    ];
    
    return $sitemaps;
}, 20, 1);
```

## License

GNU General Public License v3. Please see [License File](LICENSE) for more information.
