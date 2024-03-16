<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UrlInfoController extends Controller
{
    public function fetch(Request $request)
    {
        $url = $request->query('url');
        $response = Http::get($url);
        if ($response->successful()) {
            $htmlContent = $response->body();
            $title = $this->getPageTitle($htmlContent);
            $description = $this->getPageDescription($htmlContent);
            $imageUrl = $this->getSiteIcon($htmlContent, $url);

            // Return the response in the specified format
            return response()->json([
                'success' => 1,
                'link' => $url,
                'meta' => [
                    'title' => $title,
                    'description' => $description,
                    'image' => [
                        'url' => $imageUrl
                    ]
                ]
            ]);
        } else {
            // Return error response if URL fetch fails
            return response()->json([
                'success' => 0,
                'error' => 'Failed to fetch URL information.'
            ], $response->status());
        }
    }

    private function getPageTitle($htmlContent)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($htmlContent); // Suppress errors
        $titleNode = $doc->getElementsByTagName('title')->item(0);
        return $titleNode ? $titleNode->textContent : '';
    }


    private function getPageDescription($htmlContent)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($htmlContent); // Suppress errors
        $metaTags = $doc->getElementsByTagName('meta');
        foreach ($metaTags as $tag) {
            if ($tag->getAttribute('name') == 'description') {
                return $tag->getAttribute('content');
            }
        }
        return '';
    }

    private function getSiteIcon($htmlContent, $baseUrl)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($htmlContent); // Suppress errors
        $linkTags = $doc->getElementsByTagName('link');
        foreach ($linkTags as $tag) {
            if (strtolower($tag->getAttribute('rel')) == 'icon' || strtolower($tag->getAttribute('rel')) == 'shortcut icon') {
                $iconUrl = $tag->getAttribute('href');
                if (filter_var($iconUrl, FILTER_VALIDATE_URL) === false) {
                    // Convert relative URL to absolute URL
                    $iconUrl = rtrim($baseUrl, '/') . '/' . ltrim($iconUrl, '/');
                }
                return $iconUrl;
            }
        }
        return '';
    }
}
