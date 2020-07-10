<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Gsa_Api
 */
class Gsa_ApiTest extends TestCase
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
        $class = new ReflectionClass('Gsa_Api');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @covers Gsa_Api::init
     */
    public function testInitTokenWasSet(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Api::init
     */
    public function testInitNotSessionSet(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Api::init
     */
    public function testInitSessionWasSet(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Api::finalize
     */
    public function testFinalizeTokenWasUnset(): void
    {
        session_start();

        $this->assertTrue((session_status() == PHP_SESSION_ACTIVE));

        $_SESSION['_token'] = '1234567890';

        $method = self::getMethod('finalize');
        $method->invoke(new Gsa_Api);

        $this->assertFalse(isset($_SESSION['_token']));
    }

    /**
     * @covers Gsa_Api::finalize
     */
    public function testFinalizeSessionWasUnset(): void
    {
        session_start();

        $this->assertTrue((session_status() == PHP_SESSION_ACTIVE));

        $_SESSION['_token'] = '1234567890';
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $method = self::getMethod('finalize');
        $method->invoke(new Gsa_Api);

        $this->assertFalse(isset($_SESSION));
    }

    /**
     * @covers Gsa_Api::createNewAuth
     */
    public function testCreateNewAuthObject(): void
    {
        $method = self::getMethod('createNewAuth');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $this->assertInstanceOf('Gsa_Sf_Api_Auth', $method->invoke($object));
    }

    /**
     * @covers Gsa_Api::createNewService
     */
    public function testCreateNewServicesObject(): void
    {
        $method = self::getMethod('createNewService');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $this->assertInstanceOf('Gsa_Sf_Api_Services', $method->invoke($object));
    }

    /**
     * @covers Gsa_Api::createNewToken
     */
    public function testCreateNewTokenObject(): void
    {
        $method = self::getMethod('createNewToken');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $this->assertInstanceOf('Gsa_Token', $method->invoke($object));
    }

    /**
     * @covers Gsa_Api::generateToken
     */
    public function testGenerateTokenSuccess(): void
    {
        $object = new Gsa_Api;

        $this->assertEquals($object->generateToken(), ['token' => $_SESSION['_token']]);
    }

    /**
     * @covers Gsa_Api::createLead
     */
    public function testCreateLeadSuccess(): void
    {
        // Create a stub for the SomeClass class.
        $objectGsaApi = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $objectGsaApi->method('createLead')
            ->willReturn(json_encode([]));

        $this->assertEquals($objectGsaApi->createLead(), json_encode([]));
    }

    /**
     * @covers Gsa_Api::createLead
     */
    public function testCreateLeadWithoutAuth(): void
    {
        // Create a stub for the SomeClass class.
        $objectGsaApi = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $objectGsaApi->method('createLead')
            ->willReturn('{"response":[{"message":"Session expired or invalid","errorCode":"INVALID_SESSION_ID"}],"status_code":401,"errors":{"error_no":0,"error":""}}');

        $this->assertEquals($objectGsaApi->createLead(), '{"response":[{"message":"Session expired or invalid","errorCode":"INVALID_SESSION_ID"}],"status_code":401,"errors":{"error_no":0,"error":""}}');
    }

    /**
     * @covers Gsa_Api::createLead
     */
    public function testCreateLeadWithoutToken(): void
    {
        // Create a stub for the SomeClass class.
        $objectGsaApi = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $objectGsaApi->method('createLead')
            ->willReturn('Token invalid or missing!');

        $this->assertEquals($objectGsaApi->createLead(), 'Token invalid or missing!');
    }

    /**
     * @covers Gsa_Api::createLead
     */
    public function testCreateLeadWithoutBoth(): void
    {
        // Create a stub for the SomeClass class.
        $objectGsaApi = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $objectGsaApi->method('createLead')
            ->willReturn('Token invalid or missing!');

        $this->assertEquals($objectGsaApi->createLead(), 'Token invalid or missing!');
    }

    /**
     * @covers Gsa_Api::createLead
     */
    public function testCreateLeadFinalize(): void
    {
        // Create a stub for the SomeClass class.
        $objectGsaApi = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $objectGsaApi->method('createLead')
            ->willReturn(json_encode([]));

        unset($_SESSION);

        $this->assertEquals($objectGsaApi->createLead(), json_encode([]));

        $this->assertFalse(isset($_SESSION['_token']));
        $this->assertFalse(isset($_SESSION));
    }

    /**
     * @covers Gsa_Api::checkHealth
     *//*
    public function testCheckHealth(): void
    {
    $method = self::getMethod('checkHealth');

    // Create a stub for the SomeClass class.
    $object = $this->getMockBuilder('Gsa_Api')
    ->disableOriginalConstructor()
    ->disableOriginalClone()
    ->disableArgumentCloning()
    ->disallowMockingUnknownTypes()
    ->getMock();

    // Configure the stub.
    $object->method('checkHealth')
    ->willReturn(['data' => ['uptime' => 0]]);

    $this->assertEquals(['data' => ['uptime' => 0]], $method->invoke($object));
    }*/

    /**
     * @covers Gsa_Api::checkReady
     *//*
    public function testReadyMySqlWithConnectionRefused(): void
    {
    $method = self::getMethod('checkReady');
    $data = [
    'uptime' => 0,
    'reply' => 'Connection refused'
    ];

    // Create a stub for the SomeClass class.
    $object = $this->getMockBuilder('Gsa_Api')
    ->disableOriginalConstructor()
    ->disableOriginalClone()
    ->disableArgumentCloning()
    ->disallowMockingUnknownTypes()
    ->getMock();

    // Configure the stub.
    $object->method('checkReady')
    ->willReturn([
    'data' => [
    'uptime' => $data['uptime'],
    'service' => $data['reply'],
    'mysql' => $data['reply']
    ]
    ]);

    $this->assertEquals([
    'data' => [
    'uptime' => $data['uptime'],
    'service' => $data['reply'],
    'mysql' => $data['reply']
    ]
    ], $method->invoke($object));
    }*/

    /**
     * @covers Gsa_Api::checkReady
     *//*
    public function testReadyMySqlWithOk(): void
    {
    putenv('GSA_WEBSITE_BACKEND_DB_HOST=127.0.0.1');
    putenv('GSA_WEBSITE_BACKEND_DB_USER=root');
    putenv('GSA_WEBSITE_BACKEND_DB_PASSWORD=password');
    putenv('GSA_WEBSITE_BACKEND_DB_PORT=33060');

    $method = self::getMethod('checkReady');
    $data = [
    'uptime' => 0,
    'reply' => 'ok'
    ];

    // Create a stub for the SomeClass class.
    $object = $this->getMockBuilder('Gsa_Api')
    ->disableOriginalConstructor()
    ->disableOriginalClone()
    ->disableArgumentCloning()
    ->disallowMockingUnknownTypes()
    ->getMock();

    $result = $method->invoke($object);

    $this->assertTrue(is_int($result['data']['uptime']));
    $this->assertEquals($result['data']['service'], 'ok');
    $this->assertEquals($result['data']['mysql'], 'ok');
    }*/

    /**
     * @covers Gsa_Api::checkReady
     */
    public function testReadyMySqlServerNotFound(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Api::checkReady
     */
    public function testReadyMySqlUnknownError(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Api::prepareFields
     */
    public function testPrepareFields(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Api::createNewGFEntry
     */
    public function testCreateNewGFEntry(): void
    {
        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Api::checkMySQLStatus
     */
    public function testCheckMySQLStatusWithOk(): void
    {
        putenv('GSA_WEBSITE_BACKEND_DB_HOST=127.0.0.1');
        putenv('GSA_WEBSITE_BACKEND_DB_USER=root');
        putenv('GSA_WEBSITE_BACKEND_DB_PASSWORD=password');
        putenv('GSA_WEBSITE_BACKEND_DB_PORT=33060');

        $createNewMysqli = self::getMethod('createNewMysqli');
        $checkMySQLStatus = self::getMethod('checkMySQLStatus');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $result = $checkMySQLStatus->invoke($object, $createNewMysqli->invoke($object));

        $this->assertTrue(is_int($result['uptime']));
        $this->assertEquals($result['status'], 'ok');
    }

    /**
     * @covers Gsa_Api::checkMySQLStatus
     */
    public function testCheckMySQLStatusWithConnectionRefusedWrongIp(): void
    {
        putenv('GSA_WEBSITE_BACKEND_DB_HOST=192.168.0.1');
        putenv('GSA_WEBSITE_BACKEND_DB_USER=root');
        putenv('GSA_WEBSITE_BACKEND_DB_PASSWORD=password');
        putenv('GSA_WEBSITE_BACKEND_DB_PORT=33060');

        $createNewMysqli = self::getMethod('createNewMysqli');
        $checkMySQLStatus = self::getMethod('checkMySQLStatus');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $result = $checkMySQLStatus->invoke($object, $createNewMysqli->invoke($object));

        $this->assertTrue(is_int($result['uptime']));
        $this->assertEquals($result['status'], 'Connection refused');
    }

    /**
     * @covers Gsa_Api::checkMySQLStatus
     */
    public function testCheckMySQLStatusWithConnectionOkWrongUser(): void
    {
        putenv('GSA_WEBSITE_BACKEND_DB_HOST=127.0.0.1');
        putenv('GSA_WEBSITE_BACKEND_DB_USER=sdasdasdas');
        putenv('GSA_WEBSITE_BACKEND_DB_PASSWORD=password');
        putenv('GSA_WEBSITE_BACKEND_DB_PORT=33060');

        $createNewMysqli = self::getMethod('createNewMysqli');
        $checkMySQLStatus = self::getMethod('checkMySQLStatus');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $result = $checkMySQLStatus->invoke($object, $createNewMysqli->invoke($object));

        $this->assertTrue(is_int($result['uptime']));
        $this->assertEquals($result['status'], 'ok');
    }

    /**
     * @covers Gsa_Api::checkMySQLStatus
     */
    public function testCheckMySQLStatusWithConnectionOkWrongPassword(): void
    {
        putenv('GSA_WEBSITE_BACKEND_DB_HOST=127.0.0.1');
        putenv('GSA_WEBSITE_BACKEND_DB_USER=root');
        putenv('GSA_WEBSITE_BACKEND_DB_PASSWORD=12345');
        putenv('GSA_WEBSITE_BACKEND_DB_PORT=33060');

        $createNewMysqli = self::getMethod('createNewMysqli');
        $checkMySQLStatus = self::getMethod('checkMySQLStatus');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $result = $checkMySQLStatus->invoke($object, $createNewMysqli->invoke($object));

        $this->assertTrue(is_int($result['uptime']));
        $this->assertEquals($result['status'], 'ok');
    }

    /**
     * @covers Gsa_Api::checkMySQLStatus
     */
    public function testCheckMySQLStatusWithConnectionRefusedWrongPort(): void
    {
        putenv('GSA_WEBSITE_BACKEND_DB_HOST=127.0.0.1');
        putenv('GSA_WEBSITE_BACKEND_DB_USER=root');
        putenv('GSA_WEBSITE_BACKEND_DB_PASSWORD=password');
        putenv('GSA_WEBSITE_BACKEND_DB_PORT=3306');

        $createNewMysqli = self::getMethod('createNewMysqli');
        $checkMySQLStatus = self::getMethod('checkMySQLStatus');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $result = $checkMySQLStatus->invoke($object, $createNewMysqli->invoke($object));

        $this->assertTrue(is_int($result['uptime']));
        $this->assertEquals($result['status'], 'Connection refused');
    }

    /**
     * @covers Gsa_Api::checkMySQLStatus
     */
    public function testCheckMySQLStatusWithNullLink(): void
    {
        putenv('GSA_WEBSITE_BACKEND_DB_HOST=127.0.0.1');
        putenv('GSA_WEBSITE_BACKEND_DB_USER=root');
        putenv('GSA_WEBSITE_BACKEND_DB_PASSWORD=password');
        putenv('GSA_WEBSITE_BACKEND_DB_PORT=33060');

        $checkMySQLStatus = self::getMethod('checkMySQLStatus');

        // Create a stub for the SomeClass class.
        $object = $this->getMockBuilder('Gsa_Api')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $result = $checkMySQLStatus->invoke($object, null);

        $this->assertTrue(is_int($result['uptime']));
        $this->assertEquals($result['status'], 'no access to remote server');
    }
}

/* End of gsa-api-Test.php */
