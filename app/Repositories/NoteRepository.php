<?php

namespace App\Repositories;

use App\Http\Requests\FormNoteRequest;
use App\Http\Requests\FormNoteTagRequest;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteRepository
{
    public function create_note(FormNoteRequest $request): Note
    {
        $user = Auth::user();
        $data = $request->safe()->except('tags');

        $note = $user->notes()->create($data);

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
        $user = Auth::user();

        if(!empty($request->tags))
        {
            $tags = $user->tags()->find($request->tags);
            $note->tags()->sync($tags);
        }

        return $note;
    }
}
