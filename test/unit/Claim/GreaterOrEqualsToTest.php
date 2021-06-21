<?php
/**
 * This file is part of Maximumtest\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Maximumtest\JWT\Claim;

use Maximumtest\JWT\ValidationData;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.0.0
 */
class GreaterOrEqualsToTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @uses Maximumtest\JWT\Claim\Basic::__construct
     * @uses Maximumtest\JWT\Claim\Basic::getName
     * @uses Maximumtest\JWT\ValidationData::__construct
     * @uses Maximumtest\JWT\ValidationData::has
     * @uses Maximumtest\JWT\ValidationData::setCurrentTime
     *
     * @covers Maximumtest\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValidationDontHaveTheClaim()
    {
        $claim = new GreaterOrEqualsTo('iss', 10);

        $this->assertTrue($claim->validate(new ValidationData()));
    }

    /**
     * @test
     *
     * @uses Maximumtest\JWT\Claim\Basic::__construct
     * @uses Maximumtest\JWT\Claim\Basic::getName
     * @uses Maximumtest\JWT\Claim\Basic::getValue
     * @uses Maximumtest\JWT\ValidationData::__construct
     * @uses Maximumtest\JWT\ValidationData::setIssuer
     * @uses Maximumtest\JWT\ValidationData::has
     * @uses Maximumtest\JWT\ValidationData::get
     * @uses Maximumtest\JWT\ValidationData::setCurrentTime
     *
     * @covers Maximumtest\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValueIsGreaterThanValidationData()
    {
        $claim = new GreaterOrEqualsTo('iss', 11);

        $data = new ValidationData();
        $data->setIssuer(10);

        $this->assertTrue($claim->validate($data));
    }

    /**
     * @test
     *
     * @uses Maximumtest\JWT\Claim\Basic::__construct
     * @uses Maximumtest\JWT\Claim\Basic::getName
     * @uses Maximumtest\JWT\Claim\Basic::getValue
     * @uses Maximumtest\JWT\ValidationData::__construct
     * @uses Maximumtest\JWT\ValidationData::setIssuer
     * @uses Maximumtest\JWT\ValidationData::has
     * @uses Maximumtest\JWT\ValidationData::get
     * @uses Maximumtest\JWT\ValidationData::setCurrentTime
     *
     * @covers Maximumtest\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnTrueWhenValueIsEqualsToValidationData()
    {
        $claim = new GreaterOrEqualsTo('iss', 10);

        $data = new ValidationData();
        $data->setIssuer(10);

        $this->assertTrue($claim->validate($data));
    }

    /**
     * @test
     *
     * @uses Maximumtest\JWT\Claim\Basic::__construct
     * @uses Maximumtest\JWT\Claim\Basic::getName
     * @uses Maximumtest\JWT\Claim\Basic::getValue
     * @uses Maximumtest\JWT\ValidationData::__construct
     * @uses Maximumtest\JWT\ValidationData::setIssuer
     * @uses Maximumtest\JWT\ValidationData::has
     * @uses Maximumtest\JWT\ValidationData::get
     * @uses Maximumtest\JWT\ValidationData::setCurrentTime
     *
     * @covers Maximumtest\JWT\Claim\GreaterOrEqualsTo::validate
     */
    public function validateShouldReturnFalseWhenValueIsLesserThanValidationData()
    {
        $claim = new GreaterOrEqualsTo('iss', 10);

        $data = new ValidationData();
        $data->setIssuer(11);

        $this->assertFalse($claim->validate($data));
    }
}
