<?php

namespace App\Repositories;

use App\Models\Dashboard;
use Illuminate\Support\Facades\Auth;

class DashboardRepository
{
    private $user;

    public function  __construct()
    {
        $this->user = Auth::user();
    }

    public function get_default_dashboard(): Dashboard
    {
        return $this->user->dashboards()->where('default', true)->first();
    }
}
