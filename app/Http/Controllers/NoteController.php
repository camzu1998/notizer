<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\FormNoteRequest;
use App\Repositories\NoteRepository;

class NoteController extends Controller
{
    private $repository;
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(NoteRepository $repository)
    {
        $this->authorizeResource(Note::class, 'note');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param FormNoteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormNoteRequest $request)
    {
        $this->repository->create_note($request);

        return redirect()->route('dashboard')->with('status', 'Note created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Note $note)
    {
        $data['note'] = $note;

        return view('note', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormNoteRequest $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FormNoteRequest $request, Note $note)
    {
        $this->repository->update_note($request, $note);

        return redirect()->route('note', [$note])->with('status', 'Note updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('dashboard')->with('status', 'Note deleted!');
    }
}
