<?php
/**
 * GSA API
 *
 * PHP Version 7+
 *
 * @category Classes
 * @package  gravityfroms-salesforce-api
 * @author   Lucas Kovács
 * @license  https://github.com/LucasKovacs Lucas Kovács
 * @link     https://github.com/LucasKovacs
 * @version  1.0.0
 */

/**
 * API Class
 */
class Gsa_Api
{

    /**
     *
     * @var \Gsa_Token
     */
    private $token;

    /**
     *
     * @var \Gsa_Sf_Api_Auth
     */
    private $auth;

    /**
     *
     * @var \Gsa_Sf_Api_Services
     */
    private $services;

    /**
     * Construct
     */
    public function __construct()
    {
        // prepare auth
        $this->auth = $this->createNewAuth();

        // prepare token
        $this->token = $this->createNewToken();
    }

    /**
     * Init
     *
     * @throws Exception
     *
     * @return void
     */
    private function init()
    {
        try {
            $token = isset($_POST['token']) ? $_POST['token'] : null;

            //if (!$this->token->verifyToken($token)) {
            if (!empty($token)) {
                //@codeCoverageIgnoreStart
                throw new Exception('Token invalid or missing!');
                //@codeCoverageIgnoreEnd
            }

            if (!$this->auth->checkSession()) {

                $this->auth->setAuthData([
                    get_option('sf_user_email'),
                    get_option('sf_user_password'),
                    get_option('sf_user_token'),
                ]);

                // start authentication
                $response = $this->auth->sendAuthenticationRequest();

                if (!$this->auth->checkSession()) {
                    return $response;
                }
            }

            // create new service
            $this->services = $this->createNewService();
            $this->services->init();
            //@codeCoverageIgnoreStart
        } catch (Exception $e) {

            die($e->getMessage());
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Finalize SESSIONS
     *
     * @return void
     */
    private function finalize()
    {
        if ($this->token instanceof Gsa_Token) {

            $this->token->unsetToken();
        }

        if ($this->auth instanceof Gsa_Sf_Api_Auth) {

            $this->auth->unsetSession();
        }
    }

    /**
     * Create new Auth object
     *
     * @return \Gsa_Sf_Api_Auth
     */
    private function createNewAuth()
    {
        return new Gsa_Sf_Api_Auth;
    }

    /**
     * Create new Services object
     *
     * @return \Gsa_Sf_Api_Services
     */
    private function createNewService()
    {
        return new Gsa_Sf_Api_Services;
    }

    /**
     * Create new Token object
     *
     * @return \Gsa_Token
     */
    private function createNewToken()
    {
        return new Gsa_Token;
    }

    /**
     * Generate a new token or return an existing one
     *
     * @return json
     */
    public function generateToken()
    {
        try {

            return ['token' => $this->token->generateToken()];
            //@codeCoverageIgnoreStart
        } catch (Exception $e) {

            die(json_encode(['error' => $e->getMessage()]));
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Get all leads
     *
     * @return json
     */
    public function getLeads()
    {
        try {

            $this->init();

            if (!$this->services instanceof Gsa_Sf_Api_Services) {

                throw new Exception('Error: something is not right!');
            }

            $result = $this->services->getAllLeads();

            $this->finalize();

            return $result;
        } catch (Exception $e) {

            die(json_encode(['error' => $e->getMessage()]));
        }
    }

    /**
     * Create a new lead
     *
     * @return json
     */
    public function createLead()
    {
        try {
            $this->init();

            if ($this->services instanceof Gsa_Sf_Api_Services) {

                $result = $this->services->createNewLead(
                    $this->prepareFields()
                );
            }

            // create a new Gravity Forms entry
            $gf_response = $this->createNewGFEntry();

            $this->finalize();

            return [
                'status_code' => 201,
                'response' => [
                    'success' => true,
                    'details' => [
                        'sales_force' => [
                            'response' => $result ?? 'needs_setup',
                        ],
                        'gravity_forms' => [
                            'response' => $gf_response ? 'success' : 'not success',
                        ],
                    ],
                ],
            ];
            //@codeCoverageIgnoreStart
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Get a lead
     *
     * @return json
     */
    public function getLead()
    {
        try {
            $this->init();

            if (!$this->services instanceof Gsa_Sf_Api_Services) {
                throw new Exception('Error: something is not right!');
            }

            $result = $this->services->showLeadById($_POST['id']);

            $this->finalize();

            return $result;
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
    }

    /**
     * Edit a lead
     *
     * @return json
     */
    public function editLead()
    {
        try {
            $this->init();

            if (!$this->services instanceof Gsa_Sf_Api_Services) {
                throw new Exception('Error: something is not right!');
            }

            $id = $_POST['id'];
            unset($_POST['id'], $_POST['token']);

            $result = $this->services->editLeadById($id, json_encode($_POST));

            $this->finalize();

            return $result;
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
    }

    /**
     * Delete a lead
     *
     * @return json
     */
    public function deleteLead()
    {
        try {
            $this->init();

            if (!$this->services instanceof Gsa_Sf_Api_Services) {
                throw new Exception('Error: something is not right!');
            }

            $result = $this->services->deleteLeadById($_POST['id']);

            $this->finalize();

            return $result;
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
    }

    /**
     * Check system health
     *
     * @return json
     */
    public function checkHealth()
    {
        try {
            $uptime_raw = @file_get_contents("/proc/uptime");

            return [
                'data' => [
                    'uptime' => intval($uptime_raw),
                ],
            ];
            //@codeCoverageIgnoreStart
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Check if the system is ready
     *
     * @return json
     */
    public function checkReady()
    {
        try {
            // create new mysqli "object"
            $mysql_data = $this->checkMySQLStatus($this->createNewMysqli());

            return [
                'data' => [
                    'uptime' => $mysql_data['uptime'],
                    'service' => $mysql_data['status'],
                    'mysql' => $mysql_data['status'],
                ],
            ];
            //@codeCoverageIgnoreStart
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Check system version
     *
     * @return json
     */
    public function checkVersion()
    {
        try {
            return [
                'meta' => [
                    'count' => 0,
                ],
                'data' => [
                    'uptime' => 0,
                    'version' => getenv('GSA_WEBSITE_BACKEND_RELEASE_VERSION') !== null ? getenv('GSA_WEBSITE_BACKEND_RELEASE_VERSION') : 'not_set',
                ],
            ];
            //@codeCoverageIgnoreStart
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Prepare fields before POST
     *
     * @return string
     */
    private function prepareFields()
    {
        $data = filter_input_array(INPUT_POST);
        $output = [];
        $ignore_fields = [
            'token',
            'Region__c_id_1', 'Region__c_id_2', 'Region__c_id_3',
        ];

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($value == '' or in_array($key, $ignore_fields)) {
                    continue;
                }

                /**
                 * The commented stuff below are just reference, in case at some point
                 * they want to support multiple regions on SF.
                 * Just need to uncomment the line below, and do what the comments below say
                 */

                if ((strpos($key, 'Interest_Types__c') !== false)) {
                    $new_key = substr($key, 0, -2);
                    $output[$new_key] = $output[$new_key] . $value . ';';
                } else {
                    // comment or remove here
                    if (strpos($key, 'Region__c') !== false) {
                        $output['Region__c'] = $value;
                    } else {
                        // till here
                        $output[$key] = $value; // leave this line
                    } // and this one too of course
                }
            }
        }

        return json_encode($output);
    }

    /**
     * Create new Gravity Forms Entry
     *
     * @return void
     */
    private function createNewGFEntry()
    {
        $gf_save_on = get_option('gf_save_on');
        $gf_form_id = get_option('gf_form_id');

        if (((bool) $gf_save_on === true) && ((int) $gf_form_id !== 0) && class_exists('GFAPI')) {
            $data = filter_input_array(INPUT_POST);

            // setup the form
            // I couldn't find a better way to do this, it seems to be the only way
            // to relate the fields
            $new_entry = [
                'form_id' => $gf_form_id,
                // Company Info
                '2' => (string) $data['Company'], // Company Name
                '3' => (string) $data['Industry'], // Business Unit
                '4' => (string) $data['Street'], // Address (Mandatory)
                '6' => (string) $data['City'], // City
                '7' => (string) $data['State'], // State
                '8' => (string) $data['PostalCode'], // ZIP Code
                // Contact
                '23' => (string) $data['FirstName'], // First Name
                '22' => (string) $data['LastName'], // Last Name
                '13' => (string) $data['Title'], // Title
                '17' => (string) $data['Email'], // Email
                '18' => (string) $data['Phone'], // Phone
                // Region of Interest
                '19' => (string) $data['Region__c_1'], // Region 1
                '31' => (string) $data['Region__c_2'], // Region 2
                '34' => (string) $data['Region__c_3'], // Region 3
                // What are you interested in?
                '28.1' => (string) $data['Interest_Types__c_1'], // Interest 1
                '25.1' => (string) $data['Interest_Types__c_2'], // Interest 2
                '38.1' => (string) $data['Interest_Types__c_3'], // Interest 3
                '29.1' => (string) $data['Interest_Types__c_4'], // Interest 4
            ];

            // finally save the form
            return GFAPI::add_entry($new_entry);
        }
    }

    /**
     * Create new mysqli connection
     *
     * @param string $phost MySQLi Server Host
     * @param string $puser MySQLi Server User
     * @param string $ppsw  MySQLi Server Password
     * @param string $pdb   Database
     * @param string $pport MySQLi Server Port
     *
     * @return mixed(mysqli resource/boolean)
     */
    private function createNewMysqli($phost = null, $puser = null, $ppsw = null, $pdb = null, $pport = null)
    {
        // get envs
        $host = getenv('GSA_WEBSITE_BACKEND_DB_HOST') ? getenv('GSA_WEBSITE_BACKEND_DB_HOST') : $phost;
        $user = getenv('GSA_WEBSITE_BACKEND_DB_USER') ? getenv('GSA_WEBSITE_BACKEND_DB_USER') : $puser;
        $psw = getenv('GSA_WEBSITE_BACKEND_DB_PASSWORD') ? getenv('GSA_WEBSITE_BACKEND_DB_PASSWORD') : $ppsw;
        $db = getenv('GSA_WEBSITE_BACKEND_DB_NAME') ? getenv('GSA_WEBSITE_BACKEND_DB_NAME') : $pdb;
        $port = getenv('GSA_WEBSITE_BACKEND_DB_PORT') ? getenv('GSA_WEBSITE_BACKEND_DB_PORT') : $pport;

        return @mysqli_connect($host, $user, $psw, $db, $port);
    }

    /**
     * Check MySQL Status
     *
     * @return array
     */
    private function checkMySQLStatus($link = null): array
    {
        $stats = 0;
        $mysql_reply = 'no access to remote server';

        if (is_null($link)) {
            return [
                'uptime' => $stats,
                'status' => $mysql_reply,
            ];
        }

        if ($link) {
            $stats = intval(explode(' ', mysqli_stat($link))[1]);
        }

        switch (mysqli_connect_errno()) {
            case 0:
                mysqli_close($link); // we don't break here because we want to fall through to "ok"
            case 1045:
                $mysql_reply = 'ok';
                break;
            case 2002:
                $mysql_reply = 'Connection refused';
                break;
            default:
                //@codeCoverageIgnoreStart
                $mysql_reply = 'Unknown response: ' . mysqli_connect_errno() . ': ' . mysqli_connect_error();
                //@codeCoverageIgnoreEnd
        }

        return [
            'uptime' => $stats,
            'status' => $mysql_reply,
        ];
    }
}

/* end of gfsf-api.php */
