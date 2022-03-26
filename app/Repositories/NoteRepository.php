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
        $data = $request->safe()->except('tags');
        $data['user_id'] = Auth::id();

        $note = Note::create($data);

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
        $data = $request->validated();

        if(!empty($data['tags']))
        {
            $tags = $user->tags()->find($data['tags']);
            $note->tags()->sync($tags);
        }

        return $note;
    }
}
