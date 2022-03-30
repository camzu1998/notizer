<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a start page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('homepage');
    }
    /**
     * Display a dashboard page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
