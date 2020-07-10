<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Gsa_Sf_Api_Curl
 */
class Gsa_Sf_Api_CurlTest extends TestCase
{
    private $object;

    public function setUp(): void
    {
        $this->object = new Gsa_Sf_Api_Curl('', '', '');
    }

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
        $class = new ReflectionClass('Gsa_Sf_Api_Curl');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setOptions
     * @covers Gsa_Sf_Api_Curl::init
     * @covers Gsa_Sf_Api_Curl::setUrl
     * @covers Gsa_Sf_Api_Curl::setHeader
     * @covers Gsa_Sf_Api_Curl::setReturnTransfer
     * @covers Gsa_Sf_Api_Curl::setHttpHeader
     */
    public function testSetOptionGetValid()
    {
        try {

            $init = self::getMethod('init');
            $setOptions = self::getMethod('setOptions');
            $setUrl = self::getMethod('setUrl');
            $setHeader = self::getMethod('setHeader');
            $setReturnTransfer = self::getMethod('setReturnTransfer');
            $setHttpHeader = self::getMethod('setHttpHeader');

            // Create a stub for the SomeClass class.
            $object = $this->getMockBuilder('Gsa_Sf_Api_Curl')
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

            $init->invoke($object);
            $setOptions->invoke($object, 'get');

        } catch (Exception $e) {

            $this->fail('Test failed!');
            exit;
        }

        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setOptions
     * @covers Gsa_Sf_Api_Curl::init
     * @covers Gsa_Sf_Api_Curl::setUrl
     * @covers Gsa_Sf_Api_Curl::setHeader
     * @covers Gsa_Sf_Api_Curl::setReturnTransfer
     * @covers Gsa_Sf_Api_Curl::setHttpHeader
     * @covers Gsa_Sf_Api_Curl::setPost
     */
    public function testSetOptionCreateValid()
    {
        try {

            $init = self::getMethod('init');
            $setOptions = self::getMethod('setOptions');
            $setUrl = self::getMethod('setUrl');
            $setHeader = self::getMethod('setHeader');
            $setReturnTransfer = self::getMethod('setReturnTransfer');
            $setHttpHeader = self::getMethod('setHttpHeader');
            $setPost = self::getMethod('setPost');

            // Create a stub for the SomeClass class.
            $object = $this->getMockBuilder('Gsa_Sf_Api_Curl')
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

            $init->invoke($object);
            $setOptions->invoke($object, 'create');

        } catch (Exception $e) {

            $this->fail('Test failed!');
            exit;
        }

        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setOptions
     * @covers Gsa_Sf_Api_Curl::init
     * @covers Gsa_Sf_Api_Curl::setUrl
     * @covers Gsa_Sf_Api_Curl::setHeader
     * @covers Gsa_Sf_Api_Curl::setReturnTransfer
     * @covers Gsa_Sf_Api_Curl::setHttpHeader
     * @covers Gsa_Sf_Api_Curl::setCustomRequestPath
     */
    public function testSetOptionEditValid()
    {
        try {

            $init = self::getMethod('init');
            $setOptions = self::getMethod('setOptions');
            $setUrl = self::getMethod('setUrl');
            $setHeader = self::getMethod('setHeader');
            $setReturnTransfer = self::getMethod('setReturnTransfer');
            $setHttpHeader = self::getMethod('setHttpHeader');
            $setCustomRequestPath = self::getMethod('setCustomRequestPath');

            // Create a stub for the SomeClass class.
            $object = $this->getMockBuilder('Gsa_Sf_Api_Curl')
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

            $init->invoke($object);
            $setOptions->invoke($object, 'edit');

        } catch (Exception $e) {

            $this->fail('Test failed!');
            exit;
        }

        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setOptions
     * @covers Gsa_Sf_Api_Curl::init
     * @covers Gsa_Sf_Api_Curl::setUrl
     * @covers Gsa_Sf_Api_Curl::setHeader
     * @covers Gsa_Sf_Api_Curl::setReturnTransfer
     * @covers Gsa_Sf_Api_Curl::setHttpHeader
     * @covers Gsa_Sf_Api_Curl::setCustomRequestDelete
     */
    public function testSetOptionDeleteValid()
    {
        try {

            $init = self::getMethod('init');
            $setOptions = self::getMethod('setOptions');
            $setUrl = self::getMethod('setUrl');
            $setHeader = self::getMethod('setHeader');
            $setReturnTransfer = self::getMethod('setReturnTransfer');
            $setHttpHeader = self::getMethod('setHttpHeader');
            $setCustomRequestDelete = self::getMethod('setCustomRequestDelete');

            // Create a stub for the SomeClass class.
            $object = $this->getMockBuilder('Gsa_Sf_Api_Curl')
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

            $init->invoke($object);
            $setOptions->invoke($object, 'delete');

        } catch (Exception $e) {

            $this->fail('Test failed!');
            exit;
        }

        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setOptions
     * @covers Gsa_Sf_Api_Curl::init
     */
    public function testSetOptionOtherValid()
    {
        try {

            $init = self::getMethod('init');
            $setOptions = self::getMethod('setOptions');

            // Create a stub for the SomeClass class.
            $object = $this->getMockBuilder('Gsa_Sf_Api_Curl')
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

            $init->invoke($object);
            $setOptions->invoke($object, 'asdasdsad');
            $setOptions->invoke($object, '');
            $setOptions->invoke($object, null);

        } catch (Exception $e) {

            $this->fail('Test failed!');
            exit;
        }

        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setResponse
     */
    public function testThatAResponseWasSetAsString(): void
    {
        $value = '{"response":{"message":"Session expired or invalid"},"status_code":401}';

        $method = self::getMethod('setResponse');
        $method->invoke($this->object, $value);

        $this->assertEquals(json_decode($value, true), $this->object->getResponse());
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setResponse
     */
    public function testThatAResponseWasSetAsArray(): void
    {
        $value = ['array'];

        $method = self::getMethod('setResponse');
        $method->invoke($this->object, $value);

        $this->assertEquals(null, $this->object->getResponse());
    }

    /**
     * @covers Gsa_Sf_Api_Curl::setResponse
     */
    public function testThatAResponseWasSetAsObject(): void
    {
        $value = new stdClass();

        $method = self::getMethod('setResponse');
        $method->invoke($this->object, $value);

        $this->assertEquals(null, $this->object->getResponse());
    }

    /**
     * @covers Gsa_Sf_Api_Curl::getResponse
     */
    public function testThatAResponseWasNotSetReturnedEmpty(): void
    {
        $this->assertEmpty($this->object->getResponse());
    }

    /**
     * @covers Gsa_Sf_Api_Curl::getResponse
     */
    public function testThatAResponseWasSetReturnedArray(): void
    {
        $value = '{"response":{"message":"Session expired or invalid"},"status_code":401}';

        $method = self::getMethod('setResponse');
        $method->invoke($this->object, $value);

        $this->assertEquals(json_decode($value, true), $this->object->getResponse());
        $this->assertTrue(is_array($this->object->getResponse()));
        $this->assertTrue((count($this->object->getResponse()) > 0));
    }
}
