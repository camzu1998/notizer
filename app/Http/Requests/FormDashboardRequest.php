<?php

namespace App\Http\Requests;

class FormDashboardRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'color' => 'nullable',
            'default' => 'nullable',
        ];
    }
}
