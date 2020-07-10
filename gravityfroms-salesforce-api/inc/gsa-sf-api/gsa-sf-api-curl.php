<?php
/**
 * GSA SalesForce API Curl
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
class Gsa_Sf_Api_Curl
{
    /**
     *
     * @var type
     */
    private $curl;

    /**
     *
     * @var string
     */
    private $response;

    /**
     *
     * @var int
     */
    private $status_code;

    /**
     *
     * @var array
     */
    private $errors;

    /**
     *
     * @var string
     */
    private $token;

    /**
     *
     * @var string
     */
    private $server;

    /**
     *
     * @var array
     */
    private $content;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($token, $server, $content = '')
    {
        $this->token = $token;
        $this->server = $server;
        $this->content = $content;
    }

    /**
     *
     * @param type $type
     */
    public function run($type)
    {
        try {
            $allowed_types = ['get', 'create', 'edit', 'delete'];

            if (!in_array($type, $allowed_types)) {

                //@codeCoverageIgnoreStart
                throw new Exception('The allowed $type can only be "get", "create", "edit" or "delete".');
                //@codeCoverageIgnoreEnd
            }

            // start
            $this->init();
            $this->setOptions($type);
            $this->exec();
            $this->close();

            return [
                'response' => $this->getResponse(),
                'status_code' => $this->getStatusCode(),
                'errors' => $this->getErrors(),
            ];

            //@codeCoverageIgnoreStart
        } catch (Exception $e) {

            die($e->getMessage());
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     *
     * cURL ACTIONS
     *
     */

    /**
     * cURL Init
     */
    private function init()
    {
        $this->curl = curl_init();
    }

    /**
     * Set options for the curl
     *
     * @param string $type
     */
    private function setOptions($type)
    {
        // set a options index based on the requested type
        $actions = [
            'get' => [
                'setUrl', 'setHeader', 'setReturnTransfer', 'setHttpHeader',
            ],
            'create' => [
                'setUrl', 'setHeader', 'setReturnTransfer', ['setHttpHeader' => true], 'setPost',
            ],
            'edit' => [
                'setUrl', 'setHeader', 'setReturnTransfer', ['setHttpHeader' => true], 'setCustomRequestPath',
            ],
            'delete' => [
                'setUrl', 'setHeader', 'setReturnTransfer', 'setHttpHeader', 'setCustomRequestDelete',
            ],
        ];

        if (isset($actions[$type])) {

            foreach ($actions[$type] as $options) {

                if (is_array($options)) {

                    $this->{key($options)}($options[key($options)]);
                } else {

                    $this->$options();
                }
            }
        }
    }

    /**
     * cURL Exec
     */
    private function exec()
    {
        $this->setResponse(curl_exec($this->curl));
        $this->setStatusCode();
        $this->setErrors();
    }

    /**
     * cURL Close
     */
    private function close()
    {
        curl_close($this->curl);
    }

    /**
     *
     * Setters & Getters
     *
     */

    /**
     * Set the response and decode it
     *
     * @param array $response
     */
    private function setResponse($response)
    {
        if (!is_array($response) && !is_object($response)) {

            $this->response = json_decode((string) $response, true);
        }
    }

    /**
     * Return the response in JSON format
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }
    /**
     * Set the status code
     *
     * @return void
     */
    private function setStatusCode()
    {
        $this->status_code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    /**
     * Get the status code
     *
     * @return string
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * Set error number and error details
     */
    private function setErrors()
    {
        $this->errors = [
            'error_no' => curl_errno($this->curl),
            'error' => curl_error($this->curl),
        ];
    }

    /**
     * Get the errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     *
     * cURL Options
     *
     */

    /**
     * Set URL Option
     *
     * @param string $value
     */
    private function setUrl()
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->server);
    }

    /**
     * Set header Option
     *
     * @param bool $value
     */
    private function setHeader()
    {
        curl_setopt($this->curl, CURLOPT_HEADER, false);
    }

    /**
     * Set return transfer Option
     *
     * @param bool $value
     */
    private function setReturnTransfer()
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * Set HTTP Header Option
     *
     * @param bool $json
     */
    private function setHttpHeader($json = true)
    {
        $header = [
            "Authorization: OAuth $this->token",
        ];

        if ($json) {

            array_push($header, "Content-type: application/json");
        }

        curl_setopt(
            $this->curl,
            CURLOPT_HTTPHEADER,
            $header
        );
    }

    /**
     * Set Post
     *
     * @return void
     */
    private function setPost()
    {
        curl_setopt($this->curl, CURLOPT_POST, true);

        $this->setPostFields();
    }

    /**
     * Set Custom Request to Path
     *
     * @return void
     */
    private function setCustomRequestPath()
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');

        $this->setPostFields();
    }

    /**
     * Set Custom Request to Delete
     *
     * @return void
     */
    private function setCustomRequestDelete()
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $this->setPostFields();
    }

    /**
     *
     * @return void
     */
    private function setPostFields()
    {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->content);
    }
}

/* End of gsa-sf-api-services.php */
