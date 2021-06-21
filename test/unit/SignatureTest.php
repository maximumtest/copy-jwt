<?php
/**
 * This file is part of Maximumtest\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Maximumtest\JWT;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 0.1.0
 */
class SignatureTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Signer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $signer;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->signer = $this->createMock(Signer::class);
    }

    /**
     * @test
     *
     * @covers Maximumtest\JWT\Signature::__construct
     */
    public function constructorMustConfigureAttributes()
    {
        $signature = new Signature('test');

        $this->assertAttributeEquals('test', 'hash', $signature);
    }

    /**
     * @test
     *
     * @uses Maximumtest\JWT\Signature::__construct
     *
     * @covers Maximumtest\JWT\Signature::__toString
     */
    public function toStringMustReturnTheHash()
    {
        $signature = new Signature('test');

        $this->assertEquals('test', (string) $signature);
    }

    /**
     * @test
     *
     * @uses Maximumtest\JWT\Signature::__construct
     * @uses Maximumtest\JWT\Signature::__toString
     *
     * @covers Maximumtest\JWT\Signature::verify
     */
    public function verifyMustReturnWhatSignerSays()
    {
        $this->signer->expects($this->any())
                     ->method('verify')
                     ->willReturn(true);

        $signature = new Signature('test');

        $this->assertTrue($signature->verify($this->signer, 'one', 'key'));
    }
}
