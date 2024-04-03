<?php
/**
 * Helper functions
 *
 * @package WordPress
 * @subpackage propz-wordpress-tools
 * @since 0.1
 * @version 0.1
 */

\defined( 'ABSPATH' ) || exit;

	/**
	 * Write default or custom log
	 * 
	 * @param mixed $log - Content
	 * @param string $file - Filename
	 * @return void
	 */
	if ( ! \function_exists( 'write_log' ) )
	{
		function write_log( mixed $log, string $file = 'debug.log' ): void
		{
			if ( !$log ) return;

			if ( $file !== 'debug.log' )
			{
				// Set same log date as default wp log
				$date = new \DateTime();
				$date = '[' . $date->format( 'd-M-Y G:i:s' ) . ' UTC] ';

				\file_put_contents( WP_CONTENT_DIR . '/' . $file, $date . \print_r( $log, \true ) . \PHP_EOL, \FILE_APPEND);
				return;
			}

			// Default log
			error_log( \print_r( $log, \true ) );
		}
	}


	/**
	 * Sends request to URL via CURL (GET or POST)
	 * - GET is default
	 * - POST if $data is not empty
	 * 
	 * @param string $url - URL to send request to
	 * @param mixed $data - Data to send
	 * @param array $headers - More headers
	 * @return mixed
	 */
	if ( ! \function_exists( 'send_request_to_url' ) )
	{
		function send_request_to_url( string $url, mixed $data = \null, array $headers = [] ): mixed
		{
			if ( empty( $url ) ) return \null;

			$ch = \curl_init( $url );

			// Basic settings
			\curl_setopt( $ch, \CURLOPT_RETURNTRANSFER, \true );
			\curl_setopt( $ch, \CURLOPT_FOLLOWLOCATION, \true );
			\curl_setopt( $ch, \CURLOPT_ENCODING, 'deflate,gzip' );
			// Timeout in seconds
			\curl_setopt( $ch, \CURLOPT_TIMEOUT, 5 );
			// Disable any kind of SSL verification
			\curl_setopt( $ch, \CURLOPT_SSL_VERIFYHOST, \false );
			\curl_setopt( $ch, \CURLOPT_SSL_VERIFYPEER, \false );

			// Data is set, so we POST it
			// Default content type: application/x-www-form-urlencoded
			if ( !empty( $data ) )
			{
				\curl_setopt( $ch, \CURLOPT_POST, 1 );
				\curl_setopt( $ch, \CURLOPT_POSTFIELDS, $data );
			}

			// An array of HTTP header fields to set
			// Format: [ 'Content-type: text/plain', 'Content-length: 100', ... ]
			if ( !empty( $headers ) )
				\curl_setopt( $ch, \CURLOPT_HTTPHEADER, $headers );

			// Do the magic
			$response = \curl_exec( $ch );

			if ( \curl_error( $ch ) )
				\trigger_error( 'Curl Error:' . \curl_error( $ch ) );

			\curl_close( $ch );

			return $response;
		}
	}


	/**
	 * Get current year (function and shortcode)
	 * 
	 * @return string
	 */
	if ( !function_exists( 'get_year' ) )
	{
		function get_year(): string
		{
			return \date('Y');
		}
		add_shortcode( 'year', 'get_year' );
	}


/*	====================
	Template checks
	==================== */


	/**
	 * Is WPML active?
	 * 
	 * @return bool
	 */
	if ( ! \function_exists( 'wpml_activated' ) )
	{
		function wpml_activated(): bool
		{
			return \function_exists( 'icl_object_id' );
		}
	}

	
	/**
	 * Is WooCommerce active?
	 * 
	 * @return bool
	 */
	if ( ! \function_exists( 'woocommerce_activated' ) )
	{
		function woocommerce_activated(): bool
		{
			return \class_exists( 'woocommerce' );
		}
	}


	/**
	 * Is WooCommerce Germanized active?
	 * 
	 * @return bool
	 */
	if ( ! \function_exists( 'woocommerce_germanized_activated' ) )
	{
		function woocommerce_germanized_activated(): bool
		{
			return \class_exists( 'WooCommerce_Germanized' );
		}
	}

	/**
	 * Is ACF active?
	 * 
	 * @return bool
	 */
	if ( ! \function_exists( 'acf_activated' ) )
	{
		function acf_activated(): bool
		{
			return \class_exists( 'acf' );
		}
	}


	/**
	 * Is Divi Theme active (parent or child)?
	 * 
	 * @return bool
	 */
	if ( ! \function_exists( 'divi_theme_activated' ) )
	{
		function divi_theme_activated(): bool
		{
			$theme = wp_get_theme();
			return ( $theme->get( 'Name' ) === 'Divi' || $theme->parent === 'Divi' );
		}
	}


	/**
	 * Is Divi Builder plugin active?
	 * 
	 * @return bool
	 */
	if ( ! \function_exists( 'divi_builder_activated' ) )
	{
		function divi_builder_activated(): bool
		{
			return is_plugin_active( 'divi-builder/divi-builder.php' );
		}
	}


	/**
	 * Is the user currently using the Divi Builder?
	 * 
	 * @return bool
	 */
	if ( ! \function_exists( 'is_divi_builder_active' ) )
	{
		function is_divi_builder_active(): bool
		{
			return !empty( $_GET['et_fb'] );
		}
	}