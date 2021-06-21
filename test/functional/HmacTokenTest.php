<?php
/**
 * This file is part of Maximumtest\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Maximumtest\JWT\FunctionalTests;

use Maximumtest\JWT\Builder;
use Maximumtest\JWT\Parser;
use Maximumtest\JWT\Token;
use Maximumtest\JWT\Signature;
use Maximumtest\JWT\Signer\Hmac\Sha256;
use Maximumtest\JWT\Signer\Hmac\Sha512;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.1.0
 */
class HmacTokenTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Sha256
     */
    private $signer;

    /**
     * @before
     */
    public function createSigner()
    {
        $this->signer = new Sha256();
    }

    /**
     * @test
     *
     * @covers Maximumtest\JWT\Builder
     * @covers Maximumtest\JWT\Token
     * @covers Maximumtest\JWT\Signature
     * @covers Maximumtest\JWT\Claim\Factory
     * @covers Maximumtest\JWT\Claim\Basic
     * @covers Maximumtest\JWT\Parsing\Encoder
     * @covers Maximumtest\JWT\Signer\Key
     * @covers Maximumtest\JWT\Signer\BaseSigner
     * @covers Maximumtest\JWT\Signer\Hmac
     * @covers Maximumtest\JWT\Signer\Hmac\Sha256
     */
    public function builderCanGenerateAToken()
    {
        $user = (object) ['name' => 'testing', 'email' => 'testing@abc.com'];

        $token = (new Builder())->setId(1)
                              ->setAudience('http://client.abc.com')
                              ->setIssuer('http://api.abc.com')
                              ->set('user', $user)
                              ->setHeader('jki', '1234')
                              ->sign($this->signer, 'testing')
                              ->getToken();

        $this->assertAttributeInstanceOf(Signature::class, 'signature', $token);
        $this->assertEquals('1234', $token->getHeader('jki'));
        $this->assertEquals('http://client.abc.com', $token->getClaim('aud'));
        $this->assertEquals('http://api.abc.com', $token->getClaim('iss'));
        $this->assertEquals($user, $token->getClaim('user'));

        return $token;
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Maximumtest\JWT\Builder
     * @covers Maximumtest\JWT\Parser
     * @covers Maximumtest\JWT\Token
     * @covers Maximumtest\JWT\Signature
     * @covers Maximumtest\JWT\Claim\Factory
     * @covers Maximumtest\JWT\Claim\Basic
     * @covers Maximumtest\JWT\Parsing\Encoder
     * @covers Maximumtest\JWT\Parsing\Decoder
     */
    public function parserCanReadAToken(Token $generated)
    {
        $read = (new Parser())->parse((string) $generated);

        $this->assertEquals($generated, $read);
        $this->assertEquals('testing', $read->getClaim('user')->name);
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Maximumtest\JWT\Builder
     * @covers Maximumtest\JWT\Parser
     * @covers Maximumtest\JWT\Token
     * @covers Maximumtest\JWT\Signature
     * @covers Maximumtest\JWT\Parsing\Encoder
     * @covers Maximumtest\JWT\Claim\Factory
     * @covers Maximumtest\JWT\Claim\Basic
     * @covers Maximumtest\JWT\Signer\Key
     * @covers Maximumtest\JWT\Signer\BaseSigner
     * @covers Maximumtest\JWT\Signer\Hmac
     * @covers Maximumtest\JWT\Signer\Hmac\Sha256
     */
    public function verifyShouldReturnFalseWhenKeyIsNotRight(Token $token)
    {
        $this->assertFalse($token->verify($this->signer, 'testing1'));
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Maximumtest\JWT\Builder
     * @covers Maximumtest\JWT\Parser
     * @covers Maximumtest\JWT\Token
     * @covers Maximumtest\JWT\Signature
     * @covers Maximumtest\JWT\Parsing\Encoder
     * @covers Maximumtest\JWT\Claim\Factory
     * @covers Maximumtest\JWT\Claim\Basic
     * @covers Maximumtest\JWT\Signer\Key
     * @covers Maximumtest\JWT\Signer\BaseSigner
     * @covers Maximumtest\JWT\Signer\Hmac
     * @covers Maximumtest\JWT\Signer\Hmac\Sha256
     * @covers Maximumtest\JWT\Signer\Hmac\Sha512
     */
    public function verifyShouldReturnFalseWhenAlgorithmIsDifferent(Token $token)
    {
        $this->assertFalse($token->verify(new Sha512(), 'testing'));
    }

    /**
     * @test
     *
     * @depends builderCanGenerateAToken
     *
     * @covers Maximumtest\JWT\Builder
     * @covers Maximumtest\JWT\Parser
     * @covers Maximumtest\JWT\Token
     * @covers Maximumtest\JWT\Signature
     * @covers Maximumtest\JWT\Parsing\Encoder
     * @covers Maximumtest\JWT\Claim\Factory
     * @covers Maximumtest\JWT\Claim\Basic
     * @covers Maximumtest\JWT\Signer\Key
     * @covers Maximumtest\JWT\Signer\BaseSigner
     * @covers Maximumtest\JWT\Signer\Hmac
     * @covers Maximumtest\JWT\Signer\Hmac\Sha256
     */
    public function verifyShouldReturnTrueWhenKeyIsRight(Token $token)
    {
        $this->assertTrue($token->verify($this->signer, 'testing'));
    }

    /**
     * @test
     *
     * @covers Maximumtest\JWT\Builder
     * @covers Maximumtest\JWT\Parser
     * @covers Maximumtest\JWT\Token
     * @covers Maximumtest\JWT\Signature
     * @covers Maximumtest\JWT\Signer\Key
     * @covers Maximumtest\JWT\Signer\BaseSigner
     * @covers Maximumtest\JWT\Signer\Hmac
     * @covers Maximumtest\JWT\Signer\Hmac\Sha256
     * @covers Maximumtest\JWT\Claim\Factory
     * @covers Maximumtest\JWT\Claim\Basic
     * @covers Maximumtest\JWT\Parsing\Encoder
     * @covers Maximumtest\JWT\Parsing\Decoder
     */
    public function everythingShouldWorkWhenUsingATokenGeneratedByOtherLibs()
    {
        $data = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXUyJ9.eyJoZWxsbyI6IndvcmxkIn0.Rh'
                . '7AEgqCB7zae1PkgIlvOpeyw9Ab8NGTbeOH7heHO0o';

        $token = (new Parser())->parse((string) $data);

        $this->assertEquals('world', $token->getClaim('hello'));
        $this->assertTrue($token->verify($this->signer, 'testing'));
    }
}
