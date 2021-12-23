<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestBase;

final class AccessHomePageTest extends TestBase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function can_access_to_home_route()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }
}