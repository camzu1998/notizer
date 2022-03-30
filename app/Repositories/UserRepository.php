<?php

namespace App\Repositories;

use App\Interfaces\AuthServiceInterface;
use App\Services\AuthServices\GoogleAuthService;
use App\Services\AuthServices\DefaultAuthService;

class UserRepository
{
    public function getProvider(string $provider): AuthServiceInterface
    {
        return match($provider) {
            'google' => new GoogleAuthService(),
        };
    }
}
