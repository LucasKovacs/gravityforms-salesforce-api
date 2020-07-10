<?php
/**
 * GSA SalesForce API Services
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
class Gsa_Sf_Api_Services extends Gsa_Sf_Api_Core
{
    /**
     *
     */
    const SERVICES_VERSION = 'v40.0';

    /**
     *
     */
    const SERVICES_URL = 'services/data';

    /**
     *
     * @var string
     */
    private $access_token;

    /**
     *
     * @var string
     */
    private $instance_url;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Init class
     */
    public function init()
    {
        try {
            // check session
            $auth = new Gsa_Sf_Api_Auth;

            if ($auth->checkSession()) {

                $this->access_token = $auth->getAccessToken();
                $this->instance_url = $auth->getInstanceUrl();
                //@codeCoverageIgnoreStart
            } else {

                throw new Exception('No Auth session detected! Please start a new session');
            }
            //@codeCoverageIgnoreEnd

            //@codeCoverageIgnoreStart
        } catch (Exception $e) {

            die($e->getMessage());
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Get all leads
     *
     * @return array
     */
    public function getAllLeads()
    {
        $query = "SELECT Id, FirstName, LastName, Email, Company, Street, City, State, PostalCode, Country, Address, Phone, Region__c, Interest_Types__c FROM Lead";
        $url = $this->getServicesUrl() . "query?q=" . urlencode($query);

        $curl = new Gsa_Sf_Api_Curl($this->access_token, $url);
        $result = $curl->run('get');

        return $result;
    }

    /**
     * Create a new lead
     *
     * @param array
     */
    public function createNewLead($content)
    {
        $url = $this->getServicesUrl() . "sobjects/Lead/";

        $curl = new Gsa_Sf_Api_Curl($this->access_token, $url, $content);
        $result = $curl->run('create');

        if (!is_null($result) && isset($result['response']['id'])) {

            $this->setElementId($result['response']['id']);
        }

        return $result;
    }

    /**
     * Show a lead by Id
     *
     * @param type $id
     */
    public function showLeadById($id)
    {
        if (empty($id) or is_null($id)) {

            $id = 0;
        }

        $url = $this->getServicesUrl() . "sobjects/Lead/$id";

        $curl = new Gsa_Sf_Api_Curl($this->access_token, $url);
        $result = $curl->run('get');

        return $result;
    }

    /**
     * Edit a lead by id
     *
     * @param string $id
     * @param json   $content
     *
     * @return array
     */
    public function editLeadById($id, $content)
    {
        if (empty($id) or is_null($id)) {

            $id = 0;
        }

        $url = $this->getServicesUrl() . "sobjects/Lead/$id";

        $curl = new Gsa_Sf_Api_Curl($this->access_token, $url, $content);
        $result = $curl->run('edit');

        return $result;
    }

    /**
     * Delete a lead by id
     *
     * @param string $id
     */
    public function deleteLeadById($id)
    {
        if (empty($id) or is_null($id)) {

            $id = 0;
        }

        $url = $this->getServicesUrl() . "sobjects/Lead/$id";

        $curl = new Gsa_Sf_Api_Curl($this->access_token, $url);
        $result = $curl->run('delete');

        return $result;
    }

    /**
     * Set the element ID
     *
     * @param int $id Element ID
     */
    private function setElementId($id)
    {
        $this->element_id = $id;
    }

    /**
     * Return the element ID
     *
     * @return int
     */
    public function getElementId()
    {
        return $this->element_id;
    }

    /**
     * Build and return the services url
     *
     * @return string
     */
    private function getServicesUrl()
    {
        return $this->instance_url . '/' . self::SERVICES_URL . '/' . self::SERVICES_VERSION . '/';
    }
}

/* End of gsa-sf-api-services.php */
