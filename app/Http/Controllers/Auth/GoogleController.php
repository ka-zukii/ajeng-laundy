<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update(['google_id' => $googleUser->getId()]);
                Auth::login($user);
                return redirect()->intended('dashboard');
            } else {
                return view('auth.register-google', [
                    'google_name' => $googleUser->getName(),
                    'google_email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]);
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login menggunakan Google');
        }
    }
}
