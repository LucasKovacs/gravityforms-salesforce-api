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
 * Core Class
 */
class Gsa_Core
{
    private $ui;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->registerOptions();
        $this->createUIObject();
    }

    /**
     * Creates an GSA UI Object and set it
     */
    public function createUIObject()
    {
        $this->ui = new Gsa_Ui;
    }

    /**
     * Register options
     */
    private function registerOptions()
    {
        // register a few options for SF
        add_option('sf_user_email', ''); // default: empty
        add_option('sf_user_password', ''); // default: empty
        add_option('sf_user_token', ''); // default: empty

        // register a few options for GF
        add_option('gf_save_on', 'true'); // default: true
        add_option('gf_form_id', '0'); // default: 0
    }

    /**
     * Handle form submit
     *
     * @return void
     */
    public function handleRequest()
    {
        $this->saveSfData();
        $this->saveGfData();

        wp_redirect(admin_url('/tools.php?page=gravityfroms-salesforce-api'));
        exit;
    }

    /**
     * Save sales force settings
     *
     * @return void
     */
    private function saveSfData()
    {
        if ($_POST['action'] == 'save_credentials') {

            if (!empty($_POST['sf_user_email']) && !empty($_POST['sf_user_password']) && !empty($_POST['sf_user_token'])) {
                require_once '../wp-includes/option.php';

                update_option('sf_user_email', $_POST['sf_user_email']);
                update_option('sf_user_password', $_POST['sf_user_password']);
                update_option('sf_user_token', $_POST['sf_user_token']);

                wp_redirect(admin_url('/tools.php?page=gravityfroms-salesforce-api&error=1'));
                exit;

            } else {
                wp_redirect(admin_url('/tools.php?page=gravityfroms-salesforce-api&error=2'));
                exit;
            }
        }
    }

    /**
     * Save gravity forms settings
     *
     * @return void
     */
    private function saveGfData()
    {
        if ($_POST['action'] == 'save_gf') {
            if (!empty($_POST['gf_form_id'])) {
                require_once '../wp-includes/option.php';

                update_option('gf_save_on', (isset($_POST['gf_save_on']) ? 'true' : 'false'));
                update_option('gf_form_id', $_POST['gf_form_id']);

                wp_redirect(admin_url('/tools.php?page=gravityfroms-salesforce-api&error=1'));
                exit;

            } else {
                wp_redirect(admin_url('/tools.php?page=gravityfroms-salesforce-api&error=2'));
                exit;
            }
        }
    }

    /**
     * Build forms UI
     */
    public function buildUI()
    {
        $this->ui->set_ui();
    }

    /**
     * Build notices UI
     */
    public function buildNotices()
    {
        $this->ui->set_notices();
    }
}

/* end of gsa-core.php */
