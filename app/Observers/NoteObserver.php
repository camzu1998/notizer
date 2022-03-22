<?php

namespace App\Observers;

use App\Models\Note;

class NoteObserver
{

    /**
     * Handle the Note "deleted" event.
     *
     * @param  \App\Models\Note  $note
     * @return void
     */
    public function deleted(Note $note)
    {
        $note->tags()->delete();
    }
}
