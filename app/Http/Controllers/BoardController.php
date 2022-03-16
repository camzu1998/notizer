<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormBoardRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Repositories\BoardRepository;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    private $repository;

    public function __construct(BoardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FormBoardRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FormBoardRequest $request, string $provider)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $service = $this->repository->getProvider($provider);
        $result = $service->create($data);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNoteRequest  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
