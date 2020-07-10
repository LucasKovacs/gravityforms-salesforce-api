<?php
/**
 * GSA SalesForce API Core
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
class Gsa_Sf_Api_Core
{
    /**
     *
     */
    const LOGIN_URI = 'https://login.salesforce.com';

    /**
     *
     */
    const TOKEN_URL = '/services/oauth2/token';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->initSession();
    }

    /**
     * Init session
     *
     * @return void
     */
    private function initSession()
    {
        if (session_status() == PHP_SESSION_NONE) {

            session_start();
        }
    }

    /**
     * Get token URL
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return self::LOGIN_URI . self::TOKEN_URL;
    }
}

/* End of gsa-sf-api-auth-core.php */
