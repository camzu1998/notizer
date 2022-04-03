<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $repository;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function user_auth(LoginFormRequest $request)
    {
        $data = $request->safe()->except('remember_me');
        $remember = boolval($request->safe()->only('remember_me'));

        if (Auth::attempt($data, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput(['email']);
    }

    public function third_party_auth(Request $request, string $provider)
    {
        $service = $this->repository->getProvider($provider);

        $service->handle_callback();
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    public function redirect(Request $request, string $provider = 'default')
    {
        $service = $this->repository->getProvider($provider);

        return $service->redirect_to();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
