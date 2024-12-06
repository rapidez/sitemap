<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sitemap Storage Settings
    |--------------------------------------------------------------------------
    |
    | Configure where the sitemap files should be stored. The disk should be
    | configured in your application's filesystems.php config file.
    | For public access, use the 'public' disk.
    |
    */
    'disk' => 'public',

    /*
    |--------------------------------------------------------------------------
    | Sitemap Base Path
    |--------------------------------------------------------------------------
    |
    | The base path where sitemap files will be stored on the specified disk.
    | Store-specific sitemaps will be stored in {path}/{store_id}/sitemap.xml
    |
    */
    'path' => 'rapidez-sitemaps',
];
