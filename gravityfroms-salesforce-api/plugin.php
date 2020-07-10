<?php
/**
 * Plugin Name: GravityForms to SalesForce API
 * Description: JSON-based REST API that sends leads from GravityForms to SalesForce.
 * Author: Lucas Kovács
 * Author URI: https://github.com/LucasKovacs
 * Version: 1.0
 * Plugin URI:
 * License: Lucas Kovács © 2018
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With, X-CSRF-Token, X-Api-Key');

// start a new session
session_start();

// required files
// include SalesForce API
require_once plugin_dir_path(__FILE__) . 'inc/gsa-sf-api/gsa-sf-api.php';

// include Other Files
require_once plugin_dir_path(__FILE__) . 'inc/gsa-core.php';
require_once plugin_dir_path(__FILE__) . 'inc/gsa-api.php';
require_once plugin_dir_path(__FILE__) . 'inc/gsa-token.php';
require_once plugin_dir_path(__FILE__) . 'inc/gsa-ui.php';

// Token verification
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/lead/token', [
        'methods' => 'GET',
        'callback' => [new Gsa_Api, 'generateToken'],
    ]);
});

// Get all leads
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/lead/getAll', [
        'methods' => 'POST',
        'callback' => [$this, 'getLeads'],
    ]);
});

// Create a new lead
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/lead/create', [
        'methods' => 'POST',
        'callback' => [new Gsa_Api, 'createLead'],
    ]);
});

// Get a single lead
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/lead/get', [
        'methods' => 'POST',
        'callback' => [new Gsa_Api, 'getLead'],
    ]);
});

// Edit a single lead
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/lead/edit', [
        'methods' => 'POST',
        'callback' => [new Gsa_Api, 'editLead'],
    ]);
});

// Delete a single lead
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/lead/delete', [
        'methods' => 'POST',
        'callback' => [new Gsa_Api, 'deleteLead'],
    ]);
});

// Provide system Health
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/health', [
        'methods' => 'GET',
        'callback' => [new Gsa_Api, 'checkHealth'],
    ]);
});

// Provide system Ready
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/ready', [
        'methods' => 'GET',
        'callback' => [new Gsa_Api, 'checkReady'],
    ]);
});

// Provide system Ready
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/version', [
        'methods' => 'GET',
        'callback' => [new Gsa_Api, 'checkVersion'],
    ]);
});

// register menu
add_action('admin_menu', function () {
    add_submenu_page('tools.php', 'GravityForms to SalesForce API', 'GravityForms to SalesForce API', 'manage_options', 'gravityfroms-salesforce-api', 'Gsa_init');
});

// save credentials
add_action('admin_post_save_credentials', 'Gsa_save');
add_action('admin_post_save_gf', 'Gsa_save');
add_action('admin_notices', 'Gsa_set_notices');

/**
 * Init
 */
function Gsa_init()
{
    $Gsa_core = new Gsa_core;
    $Gsa_core->buildUI();
}

/**
 * Save
 */
function Gsa_save()
{
    $Gsa_core = new Gsa_core;
    $Gsa_core->handleRequest();
}

/**
 * Notices
 */
function Gsa_set_notices()
{
    $Gsa_core = new Gsa_core;
    $Gsa_core->buildNotices();
}

/* End of plugin.php */
