<?php

namespace Tests\Unit;

use App\Repository\UserRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;


class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testStoreShouldReturnData()
    {
        $mockObj = $this->makeMock();
        $result = $mockObj->store([
            'name' => 'Zaman',
            'email' => 'test@test.test',
            'password' => app('hash')->make(12345678),
        ]);
        $this->assertEquals("Zaman", $result->name);
    }

    public function testStoreParamMustBeArray()
    {
        $this->expectException(\TypeError::class);
        $mockObj = $this->makeMock();
        $mockObj->store('');
    }

    public function testFindByShouldReturnData()
    {
        $mockObj = $this->makeMock();
        $result = $mockObj->store([
            'name' => 'Zaman',
            'email' => 'test@test.test',
            'password' => app('hash')->make(12345678),
        ]);
        $result = $mockObj->findBy('id', $result->id);
        $this->assertEquals("Zaman", $result->name);
    }

    public function testFindByParamShouldBeValid()
    {
        $this->expectException(\TypeError::class);
        $mockObj = $this->makeMock();
        $mockObj->findBy('');
    }

    private function makeMock()
    {
        return app(UserRepository::class);
    }

}
