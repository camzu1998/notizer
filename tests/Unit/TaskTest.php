<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A task create test
     *
     * @return void
     */
    public function test_store_task()
    {
        //Creating task
        $task = Task::factory()->create();

        //Check if task created
        $this->assertIsObject($task);
        $this->assertModelExists($task);
    }

    /**
     * A task change test
     *
     * @return void
     */
    public function test_update_task()
    {
        //Creating task
        $task = Task::factory()->create();
        //Change task data
        $task->name = 'positive test';
        $task->save();

        //Check if changed task is in database
        $this->assertDatabaseHas('tasks', [
            'name' => 'positive test',
        ]);
    }

    /**
     * A destroy task test
     *
     * @return void
     */
    public function test_delete_user()
    {
        //Creating task
        $task = Task::factory()->create();
        //Delete task
        $task->delete();

        //Check if task is deleted
        $this->assertModelMissing($task);
    }
}
