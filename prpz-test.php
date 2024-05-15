<?php
/**
 * This is solely for test purposes.
 * 
 * Are all functions working as expected?
 * Just call this file and see if anything breaks.
 *
 * @package WordPress
 * @subpackage propz-wordpress-tools
 * @since 0.1
 * @version 0.3
 */

// Load WP
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

$test = [
	// Misc
	'send_request_to_url' => send_request_to_url( 'https://api.country.is/' ),
	'get_year' => get_year(),

	// Helpers
	'acf_activated' => acf_activated() ? 'true' : 'false',
	'wpml_activated' => wpml_activated() ? 'true' : 'false',

	'woocommerce_activated' => woocommerce_activated() ? 'true' : 'false',
	'woocommerce_germanized_activated' => woocommerce_germanized_activated() ? 'true' : 'false',

	'divi_theme_activated' => divi_theme_activated() ? 'true' : 'false',
	'divi_builder_activated' => divi_builder_activated() ? 'true' : 'false',
	'is_divi_builder_active' => is_divi_builder_active() ? 'true' : 'false',
];

// Test
write_log( $test, 'test.log' );

echo '<pre>' . \print_r( $test, \true ) . '</pre>';