<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user create test
     *
     * @return void
     */
    public function test_store_user()
    {
        //Creating user
        $user = User::factory()->create();

        //Check if user created
        $this->assertIsObject($user);
        $this->assertModelExists($user);
    }

    /**
     * A user change test
     *
     * @return void
     */
    public function test_update_user()
    {
        //Creating user
        $user = User::factory()->create();
        //Change user data
        $user->name = 'positive test';
        $user->save();

        //Check if changed user is in database
        $this->assertDatabaseHas('users', [
            'name' => 'positive test',
        ]);
    }

    /**
     * A destroy user test
     *
     * @return void
     */
    public function test_delete_user()
    {
        //Creating user
        $user = User::factory()->create();
        //Delete user
        $user->delete();

        //Check if user is deleted
        $this->assertModelMissing($user);
    }
}
