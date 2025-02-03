<?php
/**
 * 
 * @package WordPress
 * @subpackage PlaymotivCloudTheme
 */

add_filter('xmlrpc_enabled', '__return_false');
add_filter('login_display_language_dropdown', '__return_false');

require_once(dirname(__FILE__) . '/custom/main.php');
require_once(dirname(__FILE__) . '/setup/woocommerce.php');
require_once(dirname(__FILE__) . '/setup/mailrelay.php');
require_once(dirname(__FILE__) . '/setup/analitycs.php');

