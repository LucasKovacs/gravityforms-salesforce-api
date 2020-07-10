<?php
/**
 * GSA SalesForce API Authentication
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

class Gsa_Sf_Api_Auth extends Gsa_Sf_Api_Core
{
    /**
     *
     * @var string
     */
    private $grant_type = 'password';

    /**
     *
     * @var string
     */
    private $access_token = '';

    /**
     *
     * @var string
     */
    private $instance_url = '';

    /**
     *
     * @var string
     */
    private $username = '';

    /**
     *
     * @var string
     */
    private $password = '';

    /**
     *
     * @var string
     */
    private $token = '';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        // session start
        parent::__construct();
    }

    /**
     * Send authentication request
     *
     * @param type $type
     *
     * @return type
     *
     * @throws Exception
     */
    public function sendAuthenticationRequest()
    {
        try {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $this->getTokenUrl());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->prepareParamsString());

            $json_response = curl_exec($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($curl);
            $curl_error_no = curl_errno($curl);

            curl_close($curl);

            if ($status != 200) {

                return [
                    'code' => $status,
                    'message' => 'failed',
                    'response' => json_decode($json_response),
                ];
            }

            $this->setSession($json_response);

            return [
                'code' => 200,
                'message' => 'success',
                'response' => json_decode($json_response),
            ];

            //@codeCoverageIgnoreStart
        } catch (Exception $e) {

            die($e->getMessage());
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Get the parameters string
     *
     * @return string
     */
    private function prepareParamsString()
    {
        $params = [
            'grant_type' => $this->grant_type,
            'client_id' => getenv('SF_API_OAUTH_CLIENT_ID_KEY') ? getenv('SF_API_OAUTH_CLIENT_ID_KEY') : '',
            'client_secret' => getenv('SF_API_OAUTH_CLIENT_SECRET_KEY') ? getenv('SF_API_OAUTH_CLIENT_SECRET_KEY') : '',
            'username' => $this->username,
            'password' => $this->password . $this->token,
        ];

        // Initialize the $kv array for later use
        $kv = [];

        foreach ($params as $key => $value) {

            if (isset($params[$key]) && !empty($params[$key])) {

                $kv[] = stripslashes($key) . "=" . urlencode(stripslashes($value));
            }
        }

        // Create a query string with join function separted by &
        return join("&", $kv);
    }

    /**
     * Set session data. This finishes the session auth loop
     *
     * @param strong $json_response JSON Response
     *
     * @throws Exception
     *
     * @return void
     */
    private function setSession($json_response)
    {
        try {
            $response = json_decode($json_response, true);

            $this->access_token = $response['access_token'];
            $this->instance_url = $response['instance_url'];

            if (!isset($this->access_token) || $this->access_token == "") {
                //@codeCoverageIgnoreStart
                throw new Exception('Error - access token missing from response!');
                //@codeCoverageIgnoreEnd
            }

            if (!isset($this->instance_url) || $this->instance_url == "") {
                //@codeCoverageIgnoreStart
                throw new Exception('Error - instance URL missing from response!');
                //@codeCoverageIgnoreEnd
            }

            $_SESSION['access_token'] = $this->access_token;
            $_SESSION['instance_url'] = $this->instance_url;

            //@codeCoverageIgnoreStart
        } catch (Exception $e) {

            die($e->getMessage());
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Check session
     *
     * @throws Exception
     *
     * @return void
     */
    public function checkSession()
    {
        $this->access_token = isset($_SESSION['access_token']) ? $_SESSION['access_token'] : null;
        $this->instance_url = isset($_SESSION['instance_url']) ? $_SESSION['instance_url'] : null;

        if (!isset($this->access_token) or $this->access_token == '') {

            return false;
        }

        if (!isset($this->instance_url) or $this->instance_url == '') {

            return false;
        }

        return true;
    }

    /**
     * Unset the SESSION
     *
     * @return void
     */
    public function unsetSession()
    {
        unset($_SESSION);
        session_destroy();
    }

    /**
     * Get the access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Get the instance url
     *
     * @return string
     */
    public function getInstanceUrl()
    {
        return $this->instance_url;
    }

    /**
     * Set auth data
     *
     * @param type $auth_data
     */
    public function setAuthData($auth_data)
    {
        $this->username = $auth_data[0];
        $this->password = $auth_data[1];
        $this->token = $auth_data[2];
    }
}

/* End of gsa-sf-api-auth */
