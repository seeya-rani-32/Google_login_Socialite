<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name'       => $googleUser->name,
                'email'      => $googleUser->email,
                'password'   => Hash::make('password'),
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (Exception $ex) {
            Log::info($ex);
            return redirect()->route('login')->withErrors(['msg' => 'Google login failed.']);
        }
    }

    public function githubLogin()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubAuthentication()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            $user = User::updateOrCreate([
                'github_id' => $githubUser->id,
            ], [
                'name'       => $githubUser->nickname,
                'email'      => $githubUser->email,
                'password'   => Hash::make('password'),
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (Exception $ex) {
            Log::info($ex);
            return redirect()->route('login')->withErrors(['msg' => 'Github login failed.']);
        }
    }
}
