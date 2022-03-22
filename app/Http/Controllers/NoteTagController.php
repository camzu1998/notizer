<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormNoteTagRequest;
use App\Models\Note;
use App\Models\NoteTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteTagController extends Controller
{
    /**
     * Synchronize note tags
     *
     * @param  \Illuminate\Http\FormNoteTagRequest  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sync(FormNoteTagRequest $request, Note $note)
    {
        $user = Auth::user();
        $request_data = $request->validated();
        $tags = $user->tags()->find($request_data['tags']);

        $note->tags()->sync($tags);

        return redirect()->route('dashboard')->with('status', 'Note tags created!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Note $note, Tag $tag)
    {
        $note->tags()->detach($tag->id);

        return redirect()->route('dashboard')->with('status', 'Note tag deleted!');
    }
}
