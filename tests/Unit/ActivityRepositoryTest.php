<?php

namespace Tests\Unit;

use App\Repository\ActivityRepository;
use App\Service\Cache\CacheInterface;
use Tests\TestCase;


class ActivityRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testStoreShouldReturnInterfaceInstance()
    {
        $mockObj = $this->makeMock();
        $this->assertInstanceOf(CacheInterface::class, $mockObj->store('somekey', 'value', 1));
    }

    public function testStoreParamMustBeValid()
    {
        $this->expectException(\TypeError::class);
        $mockObj = $this->makeMock();
        $mockObj->store('', []);
    }

    public function testFindByShouldReturnData()
    {
        $mockObj = $this->makeMock();
        $this->assertIsArray($mockObj->findBy('somekey'));
    }

    public function testFindByParamShouldBeValid()
    {
        $this->expectException(\TypeError::class);
        $mockObj = $this->makeMock();
        $mockObj->findBy([]);
    }

    private function makeMock()
    {
        return new ActivityRepository(app('redisCache'));
    }

}
