<?php

namespace Tests\Unit;

use App\Service\Pagination\Pagination;
use App\Service\Transformer\ActivityTransformer;
use App\Service\Transformer\TransformerException;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ActivityTransformerTest extends TestCase
{
    public function testShouldInstanceOfCollection()
    {
        $mockObj = $this->makeMock();
        $this->assertArrayHasKey('paginate', $mockObj->transformCollection((new Pagination([serialize(['test'])]))->paginate()));
    }

    public function testShouldReturnData()
    {
        $mockObj = $this->makeMock();
        $this->assertArrayHasKey('data', $mockObj->transformCollection(new Collection(serialize([1, 2, 3, 4]))));
    }

    public function testShouldThrowCollectionException()
    {
        $this->expectException(TransformerException::class);
        $mockObj = $this->makeMock();
        $mockObj->transformCollection([]);
    }

    public function testCallbackShouldValid()
    {
        $mockObj = $this->makeMock();
        $this->assertArrayHasKey('paginate', $mockObj->transformCollection((new Pagination([serialize(['test'])]))->paginate(), 'transform'));
    }

    private function makeMock()
    {
        return app(ActivityTransformer::class);
    }
}
