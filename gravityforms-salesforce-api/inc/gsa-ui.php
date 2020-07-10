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
 * UI Class
 */
class Gsa_Ui
{
    private $admin_url;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->admin_url = admin_url('/admin-post.php');
    }

    /**
     *  Build a simple form
     */
    public function set_ui()
    {
        // for sales force
        $sf_user_email = get_option('sf_user_email');
        $sf_user_password = get_option('sf_user_password');
        $sf_user_token = get_option('sf_user_token');

        // for gravity forms
        $gf_save_on_active = get_option('gf_save_on') == 'true' ? 'checked="on"' : '';

        // settings form
        echo "<div class='wrap'>";
        echo "<h1 class='wp-heading-inline'>SC Website API</h1>";
        echo "<hr class='wp-header-end'>";
        echo "<h2>SalesForce Settings</h2>";
        echo "<form action='{$this->admin_url}' method='POST' id='Gsa_save_credentials'>";
        echo "<input type='hidden' name='action' value='save_credentials' />";
        echo "<label for='sf_user_email'><strong>Email:</strong></label><br/>";
        echo "<input type='text' id='sf_user_email' name='sf_user_email' value='{$sf_user_email}' /><br/>";
        echo "<label for='sf_user_password'><strong>Password:</strong></label><br/>";
        echo "<input type='password' id='sf_user_password' name='sf_user_password' value='{$sf_user_password}' /><br/>";
        echo "<label for='sf_user_token'><strong>Token:</strong></label><br/>";
        echo "<input type='text' id='sf_user_token' name='sf_user_token' value='{$sf_user_token}' /><br/>";
        echo "<p style='color: red'>Notice: if you remove any of these the <strong>API won't work!</strong> If you make any change be sure that's the <strong>right value!!!</strong></p>";
        echo "<input type='submit' id='sf_submit' value='Save' class='button button-primary button-large'/>";
        echo "</form>";

        echo "<h2>Gravity Forms Settings</h2>";

        if (is_plugin_active('gravityforms/gravityforms.php')) {

            echo "<form action='{$this->admin_url}' method='POST' id='Gsa_save_gf'>";
            echo "<input type='hidden' name='action' value='save_gf' />";
            echo "<label for='gf_save_on'><strong>Save on Gravity Forms?:</strong></label><br/>";
            echo "<input type='checkbox' id='gf_save_on' name='gf_save_on' " . $gf_save_on_active . "/><br/>";
            echo $this->buildListOfForms();
            echo "<p style='color: red'>Notice: if any of this values are not properly set, forms won't be saved in WP!</p>";
            echo "<input type='submit' id='gf_submit' value='Save' class='button button-primary button-large'/>";
            echo "</form>";
        } else {

            echo '<p style="color:red">Gravity Forms isn\'t installed or active!</p>';
        }

        echo "</div>";
    }

    /**
     * Set error and message notices
     */
    public function set_notices()
    {
        $error = isset($_GET['error']) ? $_GET['error'] : false;

        if ($error) {

            switch ($_GET['error']) {
                case 2:
                    $message = 'All fields must be filled.';
                    break;
            }

            if ($error == 1) {

                echo '<div class="notice notice-success">';
                echo '    <p>Settings saved!</p>';
                echo '</div>';
            } else {

                echo '<div class="notice notice-error">';
                echo '    <p>' . $message . '</p>';
                echo '</div>';
            }
        }
    }

    /**
     * Build a list of forms
     *
     * @return string
     */
    private function buildListOfForms()
    {
        $gf_form_id = get_option('gf_form_id');
        $forms = RGFormsModel::get_forms(null, 'title');

        $select = '<label for="gf_form_id"><strong>Form ID:</strong></label><br/>';
        $select .= '<select id="gf_form_id" name="gf_form_id">';

        if (is_array($forms)) {

            foreach ($forms as $form) {

                $selected = '';

                if ($gf_form_id == $form->id) {

                    $selected = ' selected="selected"';
                }

                $select .= '<option value="' . $form->id . '"' . $selected . '>' . $form->title . '</option>';
            }
        }

        $select .= '</select>';
        $select .= '<br/>';

        return $select;
    }
}

/* end of gsa-ui.php */
