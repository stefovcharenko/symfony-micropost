<?php
/**
 *
 *
 * @author: Stefan Ovcharenko <s.ovcharenko@bintime.com>
 * @date: 05.09.2019
 */

namespace App\Tests\Security;

use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testTokenGeneration()
    {
        $tokenGen = new TokenGenerator();
        $token = $tokenGen->getRandomSecureToken(30);

        $this->assertEquals(30, strlen($token));
        $this->assertTrue(ctype_alnum($token), 'Token contains invalid characters');
    }
}