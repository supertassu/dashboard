<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Auth\AdfsSocialiteDriver;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AdfsAuthController extends Controller
{
    public function login(Request $request)
    {
        return Socialite::driver('adfs')
            ->redirect();
    }

    public function callback()
    {
        $adfsUser = Socialite::driver('adfs')->user();

        $user = User::firstOrCreate([
            'email' => $adfsUser->email,
        ], [
            'email' => $adfsUser->email,
            'name' => $adfsUser->name,
        ]);

        Auth::login($user, true);
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect(AdfsSocialiteDriver::getBaseUrl() . '/ls/?wa=wsignout1.0');
    }

    private function guard()
    {
        return Auth::guard();
    }
}
