<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormNoteTagRequest;
use App\Models\Note;
use App\Models\Tag;
use App\Repositories\NoteRepository;

class NoteTagController extends Controller
{
    private $repository;
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(NoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Synchronize note tags
     *
     * @param  \Illuminate\Http\FormNoteTagRequest  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sync(FormNoteTagRequest $request, Note $note)
    {
        $this->repository->sync_note_tags($request, $note);

        return redirect()->route('dashboard')->with('status', 'Note tags synced!');
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
