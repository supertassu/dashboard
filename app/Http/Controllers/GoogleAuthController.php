<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleFitService;
use Illuminate\Support\Facades\Cache;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return redirect()->to(GoogleFitService::getGoogleClient()->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $client = GoogleFitService::getGoogleClient();
        $code = $request->input('code');
        $client->fetchAccessTokenWithAuthCode($code);
        Cache::put('google_credentials', $client->getAccessToken(), now()->addDays(21));
        return redirect('/');
    }
}
