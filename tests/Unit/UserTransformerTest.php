<?php

namespace Tests\Unit;

use App\Service\Transformer\TransformerException;
use App\Service\Transformer\UserTransformer;
use Tests\TestCase;

class UserTransformerTest extends TestCase
{
    public function testShouldReturnData()
    {
        $mockObj = $this->makeMock();
        $this->assertArrayHasKey('id', $mockObj->transform((object)['id' => 1, 'name' => 'Zaman', 'email' => 'test@test.test']));
    }

    public function testShouldThrowCollectionException()
    {
        $this->expectException(TransformerException::class);
        $mockObj = $this->makeMock();
        $mockObj->transformCollection([]);
    }

    private function makeMock()
    {
        return app(UserTransformer::class);
    }
}
