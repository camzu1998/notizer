<?php

namespace App\Repositories;

use App\Http\Requests\FormNoteRequest;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteRepository
{
    private $user;

    public function  __construct()
    {
        $this->user = Auth::user();
    }

    public function create_note(FormNoteRequest $request): Note
    {
        $data = $request->safe()->except('tags');

        $note = $this->user->notes()->create($data);

        $this->sync_note_tags($request, $note);

        return $note;
    }

    public function update_note(FormNoteRequest $request, Note $note): Note
    {
        $data = $request->safe()->except('tags');

        $note->fill($data);
        $note->isDirty() ? $note->save() : $note;

        $this->sync_note_tags($request, $note);

        return $note;
    }

    public function sync_note_tags(Request $request, Note $note): Note
    {
        if(!empty($request->tags))
        {
            $tags = $this->user->tags()->find($request->tags);
            $note->tags()->sync($tags);
        }

        return $note;
    }
}
