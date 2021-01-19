<?php

namespace Tests;

class HealthTest extends TestCase
{
    public function testHealth()
    {
        $this->get('/api/health');

        $this->assertEquals(
            "OK", $this->response->getContent()
        );
    }
}
