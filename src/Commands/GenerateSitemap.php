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


    public function handle()
    {
        foreach (Rapidez::getStores() ?: [] as $store) {
            GenerateSitemapJob::dispatch($store['store_id']);
        }

        Eventy::action('rapidez.sitemap.generate');

        return Command::SUCCESS;
    }
}
