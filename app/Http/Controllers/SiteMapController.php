<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tutorial;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends Controller
{
    public function generate()
    {
        $siteMap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('blog'))
            ->add(Url::create('podcasts'))
            ->add(Url::create('tutorials'))
            ->add(Url::create('user/login'));

        Post::whereStatus('published')->each(function (Post $post) use ($siteMap) {
            $siteMap->add(Url::create($post->link));
        });

        Tutorial::whereStatus('published')->each(function (Tutorial $tutorial) use ($siteMap) {
            $siteMap->add(Url::create($tutorial->link));
        });

        $siteMap->writeToFile(public_path('sitemap.xml'));

        return $siteMap;
    }
}
