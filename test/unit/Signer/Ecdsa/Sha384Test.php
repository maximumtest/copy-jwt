<?php
/**
 * This file is part of Maximumtest\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Maximumtest\JWT\Signer\Ecdsa;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.1.0
 */
class Sha384Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @uses Maximumtest\JWT\Signer\Ecdsa
     * @uses Maximumtest\JWT\Signer\OpenSSL
     *
     * @covers Maximumtest\JWT\Signer\Ecdsa\Sha384::getAlgorithmId
     */
    public function getAlgorithmIdMustBeCorrect()
    {
        $signer = new Sha384();

        $this->assertEquals('ES384', $signer->getAlgorithmId());
    }

    /**
     * @test
     *
     * @uses Maximumtest\JWT\Signer\Ecdsa
     * @uses Maximumtest\JWT\Signer\OpenSSL
     *
     * @covers Maximumtest\JWT\Signer\Ecdsa\Sha384::getAlgorithm
     */
    public function getAlgorithmMustBeCorrect()
    {
        $signer = new Sha384();

        $this->assertEquals('sha384', $signer->getAlgorithm());
    }

    /**
     * @test
     *
     * @uses Maximumtest\JWT\Signer\Ecdsa
     * @uses Maximumtest\JWT\Signer\OpenSSL
     *
     * @covers Maximumtest\JWT\Signer\Ecdsa\Sha384::getKeyLength
     */
    public function getKeyLengthMustBeCorrect()
    {
        $signer = new Sha384();

        $this->assertEquals(96, $signer->getKeyLength());
    }
}
