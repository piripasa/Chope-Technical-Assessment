<?php

namespace Tests\Unit;

use App\Service\Pagination\Pagination;
use Illuminate\Pagination\AbstractPaginator;
use Tests\TestCase;


class PaginationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testShouldReturnInstanceOfPaginator()
    {
        $mockObj = $this->makeMock();
        $this->assertInstanceOf(AbstractPaginator::class, $mockObj->paginate(2, 1));
    }

    public function testParamMustBeValid()
    {
        $this->expectException(\TypeError::class);
        $mockObj = $this->makeMock();
        $mockObj->paginate(1, []);
    }

    private function makeMock()
    {
        return new Pagination([1, 2]);
    }

}
