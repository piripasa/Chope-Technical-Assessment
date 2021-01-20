<?php

namespace Tests\Unit;

use App\Service\JwtToken;
use Tests\TestCase;

class JwtTokenTest extends TestCase
{
    public function testTokenGenerateSuccess()
    {
        $mockObj = $this->makeMock();
        $this->assertEquals(159, strlen($mockObj->createToken(10)));
    }

    public function testTokenGenerateFail()
    {
        $this->expectException(\ArgumentCountError::class);
        $mockObj = $this->makeMock();
        $mockObj->createToken();
    }

    public function testTokenParseSuccess()
    {
        $mockObj = $this->makeMock();
        $result = $mockObj->parseToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjaG9wZSIsInN1YiI6MTAsImlhdCI6MTYxMTA4Mjk3NiwiZXhwIjoxNjExMTY5Mzc2fQ.rDGkW3YD2ugsqFtV46CfFY57J4PmM_xrjmtec071TXo');
        $this->assertEquals(10, $result->sub);
    }

    public function testTokenParseFail()
    {
        $mockObj = $this->makeMock();
        $result = $mockObj->parseToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjaG9wZSIsInN1YiI6MTAsImlhdCI6MTYxMTA4Mjk3NiwiZXhwIjoxNjExMTY5Mzc2fQ.rDGkW3YD2ugsqFtV46CfFY57J4PmM_xrjmtec071TXo');
        $this->assertNotEquals(1, $result->sub);
    }

    private function makeMock()
    {
        return new JwtToken(
            [config('jwt.algo')],
            config('jwt.secret'),
            config('jwt.issuer'),
            config('jwt.ttl')
        );
    }
}
