<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function generateHashUrl(Request $request)
    {

        $request->validate([
            'user_url' => 'required|url',
        ]);

        //Check if the URL already exists in the database

        $checkedUrl = Url::where('user_url', $request->user_url)->first();
        if ($checkedUrl) {
            return response()->json([
                'message' => 'URL already exists',
                'url_hash' => url($checkedUrl->short_url_hash)]);
        }

        //Generate unique Hash
        $hash = Str::random(6);
        while (Url::where('short_url_hash', $hash)->exists()) {
            $hash = Str::random(6);
        }

        //save user Url and generated Hash to database
        $url = Url::create([
            'user_url' => $request->user_url,
            'short_url_hash' => $hash,
        ]);

        return response()->json(['short_url_hash'=> url($url->short_url_hash)]);
    }

}
