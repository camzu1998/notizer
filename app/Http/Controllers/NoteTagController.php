<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormNoteTagRequest;
use App\Models\Note;
use App\Models\NoteTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class NoteTagController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\FormNoteTagRequest  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function store(FormNoteTagRequest $request, Note $note)
    {
        $data = $request->validated();
        $tags = Tag::find($data['tags']);

        $note_tags = $tags->notes()->create([
            'note_id' => $note->id
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note, Tag $tag)
    {
        //
    }
}
