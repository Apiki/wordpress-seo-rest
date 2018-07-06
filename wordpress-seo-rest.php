<?php
/*
	Plugin Name: WordPress SEO REST
	Version: 1.2.2
	Author: @kassyn
	Author URI: https://github.com/kassyn
	Text Domain: wordpress-seo-rest
	Domain Path: /languages
	License: GPLv2
	Description: Show in JSON REST params configured in yoast (meta-title, meta-description, facebook, twitter).
*/

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

if ( ! file_exists( WP_PLUGIN_DIR . '/wordpress-seo/wp-seo.php' ) ) {
	return;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

use Apiki\SEO\REST\Core;

$core = new Core( __FILE__ );

register_activation_hook( __FILE__, array( $core, 'activate' ) );
