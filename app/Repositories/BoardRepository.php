<?php

namespace App\Repositories;

use App\Services\NoteService;
use App\Services\TaskService;

use App\Interfaces\BoardTypesContract;

class BoardRepository
{

    public function getProvider(string $provider): BoardTypesContract
    {
        return match($provider) {
            'task' => new TaskService(),
            'note' => new NoteService(),
//            'list' => new ListService()
        };
    }
}
