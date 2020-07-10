<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Gsa_Sf_Api_Core
 */
class Gsa_Sf_Api_CoreTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function setUp(): void
    {

    }

    /**
     * @coversNothing
     */
    public function tearDown(): void
    {

    }

    /**
     * Reflection, set to public private and protected methods.
     * As of PHP5 (>= 5.3.2)
     *
     * @coversNothing
     */
    protected static function getMethod($name): ReflectionMethod
    {
        $class = new ReflectionClass('Gsa_Sf_Api_Core');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @covers Gsa_Sf_Api_Core::initSession
     */
    public function testInitSessionWhenSessionIsSet(): void
    {
        $this->assertTrue((session_status() == PHP_SESSION_ACTIVE));

        $method = self::getMethod('initSession');
        $method->invoke(new Gsa_Sf_Api_Core);

        $this->assertTrue((session_status() == PHP_SESSION_ACTIVE));
    }

    /**
     * @covers Gsa_Sf_Api_Core::initSession
     */
    public function testInitSessionWhenSessionIsNotSet(): void
    {
        session_destroy();

        $this->assertTrue((session_status() == PHP_SESSION_NONE));

        $method = self::getMethod('initSession');
        $method->invoke(new Gsa_Sf_Api_Core);

        $this->assertTrue((session_status() == PHP_SESSION_ACTIVE));
    }

    /**
     * @covers Gsa_Sf_Api_Core::getTokenUrl
     */
    public function testTokenUrlReturn(): void
    {
        $object = new Gsa_Sf_Api_Core;
        $method = self::getMethod('getTokenUrl');

        $this->assertEquals(
            $method->invoke($object),
            $object::LOGIN_URI . $object::TOKEN_URL
        );
    }
}
