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
class Gsa_Token
{
    /**
     * Generate a new token, or return the existing one
     *
     * @return type
     */
    public function generateToken()
    {
        $token = '';

        if (isset($_SESSION['_token'])) {

            $token = $_SESSION['_token'];
        } else {

            $token = md5(uniqid(microtime(), true));
            $_SESSION['_token'] = $token;
        }

        return $token;
    }

    /**
     * Verify if the token exists
     *
     * @param type $received_token
     *
     * @return boolean
     */
    public function verifyToken($received_token)
    {
        if (!isset($_SESSION['_token'])) {

            return false;
        }

        if (!isset($received_token)) {

            return false;
        }

        if ($_SESSION['_token'] != $received_token) {

            return false;
        }

        return true;
    }

    /**
     * Unset the token
     *
     * @return void
     */
    public function unsetToken()
    {
        unset($_SESSION['_token']);
    }
}

/* end of gsa-token.php */
