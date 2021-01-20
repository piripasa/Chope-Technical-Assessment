<?php

namespace App\Http\Guards;

use App\Exceptions\AuthException;
use App\Service\JwtToken;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class JwtGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the query string item from the request containing the API token.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new authentication guard.
     *
     * @param \Illuminate\Contracts\Auth\UserProvider $provider
     * @param \Illuminate\Http\Request $request
     * @param string $key
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request, $key = 'api_token')
    {
        $this->key = $key;
        $this->request = $request;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        if (!$token = $this->getTokenForRequest()) {
            throw new AuthException("Token not provided");
        }

        try {
            $credentials = (new JwtToken([config('jwt.algo')], config('jwt.secret'), config('jwt.issuer')))->parseToken($token);
        } catch (ExpiredException $exception) {
            throw new AuthException("Provided token has been expired");
        } catch (\Exception $exception) {
            throw new AuthException("Seems invalid token provided");
        }
        if ($user = app('redisCache')->get($token)) {
            $this->user = unserialize($user);
        } else {
            $this->user = $this->provider->retrieveById($credentials->sub);
        }

        return $this->user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->query($this->key);

        if (empty($token)) {
            $token = $this->request->input($this->key);
        }

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['id'])) {
            return false;
        }

        if ($this->provider->retrieveById($credentials['id'])) {
            return true;
        }

        return false;
    }
}
