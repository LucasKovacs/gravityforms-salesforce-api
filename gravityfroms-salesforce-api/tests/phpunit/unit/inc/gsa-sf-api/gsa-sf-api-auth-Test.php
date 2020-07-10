<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Gsa_Sf_Api_Auth
 */
class Gsa_Sf_Api_AuthTest extends TestCase
{
    private $object;

    /**
     * @coversNothing
     */
    public function setUp(): void
    {
        $this->object = new Gsa_Sf_Api_Auth;
    }

    /**
     * @coversNothing
     */
    public function tearDown(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY');

        unset($_SESSION);
    }

    /**
     * @covers Gsa_Sf_Api_Auth::sendAuthenticationRequest
     * @covers Gsa_Sf_Api_Core::getTokenUrl
     * @covers Gsa_Sf_Api_Auth::prepareParamsString
     * @covers Gsa_Sf_Api_Auth::setAuthData
     */
    public function testSendAuthenticationRequestSuccess(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->object->setAuthData([
            'user.name+salesforce@your-company.com',
            '1wH4idD&E7RY',
            'MbRj4eODzDoqPqy0Auy5xr1n',
        ]);

        $response = [
            'code' => 200,
            'message' => 'success',
            'response' => json_decode(json_encode([
                'access_token' => '00D6A000003Avgo!AQkAQLDPlEvM23WOlabvoJ9ppp12JBiFFbekQx7YEzF4ly34k5di0gWV2rtdthAxMIHRkKQNRgMU90bLUp7HQS4tICbqfw.r',
                'instance_url' => 'https://xxxxxx.my.salesforce.com',
                'id' => 'https://login.salesforce.com/id/MwJlcd7nKMMyRr2qKQ/nopONToglFYFK4NtMP',
                'token_type' => 'Bearer',
                'issued_at' => '8932637671077',
                'signature' => 'sv08z21z82kn7QbjdGWlyruF3zUqesMuLAr9siwp8GA3=',
            ])),
        ];

        $this->assertTrue(count(array_diff_key($response, $this->object->sendAuthenticationRequest())) === 0);
    }

    /**
     * @covers Gsa_Sf_Api_Auth::sendAuthenticationRequest
     * @covers Gsa_Sf_Api_Core::getTokenUrl
     * @covers Gsa_Sf_Api_Auth::prepareParamsString
     */
    public function testSendAuthenticationRequestNoKeysProvided(): void
    {
        $response = '{"code":400,"message":"failed","response":{"error":"invalid_client_id","error_description":"client identifier invalid"}}';

        $this->object->sendAuthenticationRequest();

        $this->assertEquals($response, json_encode($this->object->sendAuthenticationRequest()));
    }

    /**
     * @covers Gsa_Sf_Api_Auth::sendAuthenticationRequest
     * @covers Gsa_Sf_Api_Core::getTokenUrl
     * @covers Gsa_Sf_Api_Auth::prepareParamsString
     * @covers Gsa_Sf_Api_Auth::setAuthData
     */
    public function testSendAuthenticationRequestNoCredsProvided(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $response = '{"code":400,"message":"failed","response":{"error":"invalid_grant","error_description":"authentication failure"}}';

        $this->object->setAuthData([
            '',
            '',
            '',
        ]);

        $this->object->sendAuthenticationRequest();

        $this->assertEquals($response, json_encode($this->object->sendAuthenticationRequest()));
    }

    /**
     * @covers Gsa_Sf_Api_Auth::sendAuthenticationRequest
     * @covers Gsa_Sf_Api_Core::getTokenUrl
     * @covers Gsa_Sf_Api_Auth::prepareParamsString
     * @covers Gsa_Sf_Api_Auth::setAuthData
     */
    public function testSendAuthenticationRequestNoUserProvided(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $response = '{"code":400,"message":"failed","response":{"error":"invalid_grant","error_description":"authentication failure"}}';

        $this->object->setAuthData([
            '',
            '1234567890',
            'MbRj4eODzDoqPqy0Auy5xr1n',
        ]);

        $this->object->sendAuthenticationRequest();

        $this->assertEquals($response, json_encode($this->object->sendAuthenticationRequest()));
    }

    /**
     * @covers Gsa_Sf_Api_Auth::sendAuthenticationRequest
     * @covers Gsa_Sf_Api_Core::getTokenUrl
     * @covers Gsa_Sf_Api_Auth::prepareParamsString
     * @covers Gsa_Sf_Api_Auth::setAuthData
     */
    public function testSendAuthenticationRequestNoPasswordProvided(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $response = '{"code":400,"message":"failed","response":{"error":"invalid_grant","error_description":"authentication failure"}}';

        $this->object->setAuthData([
            'user.name+salesforce@your-company.com',
            '',
            'MbRj4eODzDoqPqy0Auy5xr1n',
        ]);

        $this->object->sendAuthenticationRequest();

        $this->assertEquals($response, json_encode($this->object->sendAuthenticationRequest()));
    }

    /**
     * @covers Gsa_Sf_Api_Auth::sendAuthenticationRequest
     * @covers Gsa_Sf_Api_Core::getTokenUrl
     * @covers Gsa_Sf_Api_Auth::prepareParamsString
     * @covers Gsa_Sf_Api_Auth::setAuthData
     */
    public function testSendAuthenticationRequestNoTokenProvided(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $response = '{"code":400,"message":"failed","response":{"error":"invalid_grant","error_description":"authentication failure"}}';

        $this->object->setAuthData([
            'user.name+salesforce@your-company.com',
            '1234567890',
            '',
        ]);

        $this->object->sendAuthenticationRequest();

        $this->assertEquals($response, json_encode($this->object->sendAuthenticationRequest()));
    }

    /**
     * @covers Gsa_Sf_Api_Auth::checkSession
     */
    public function testCheckSessionBothSet(): void
    {
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->assertTrue($this->object->checkSession());
    }

    /**
     * @covers Gsa_Sf_Api_Auth::checkSession
     */
    public function testCheckSessionNoneSet(): void
    {
        $this->assertFalse($this->object->checkSession());
    }

    /**
     * @covers Gsa_Sf_Api_Auth::checkSession
     */
    public function testCheckSessionAccessTokenSet(): void
    {
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';

        $this->assertFalse($this->object->checkSession());
    }

    /**
     * @covers Gsa_Sf_Api_Auth::checkSession
     */
    public function testCheckSessionInstanceUrlSet(): void
    {
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->assertFalse($this->object->checkSession());
    }

    /**
     * @covers Gsa_Sf_Api_Auth::unsetSession
     */
    public function testUnsetSession(): void
    {
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->assertTrue($this->object->checkSession());

        $this->object->unsetSession();

        $this->assertFalse($this->object->checkSession());
    }

    /**
     * @covers Gsa_Sf_Api_Auth::getAccessToken
     */
    public function testGetAccessToken(): void
    {
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->assertTrue($this->object->checkSession());

        $this->assertEquals($this->object->getAccessToken(), $_SESSION['access_token']);
    }

    /**
     * @covers Gsa_Sf_Api_Auth::getInstanceUrl
     */
    public function testGetInstanceUrl(): void
    {
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->assertTrue($this->object->checkSession());

        $this->assertEquals($this->object->getInstanceUrl(), $_SESSION['instance_url']);
    }
}
