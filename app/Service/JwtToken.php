<?php


namespace App\Service;


use App\Service\Cache\CacheInterface;
use Firebase\JWT\JWT;

class JwtToken
{
    private $algorithm;
    private $secret;
    private $issuer;
    private $expiration;

    public function __construct(array $algorithm, string $secret, string $issuer, int $expiration = 86400)
    {
        $this->algorithm = $algorithm;
        $this->secret = $secret;
        $this->issuer = $issuer;
        $this->expiration = $expiration;
    }

    /**
     * Create a new token.
     * Also it will save in cache
     *
     * @param  $user
     * @param  $cache
     * @return string
     */
    public function createToken($user, $cache = null)
    {
        $token = $this->getJwtToken($user);

        if ($cache instanceof CacheInterface) {
            $cache->set(sprintf('user:%d:token', $user->id), $token, $this->expiration);
            $cache->set($token, serialize($user), $this->expiration);
        }

        return $token;
    }

    /**
     * @param $token
     * @return object
     */
    public function parseToken($token)
    {
        return JWT::decode($token, $this->secret, $this->algorithm);
    }

    /**
     * @param $user
     * @return string
     */
    private function getJwtToken($user)
    {
        $payload = [
            'iss' => $this->issuer, // Issuer of the token
            'sub' => $user['id'], // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + $this->expiration, // Expiration time
        ];

        return JWT::encode($payload, $this->secret);
    }
}
