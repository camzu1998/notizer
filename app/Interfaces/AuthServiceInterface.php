<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthServiceInterface
{
    public function redirect_to();

    public function handle_callback(): User;
}
