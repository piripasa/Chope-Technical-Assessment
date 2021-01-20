<?php

namespace Tests\Feature\Controllers\Users;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\AttachJwtToken;

class ActivityControllerTest extends TestCase
{
    use DatabaseMigrations, AttachJwtToken;

    public function testActivity()
    {
        $response = $this->call('GET', 'api/activity')->getOriginalContent();

        $this->assertResponseStatus(200);
        $this->assertTrue($response['success']);
    }
}
