<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function getGoogleAuth()
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->redirect()
                ->getTargetUrl()
        ]);
    }

    public function authGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::firstOrCreate([
            'email' => $googleUser->email
        ], [
            'email_verified_at' => now(),
            'google_id' => $googleUser->getId()
        ]);

        Auth::login($user, true);
        dd($user->createToken('auth_token')->plainTextToken);
        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }
}
