<?php

namespace App\Services;

use App\Interfaces\BoardTypesContract;
use App\Models\Task;

class TaskService implements BoardTypesContract
{
    public function create(array $data): array
    {
        return Task::factory()->create($data)->toArray();
    }
}
