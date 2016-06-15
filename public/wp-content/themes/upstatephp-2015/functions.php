<?php
date_default_timezone_set('America/New_York');

// define template dir/uri for easy access
define('THEME_DIR', get_template_directory_uri());
define('THEME_DIR_CHILD', get_stylesheet_directory_uri());
define('ASSETS_DIR', THEME_DIR . '/assets');

// RUNNING COMPOSER?
// require 'vendor/autoload.php';

include('functions/helpers.php');
include('functions/init.php');
include('functions/js_css.php');
include('functions/sidebars.php');
include('functions/menus.php');
include('functions/widgets.php');
include('functions/wp_bootstrap_navwalker.php');
