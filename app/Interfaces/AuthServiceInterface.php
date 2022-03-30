<?php

namespace App\Interfaces;

interface AuthServiceInterface
{
    public function redirect_to();

    public function handle_callback();
}
