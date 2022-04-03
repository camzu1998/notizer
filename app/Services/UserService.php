<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create_or_update_user(string $name, string $email, string $password, $google_id = null)
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'google_id' => $google_id
            ]
        );

        $user->google_id = $google_id;
        $user->isDirty() ? $user->save() : $user;

        return $user;
    }

    public function create_user(string $name, string $email, string $password)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
