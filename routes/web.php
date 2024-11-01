<?php

use Illuminate\Support\Facades\Route;
use Rapidez\Sitemap\Http\Controllers\SitemapController;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
