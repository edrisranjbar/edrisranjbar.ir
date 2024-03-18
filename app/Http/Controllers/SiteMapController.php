<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tutorial;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends Controller
{
    public function generate()
    {
        $siteMap = SitemapGenerator::create('https://edrisranjbar.ir')
            ->getSitemap()
            ->add(Url::create('/'))
            ->add(Url::create('/blog'))
            ->add(Url::create('/podcasts'))
            ->add(Url::create('/tutorials'))
            ->add(Url::create('/user/login'))
            ->writeToFile(public_path('sitemap.xml'));

        Post::all()->each(function (Post $post) use ($siteMap) {
            $siteMap->add(Url::create($post->link));
        });

        Tutorial::all()->each(function (Tutorial $tutorial) use ($siteMap) {
            $siteMap->add(Url::create($tutorial->link));
        });

        return $siteMap;
    }
}
