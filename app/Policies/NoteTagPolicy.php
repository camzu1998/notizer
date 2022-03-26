<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoteTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Note  $note
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Note $note, Tag $tag)
    {
        return $user->id === $note->user_id && $user->id === $tag->user_id;
    }
}
