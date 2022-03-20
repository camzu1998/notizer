<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormTagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Tag::class, 'tag');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['tags'] = Tag::user()->get();

        return view('tags', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FormTagRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormTagRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        Tag::create($data);

        return redirect()->route('dashboard')->with('status', 'Tag created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Tag $tag)
    {
        $data['tag'] = $tag;

        return view('tag', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FormTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FormTagRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $tag->fill($data);
        $tag->save();

        return redirect()->route('tag', [$tag])->with('status', 'Tag updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags')->with('status', 'Tag deleted!');
    }
}
