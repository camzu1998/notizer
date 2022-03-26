<?php

namespace App\Http\Requests;

class StoreUserRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'            => 'required',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required',
            'repeat_password' => 'required|same:password'
        ];
    }
}
