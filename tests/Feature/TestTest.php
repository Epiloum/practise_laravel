<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestTest extends TestCase
{
    /**
     *
     */
    public function testRouteTest()
    {
        $response = $this->get('/test/db');
        $response->assertStatus(200);
    }
}
