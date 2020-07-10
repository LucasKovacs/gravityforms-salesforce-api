<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers Gsa_Sf_Api_Services
 */
class Gsa_Sf_Api_ServicesTest extends TestCase
{
    /**
     *
     * @var \Gsa_Sf_Api_Auth
     */
    private $auth;

    /**
     *
     * @var \Gsa_Sf_Api_Services
     */
    private $object;

    /**
     * @coversNothing
     */
    public function setUp(): void
    {
        $this->auth = new Gsa_Sf_Api_Auth;
        $this->object = new Gsa_Sf_Api_Services;
    }

    /**
     * @coversNothing
     */
    public function tearDown(): void
    {
        $this->auth->unsetSession();
    }

    /**
     * Reflection, set to public private and protected methods.
     * As of PHP5 (>= 5.3.2)
     *
     * @coversNothing
     */
    protected static function getMethod($name): ReflectionMethod
    {
        $class = new ReflectionClass('Gsa_Sf_Api_Services');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     *
     *
     * @method init
     *
     *
     */

    /**
     * @covers Gsa_Sf_Api_Services::init
     */
    public function testInitMethodHasSessionSet(): void
    {
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->object->init();

        $this->assertTrue(true);
    }

    /**
     * @covers Gsa_Sf_Api_Services::init
     *
     * @expectedException Exception
     * @expectedExceptionMessage No Auth session detected! Please start a new session
     */
    public function testInitMethodHasNotSessionSet(): void
    {
        throw new Exception('No Auth session detected! Please start a new session');
    }

    /**
     *
     *
     * @method getAllLeads
     *
     *
     */

    /**
     * @covers Gsa_Sf_Api_Services::getAllLeads
     */
    public function testGetAllLeadsWithoutInit(): void
    {
        $this->assertEquals([
            'response' => null,
            'status_code' => 0,
            'errors' => [
                'error_no' => 3,
                'error' => '<url> malformed',
            ],
        ], $this->object->getAllLeads());
    }

    /**
     * @covers Gsa_Sf_Api_Services::getAllLeads
     */
    public function testGetAllLeadsWithoutAuth(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);

        $this->object->init();

        $this->assertEquals([
            'response' => [
                0 => [
                    'message' => 'Session expired or invalid',
                    'errorCode' => 'INVALID_SESSION_ID',
                ],
            ],
            'status_code' => 401,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ], $this->object->getAllLeads());
    }

    /**
     * @covers Gsa_Sf_Api_Services::getAllLeads
     */
    public function testGetAllLeadsWithAuth(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                'totalSize' => 69,
                'done' => true,
                'records' => [],
            ],
            'status_code' => 200,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $this->assertTrue(count(array_diff_key($response, $this->object->getAllLeads())) === 0);
    }

    /**
     *
     *
     * @method createNewLead
     *
     *
     */

    /**
     * @covers Gsa_Sf_Api_Services::createNewLead
     */
    public function testCreateNewLeadWithoutInitAndJSONContentValid(): void
    {
        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->assertEquals([
            'response' => null,
            'status_code' => 0,
            'errors' => [
                'error_no' => 3,
                'error' => '<url> malformed',
            ],
        ], $this->object->createNewLead(json_encode($content)));
    }

    /**
     * @covers Gsa_Sf_Api_Services::createNewLead
     */
    public function testCreateNewLeadWithoutAuthAndJSONContentValid(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);

        $this->object->init();

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->assertEquals([
            'response' => [
                0 => [
                    'message' => 'Session expired or invalid',
                    'errorCode' => 'INVALID_SESSION_ID',
                ],
            ],
            'status_code' => 401,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ], $this->object->createNewLead(json_encode($content)));
    }

    /**
     * @covers Gsa_Sf_Api_Services::createNewLead
     */
    public function testCreateNewLeadWithAuthAndNotJSONContentValid(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                0 => [
                    'message' => 'Unexpected character (\'-\' (code 45)) in numeric value: expected digit (0-9) to follow minus sign, for valid numeric value at [line:1, column:3]',
                    'errorCode' => 'JSON_PARSER_ERROR',
                ],
            ],
            'status_code' => 400,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->assertEquals($response, $this->object->createNewLead($content));
    }

    /**
     * @covers Gsa_Sf_Api_Services::createNewLead
     */
    public function testCreateNewLeadWithDataMissingAndAuthAndJSONContentValid(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                0 => [
                    'message' => 'Required fields are missing: [Company]',
                    'errorCode' => 'REQUIRED_FIELD_MISSING',
                    'fields' => [
                        0 => 'Company',
                    ],
                ],
            ],
            'status_code' => 400,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Kovacs',
        ];

        $this->assertEquals($response, $this->object->createNewLead(json_encode($content)));
    }

    /**
     * @covers Gsa_Sf_Api_Services::createNewLead
     */
    public function testCreateNewLeadWithAuthAndJSONContentValid(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                'id' => '00Q6A000006RIjYUAW',
                'success' => true,
                'errors' => [],
            ],
            'status_code' => 201,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->object->createNewLead(json_encode($content));

        $this->assertNotEmpty($this->object->getElementId());

        $this->object->deleteLeadById($this->object->getElementId());
    }

    /**
     * @covers Gsa_Sf_Api_Services::createNewLead
     */
    public function testCreateNewLeadDuplicatedWithAuthAndJSONContentValid(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                0 => [
                    'message' => 'You\'re creating a duplicate record. We recommend you use an existing record instead.',
                    'errorCode' => 'DUPLICATES_DETECTED',
                    'fields' => [],
                ],
            ],
            'status_code' => 400,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        // create first lead
        $this->object->createNewLead(json_encode($content));

        // create second lead and assert
        $this->assertEquals($response, $this->object->createNewLead(json_encode($content)));

        // delete everything
        $this->object->deleteLeadById($this->object->getElementId());
    }

    /**
     *
     *
     * @method showLeadById
     *
     *
     */

    /**
     * @covers Gsa_Sf_Api_Services::showLeadById
     */
    public function testShowLeadByIdWithoutInit(): void
    {
        $this->assertEquals([
            'response' => null,
            'status_code' => 0,
            'errors' => [
                'error_no' => 3,
                'error' => '<url> malformed',
            ],
        ], $this->object->showLeadById(123));
    }

    /**
     * @covers Gsa_Sf_Api_Services::showLeadById
     */
    public function testShowLeadByIdWithoutAuth(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);

        $this->object->init();

        $this->assertEquals([
            'response' => [
                0 => [
                    'message' => 'Session expired or invalid',
                    'errorCode' => 'INVALID_SESSION_ID',
                ],
            ],
            'status_code' => 401,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ], $this->object->showLeadById(123));
    }

    /**
     * @covers Gsa_Sf_Api_Services::showLeadById
     */
    public function testShowLeadByIdWithAuthAndValidId(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => null,
            'status_code' => 204,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->object->createNewLead(json_encode($content));

        $this->assertNotEmpty($this->object->getElementId());

        $this->assertEquals(
            $this->object->getElementId(),
            $this->object->showLeadById($this->object->getElementId())['response']['Id']
        );

        $this->object->deleteLeadById($this->object->getElementId());
    }

    /**
     * @covers Gsa_Sf_Api_Services::showLeadById
     */
    public function testShowLeadByIdWithAuthAndInvalidId(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                0 => [
                    'errorCode' => 'NOT_FOUND',
                    'message' => 'Provided external ID field does not exist or is not accessible: 9999999',
                ],
            ],
            'status_code' => 404,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $this->assertEquals($response, $this->object->showLeadById(9999999));
        $this->assertEquals($response, $this->object->showLeadById('9999999'));

        $response['response'][0]['message'] = 'Provided external ID field does not exist or is not accessible: 0';
        $this->assertEquals($response, $this->object->showLeadById(0));
        $this->assertEquals($response, $this->object->showLeadById(''));
        $this->assertEquals($response, $this->object->showLeadById(null));
    }

    /**
     *
     *
     * @method editLeadById
     *
     *
     */

    /**
     * @covers Gsa_Sf_Api_Services::editLeadById
     */
    public function testEditLeadByIdWithoutInit(): void
    {
        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->assertEquals([
            'response' => null,
            'status_code' => 0,
            'errors' => [
                'error_no' => 3,
                'error' => '<url> malformed',
            ],
        ], $this->object->editLeadById(123, json_encode($content)));
    }

    /**
     * @covers Gsa_Sf_Api_Services::editLeadById
     */
    public function testEditLeadByIdWithoutAuthAndContentValid(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);

        $this->object->init();

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->assertEquals([
            'response' => [
                0 => [
                    'message' => 'Session expired or invalid',
                    'errorCode' => 'INVALID_SESSION_ID',
                ],
            ],
            'status_code' => 401,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ], $this->object->editLeadById(12345, json_encode($content)));
    }

    /**
     * @covers Gsa_Sf_Api_Services::editLeadById
     */
    public function testEditLeadByIdWithAuthAndValidIdAndValidContent(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                'id' => '00Q6A000006RIjYUAW',
                'success' => true,
                'errors' => [],
            ],
            'status_code' => 201,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $new_content = [
            'FirstName' => 'Lucas2',
            'LastName' => 'Kovacs2',
            'Company' => 'Test2',
            'Email' => 'lkovacs2@test.net',
        ];

        $this->object->createNewLead(json_encode($content));

        $create_id = $this->object->getElementId();

        $this->assertNotEmpty($create_id);

        $this->object->editLeadById($create_id, json_encode($new_content));

        $this->assertEquals($create_id, $this->object->getElementId());

        $this->assertEquals(
            $new_content['FirstName'],
            $this->object->showLeadById($this->object->getElementId())['response']['FirstName']
        );

        $this->object->deleteLeadById($create_id);
    }

    /**
     * @covers Gsa_Sf_Api_Services::editLeadById
     */
    public function testEditLeadByIdWithAuthAndInvalidId(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];
        $response = [
            'response' => [
                0 => [
                    'errorCode' => 'NOT_FOUND',
                    'message' => 'Provided external ID field does not exist or is not accessible: 9999999',
                ],
            ],
            'status_code' => 404,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $this->assertEquals($response, $this->object->editLeadById(9999999, json_encode($content)));
        $this->assertEquals($response, $this->object->editLeadById('9999999', json_encode($content)));

        $response['response'][0]['message'] = 'Provided external ID field does not exist or is not accessible: 0';
        $this->assertEquals($response, $this->object->editLeadById(0, json_encode($content)));
        $this->assertEquals($response, $this->object->editLeadById('', json_encode($content)));
        $this->assertEquals($response, $this->object->editLeadById(null, json_encode($content)));
    }

    /**
     *
     *
     * @method deleteLeadById
     *
     *
     */

    /**
     * @covers Gsa_Sf_Api_Services::deleteLeadById
     */
    public function testDeleteLeadByIdWithoutInit(): void
    {
        $this->assertEquals([
            'response' => null,
            'status_code' => 0,
            'errors' => [
                'error_no' => 3,
                'error' => '<url> malformed',
            ],
        ], $this->object->deleteLeadById(123));
    }

    /**
     * @covers Gsa_Sf_Api_Services::deleteLeadById
     */
    public function testDeleteLeadByIdWithoutAuth(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);

        $this->object->init();

        $this->assertEquals([
            'response' => [
                0 => [
                    'message' => 'Session expired or invalid',
                    'errorCode' => 'INVALID_SESSION_ID',
                ],
            ],
            'status_code' => 401,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ], $this->object->deleteLeadById(123));
    }

    /**
     * @covers Gsa_Sf_Api_Services::deleteLeadById
     */
    public function testDeleteLeadByIdWithAuthAndValidId(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => null,
            'status_code' => 204,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $content = [
            'FirstName' => 'Sacul',
            'LastName' => 'Scavok',
            'Company' => 'TsEt',
            'Email' => 'sscavok@test.net',
        ];

        $this->object->createNewLead(json_encode($content));

        $this->assertNotEmpty($this->object->getElementId());

        $this->assertEquals($response, $this->object->deleteLeadById($this->object->getElementId()));
    }

    /**
     * @covers Gsa_Sf_Api_Services::deleteLeadById
     */
    public function testDeleteLeadByIdWithAuthAndInvalidId(): void
    {
        putenv('SF_API_OAUTH_CLIENT_ID_KEY=keykeykeykey');
        putenv('SF_API_OAUTH_CLIENT_SECRET_KEY=8545616818588193606');

        $this->auth->setAuthData([
            'user.name+salesforce@your-company.com',
            '9cgggFN7n8&#',
            'Ixq7fjGhPEQ8BT490E4g5XeX',
        ]);
        $this->auth->sendAuthenticationRequest();

        $this->object->init();

        $response = [
            'response' => [
                0 => [
                    'errorCode' => 'NOT_FOUND',
                    'message' => 'Provided external ID field does not exist or is not accessible: 9999999',
                ],
            ],
            'status_code' => 404,
            'errors' => [
                'error_no' => 0,
                'error' => '',
            ],
        ];

        $this->assertEquals($response, $this->object->deleteLeadById(9999999));
        $this->assertEquals($response, $this->object->deleteLeadById('9999999'));

        $response['response'][0]['message'] = 'Provided external ID field does not exist or is not accessible: 0';
        $this->assertEquals($response, $this->object->deleteLeadById(0));
        $this->assertEquals($response, $this->object->deleteLeadById(''));
        $this->assertEquals($response, $this->object->deleteLeadById(null));
    }

    /**
     * @covers Gsa_Sf_Api_Services::setElementId
     */
    public function testSetElementById(): void
    {
        $value = 12345;

        $method = self::getMethod('setElementId');
        $method->invoke($this->object, $value);

        $this->assertEquals($value, $this->object->getElementId());
    }

    /**
     * @covers Gsa_Sf_Api_Services::getElementId
     */
    public function testGetElementById(): void
    {
        $value = 12345;

        $method = self::getMethod('setElementId');
        $method->invoke($this->object, $value);

        $this->assertEquals($value, $this->object->getElementId());
    }

    /**
     * @covers Gsa_Sf_Api_Services::getServicesUrl
     */
    public function testGetServicesUrl(): void
    {
        $_SESSION['access_token'] = '00DOnvg2Dahv3cLZgOksPTsDBO9UU3VT1RtitK3Fx20Xsa4_Meen3qpKH1WUN_2AoVzsdInYfiQORQVTuovcEygW5.PQAkQA!ogvA300000A6weg';
        $_SESSION['instance_url'] = 'https://xxxxxx.my.salesforce.com';

        $this->object->init();

        $method = self::getMethod('getServicesUrl');

        $this->assertEquals(
            $method->invoke($this->object),
            'https://xxxxxx.my.salesforce.com/' . $this->object::SERVICES_URL . '/' . $this->object::SERVICES_VERSION . '/'
        );
    }
}
