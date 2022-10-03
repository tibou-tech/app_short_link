<?php

namespace Tests\Unit\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class SetLocale extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.locale', 'en');

        Config::set('app.locales', [
            'en' => 'English',
            'fr' => 'Français',
        ]);
    }

    public function test_default_locale_is_config()
    {
        $this->get('/login');

        $this->assertEquals(app()->getLocale(), config('app.locale'));
    }

    public function test_locale_from_dashboard()
    {
        $this->actingAs($this->currentUser);

        $this->get('en/dashboard');

        $this->assertEquals(app()->getLocale(), config('app.locale'));

        $this->get('fr/dashboard');

        $this->assertEquals(app()->getLocale(), 'fr');
    }

    public function test_invalid_locale_in_url()
    {
        $response = $this->get('/es');

        $response->assertStatus(404);
    }
}
