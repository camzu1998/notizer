<?php

namespace App\Http\Requests;

class FormTagRequest extends AbstractFormRequest
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
            'color' => 'nullable'
        ];
    }
}
