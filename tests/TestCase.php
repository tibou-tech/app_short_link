<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public User $currentUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setCurrentUser();
    }

    private function setCurrentUser()
    {
        $this->currentUser = User::factory()->create();
    }
}
