<?php

namespace Tests\Feature\Authenticated;

use App\Models\User;
use Tests\TestCase;

abstract class AuthenticatedTestCase extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }
}
