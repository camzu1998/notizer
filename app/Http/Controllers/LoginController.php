<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Models\Note;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
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
        $data = $request->validated();

        if (Auth::attempt($data)) {
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

        $user = $service->handle_callback();

        return redirect()->route('dashboard');
    }

    public function redirect(Request $request, string $provider = 'default')
    {
        $service = $this->repository->getProvider($provider);

        return $service->redirect_to();
    }
}
