<?php

$plugin_root = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])) . '/../';

// salesforce API
include_once $plugin_root . 'inc/gsa-sf-api/gsa-sf-api.php';

// gsa API
include_once $plugin_root . 'inc/gsa-api.php';
include_once $plugin_root . 'inc/gsa-core.php';
include_once $plugin_root . 'inc/gsa-token.php';
include_once $plugin_root . 'inc/gsa-ui.php';
