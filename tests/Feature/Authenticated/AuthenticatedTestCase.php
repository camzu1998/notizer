<?php

namespace Tests\Feature\Authenticated;

use App\Models\User;
use Tests\TestCase;

abstract class AuthenticatedTestCase extends TestCase
{
    protected $user;
    protected $dashboard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->dashboard = $this->user->dashboards()->first();

        $this->actingAs($this->user);
    }
}
