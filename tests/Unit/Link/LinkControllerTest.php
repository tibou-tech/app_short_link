<?php

namespace Tests\Unit\Link;

use App\Actions\AccessLinkLogAction;
use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    private AccessLinkLogAction $accessLog;
    private LinkRepository $processLink;

    protected function setUp(): void
    {
        parent::setUp();

        $this->accessLog = new AccessLinkLogAction();

        $this->processLink = new LinkRepository();
    }

    public function test_build_short_link()
    {
        $this->actingAs($this->currentUser);

        $data = [];

        $data['origin_link'] = 'https://www.google.tn';

        $response =$this->processLink->store($data);

        $this->assertEquals(get_class($response), Link::class);

        $this->assertEquals($response->origin_link, $data['origin_link']);

        $this->assertEquals($response->user_id, $this->currentUser->id);

        $this->assertEquals(strlen($response->key), 8);
    }

    public function test_logging()
    {
        $this->actingAs($this->currentUser);

        $link = Link::factory()->create();

        $this->accessLog->handle($link);

        $this->assertFileExists('storage/logs/access.log');
    }
}
