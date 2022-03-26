<?php

namespace App\Http\Requests;

class FormNoteTagRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tags' => 'required|exists:tags,id'
        ];
    }
}
