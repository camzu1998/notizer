<?php

namespace App\Services\AuthServices;

use App\Services\UserService;

abstract class AbstractAuthService
{
    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
}
