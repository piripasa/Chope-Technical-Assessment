<?php


namespace App\Service;

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
     * @param $subject
     * @return string
     */
    public function createToken($subject)
    {
        return $this->getJwtToken($subject);
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
     * @param $subject
     * @return string
     */
    private function getJwtToken($subject)
    {
        $payload = [
            'iss' => $this->issuer, // Issuer of the token
            'sub' => $subject, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + $this->expiration, // Expiration time
        ];

        return JWT::encode($payload, $this->secret);
    }
}
