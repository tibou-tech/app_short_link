<?php

namespace Tests\Unit\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectIfAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_not_authenticated()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authenticated()
    {
        $this->actingAs($this->currentUser);

        $response = $this->get('/login');

        $response->assertRedirect('en/dashboard');
    }
}
