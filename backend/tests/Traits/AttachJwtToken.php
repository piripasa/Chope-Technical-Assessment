<?php

namespace Tests\Traits;

trait AttachJwtToken
{
    protected function getJwtToken()
    {
        if (!defined("LOGGED_USER_JWT_TOKEN")) {
            $this->call('POST', 'api/register', [
                    'name' => 'Zaman',
                    'email' => 'test@test.test',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                ]
            )->getOriginalContent();
            $this->loggedInUser = $this->call("POST", "api/login", [
                'username' => 'test@test.test',
                'password' => '12345678'
            ])->getOriginalContent();
            define('LOGGED_USER_JWT_TOKEN', $this->loggedInUser['data']['access_token']);
        }

        return LOGGED_USER_JWT_TOKEN;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $parameters
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string $content
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        if ($this->needsToken($uri)) {
            $server = $this->attachToken($server);
        }

        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    protected function needsToken($url)
    {
        return !in_array(
            $url, [
                'api/register',
                'api/login',
            ]
        );
    }

    /**
     * @param array $server
     * @return string
     */
    protected function attachToken(array $server)
    {
        return array_merge($server, $this->transformHeadersToServerVars([
            'Authorization' => 'Bearer ' . $this->getJwtToken(),
        ]));
    }

}
