<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $repository;
    private $service;
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository, UserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * Show the register form for creating a new user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('register_form');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated()->except(['repeat_password']);

        $user = $this->service->create_user($data['name'], $data['email'], $data['password']);

        return redirect()->route('login');
    }

    /**
     * Show the form for editing the user.
     *
     * @param  \App\Models\User  $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
