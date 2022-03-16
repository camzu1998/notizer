<?php

namespace App\Services;

use App\Interfaces\BoardTypesContract;
use App\Models\Note;

class NoteService implements BoardTypesContract
{
    public function create(array $data): array
    {
        return Note::factory()->create($data)->toArray();
    }
}
