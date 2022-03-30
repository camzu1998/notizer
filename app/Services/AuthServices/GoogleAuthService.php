<?php

namespace App\Services\AuthServices;

use App\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthService extends AbstractAuthService implements AuthServiceInterface
{
    public function redirect_to()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handle_callback()
    {
        $google_user = Socialite::driver('google')->user();

        $user = $this->userService->create_or_update_user($google_user->name, $google_user->email, Str::random(30), $google_user->id);

        Auth::login($user);

        return $user;
    }
}
