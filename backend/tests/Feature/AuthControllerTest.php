<?php

namespace Tests\Feature\Controllers\Users;

use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\AttachJwtToken;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations, AttachJwtToken;

    /**
     * @dataProvider paramProvider
     */
    public function testRegisterSuccess($params)
    {
        $response = $this->call('POST', 'api/register', $params
        )->getOriginalContent();

        $this->assertResponseStatus(201);
        $this->assertTrue($response['success']);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testRegisterFail($params)
    {
        $params['password_confirmation'] = 123456;
        $response = $this->call('POST', 'api/register', $params
        )->getOriginalContent();

        $this->assertResponseStatus(422);
        $this->assertFalse($response['success']);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testLoginSuccess($params)
    {
        $this->call('POST', 'api/register', $params);
        $response = $this->call('POST', 'api/login', [
                'username' => $params['email'],
                'password' => $params['password'],
            ]
        )->getOriginalContent();

        $this->assertResponseStatus(200);
        $this->assertTrue($response['success']);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testLoginFail($params)
    {
        $this->call('POST', 'api/register', $params);
        $response = $this->call('POST', 'api/login', [
                'username' => $params['email'],
                'password' => '111111111',
            ]
        )->getOriginalContent();

        $this->assertResponseStatus(401);
        $this->assertFalse($response['success']);
    }

    public function testLogout()
    {
        $response = $this->call('POST', 'api/logout')->getOriginalContent();
        $this->assertResponseStatus(200);
        $this->assertTrue($response['success']);
    }

    public function paramProvider()
    {
        $faker = Factory::create();
        return [
            [
                [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => '12345678',
                    'password_confirmation' => '12345678'
                ]
            ]
        ];
    }
}
