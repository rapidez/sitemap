<?php

namespace Rapidez\Sitemap\Commands;

use Illuminate\Console\Command;
use Rapidez\Core\Facades\Rapidez;
use Rapidez\Sitemap\Jobs\GenerateSitemapJob;
use TorMorten\Eventy\Facades\Eventy;

class GenerateSitemap extends Command
{
    protected $signature = 'rapidez:sitemap:generate';

    protected $description = 'Generate the sitemap and run sitemap generate action';

    public function handle(): int
    {
        Eventy::action('rapidez.sitemap.generate');

        foreach (Rapidez::getStores() ?: [] as $store) {
            GenerateSitemapJob::dispatchSync($store['store_id']);
        }

        return Command::SUCCESS;
    }
}
