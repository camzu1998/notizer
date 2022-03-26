<?php

namespace App\Http\Requests;

class FormNoteRequest extends AbstractFormRequest
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
            'content' => 'nullable',
            'deadline' => 'nullable|date',
            'status' => 'nullable|integer',
            'tags' => 'nullable|exists:tags,id'
        ];
    }
}
