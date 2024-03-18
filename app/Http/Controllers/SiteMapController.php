<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\SitemapGenerator;

class SiteMapController extends Controller
{
    public function generate()
    {
        return SitemapGenerator::create('https://edrisranjbar.ir')->getSitemap();
    }
}
