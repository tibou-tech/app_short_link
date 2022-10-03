<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if user authenticated can short links
     *
     * @return void
     */
    public function test_short_link_with_authenticated_user()
    {
        $this->actingAs($this->currentUser);

        $response = $this->postJson(route('links.store'), $this->data());

        $contains = config('app.url');

        $response->assertRedirect();

        $response->assertRedirectContains($contains);

        $this->assertDatabaseCount('links', 1);
    }

    /**
     * Test if user unauthenticated can't short links
     *
     * @return void
     */
    public function test_short_link_with_unauthenticated_user()
    {
        $response = $this->postJson(route('links.store'), $this->data());

        $response->assertStatus(401);

        $this->assertDatabaseCount('links', 0);
    }

    /**
     * Test if the authenticated user can delete their links
     *
     * @return void
     */
    public function test_can_user_delete_owner_links()
    {
        $this->actingAs($this->currentUser);

        $link = Link::factory()->create([
            'user_id' => $this->currentUser->id
        ]);

        $this->deleteJson(route('links.destroy', $link->key));

        $this->assertDatabaseCount('links', 0);
    }

    /**
     * Test if the authenticated user can delete the links of others
     *
     * @return void
     */
    public function test_can_user_delete_other_links()
    {
        $this->actingAs($this->currentUser);

        $user = User::factory()->create();

        $link = Link::factory()->create([
            'user_id' => $user->id
        ]);

        $this->deleteJson(route('links.destroy', $link->key));

        $this->assertDatabaseCount('links', 1);
    }

    /**
     * Test if the authenticated user can add numbers of links more than five
     *
     * @return void
     */
    public function test_can_user_add_links_more_than_five()
    {
        $this->actingAs($this->currentUser);

        Link::factory(5)->create([
            'user_id' => $this->currentUser->id
        ]);

        $response = $this->postJson(route('links.store'), $this->data());


        $response->assertStatus(422);

        $this->assertDatabaseCount('links', 5);

        if (app()->getLocale() === 'en') {
            $error = [
                "message" => "Number of links must be less than or equals 5",
                "errors" => [
                  "origin_link" => [
                    0 => "Number of links must be less than or equals 5"
                  ]
                ]
            ];

            $response->assertExactJson($error);
        }
    }

    /**
     * Test if the authenticated user access all links
     *
     * @return void
     */
    public function test_can_authenticated_user_access_link()
    {
        $this->actingAs($this->currentUser);

        $response = $this->getJson(route('links.index', ['locale' => 'en']));

        $response->assertStatus(200);
    }

    /**
     * Test if the unauthenticated user access all links
     *
     * @return void
     */
    public function test_can_unauthenticated_user_access_link()
    {
        $response = $this->getJson(route('links.index', ['locale' => 'en']));

        $response->assertStatus(200);
    }

    /**
     * Test if the count links in the App not more than twenty
     *
     * @return void
     */
    public function test_is_count_links_not_more_than_twenty()
    {
        $this->actingAs($this->currentUser);

        Link::factory(20)->create();

        $this->postJson(route('links.store'), $this->data());

        $this->assertDatabaseCount('links', 20);
    }

    /**
     * @return array
     */
    private function data(): array
    {
        $data = [];

        $data['origin_link'] = 'https://www.google.tn';

        return $data;
    }
}
