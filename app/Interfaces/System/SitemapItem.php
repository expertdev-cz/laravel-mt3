<?php

namespace App\Interfaces\System;

use Illuminate\Support\Collection;

interface SitemapItem
{
    public function getNameForSitemap():string;
    public function getItemsForSitemap(string $locale):Collection|array;
}
