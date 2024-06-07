<?php

namespace App\Http\Controllers;

use App\Models\Url;
use GuzzleHttp\Client;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ariaieboy\LaravelSafeBrowsing\LaravelSafeBrowsing;

class UrlController extends Controller
{

    // public $client;
    public function generateHashUrl(Request $request)
    {

        $request->validate([
            'url' => 'required|url',
        ]);

        //Check if the URL already exists in the database

        $checkedUrl = Url::where('url', $request->url)->first();
        if ($checkedUrl) {
            return response()->json([
                'message' => 'URL already exists',
                'url_hash' => url($checkedUrl->short_url_hash)
            ]);
        }

        //Check URL with Google Safe Browsing

        $checkSafedUrl = $request->url;
        $isSafe = $this->googleSafeBrowsingCheck($checkSafedUrl);

        if ($isSafe !== true) {
            return response()->json([
                'message' => 'URL is not safe',
                'threat_type' => $isSafe
            ]);
        }

        //Generate unique Hash
        $hash = Str::random(6);
        while (Url::where('short_url_hash', $hash)->exists()) {
            $hash = Str::random(6);
        }

        //save user Url and generated Hash to database
        $url = Url::create([
            'url' => $request->url,
            'short_url_hash' => $hash,
        ]);

        return response()->json([
            'short_url_hash' => url($url->short_url_hash)
        ]);

    }


    public function googleSafeBrowsingCheck($url)
    {
        $safeBrowsing = new LaravelSafeBrowsing();
        $result = $safeBrowsing->isSafeUrl($url, true);
        return $result;

    }


}
