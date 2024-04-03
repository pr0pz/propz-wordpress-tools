<?php
/*
	Plugin Name: propz WordPress Tools
	Description: Just a small collection of some handy WordPress functions and features.
	Author: Wellington Estevo
	Version: 0.1
	Author URI: https://propz.de
*/

/**
 * General Hooks, Filters and Resets
 *
 * @package WordPress
 * @subpackage propz-wordpress-tools
 * @since 0.1
 * @version 0.1
 */

\defined( 'ABSPATH' ) || exit;

	/**
	 * Innit?
	 * 
	 * @return void
	 */
	function prpz_tools_init(): void
	{
		// Menu order for posts
		add_post_type_support( 'page', 'page-attributes' );
		// From WP 5.3, add_theme_support('html5', ['script', 'style']); removes type="text/javascript" and type=”text/css” from enqueued scripts and styles.
		add_theme_support( 'html5', [ 'script', 'style' ] );

	/*	====================
		Remove junk from head
		==================== */

		// Remove info about WordPress version from <head>
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'the_generator', function() { return ''; } );

		// Remove Windows Live Writer manifest from <head>
		remove_action( 'wp_head', 'wlwmanifest_link' );

		// Remove current page shortlink
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

	/*	====================
		Remove emojis from everywhere
		==================== */

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		if ( ! is_admin() )
			add_filter( 'emoji_svg_url', '__return_false' );

	/*	====================
		Remove rest api hints
		==================== */

		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

	/*	====================
		Disable auto-update email notifications
		==================== */

		add_filter( 'auto_plugin_update_send_email', '__return_false' );
		add_filter( 'auto_theme_update_send_email', '__return_false' );
		add_filter( 'auto_core_update_send_email', '__return_false' );
	}
	add_action( 'init', 'prpz_tools_init', 100 );


	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 * 
	 * @param mixed $plugins
	 * @return array
	 */
	function prpz_disable_emojis_tinymce( mixed $plugins ): array
	{
		if ( \is_array( $plugins ) )
			return \array_diff( $plugins, [ 'wpemoji' ] );

		return [];
	}
	add_filter( 'tiny_mce_plugins', 'prpz_disable_emojis_tinymce' );


	/**
	 * Remove Rest API oEmbed stuff
	 * 
	 * @return void
	 */
	function prpz_remove_api_oembed(): void
	{
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );		// Remove oEmbed REST API endpoint
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );	// Don't filter oEmbed results
		remove_action( 'wp_head', 'wp_oembed_add_host_js' ); 				// Remove oEmbed-JavaScript
		add_filter( 'embed_oembed_discover', '__return_false' );			// Remove oEmbed auto discovery
	}
	add_action( 'after_setup_theme', 'prpz_remove_api_oembed' );


	/**
	 * Remove rest api for non logged in users
	 * 
	 * @param mixed $errors
	 * @return mixed
	 */
	function prpz_rest_authentication_errors( $errors ): mixed
	{
		// if there is already an error, just return it
		if ( is_wp_error( $errors ) )
			return $errors;
		
		//if( ! is_user_logged_in() ) {
		if( ! current_user_can( 'administrator' ) )
			return new WP_Error( 'no_rest_api_sorry', 'Nope!', array( 'status' => 401 ) );
	
		return $errors;
	}
	add_filter( 'rest_authentication_errors', 'prpz_rest_authentication_errors' );


	/**
	 * Disable WP JSON API endpoints for listing users
	 * 
	 * @param array $endpoints - API Endpoints
	 * @return array
	 */
	function prpz_rest_endpoints( array $endpoints ): array
	{
		if ( isset( $endpoints['/wp/v2/users'] ) )
			unset( $endpoints['/wp/v2/users'] );

		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) )
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );

		return $endpoints;
	}
	add_filter( 'rest_endpoints', 'prpz_rest_endpoints' );


	/**
	 * Customize Dashboard Widgets
	 * 
	 * @return void
	 */
	if ( function_exists( 'prpz_wp_dashboard_setup' ) )
	{
		function prpz_wp_dashboard_setup(): void
		{
			// ADMIN - Remove Dashboard Widgets
			remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );			// WordPress.com Blog
			remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );			// Plugins
			remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );		// Right Now
			remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );		// Quick Press widget
			remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );		// Recent Drafts
			remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );			// Other WordPress News
			remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );	// Incoming Links
			remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );	// Recent Comments
			remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );			// Activity
			remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );		// Site Health

			remove_action( 'welcome_panel', 'wp_welcome_panel' );					// Welcome Panel
			remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );		// Try Gutenberg

			remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );	// Yoast SEO
			remove_meta_box( 'so-dashboard-news', 'dashboard', 'normal' );			// Site origin Page Builder News
		}
		add_action( 'wp_dashboard_setup', 'prpz_wp_dashboard_setup' );
	}


	/**
	 * Disable Duotone Filter in Gutenberg
	 * Disables the unwanted loading of SVGs in body tag
	 * 
	 * @return void
	 */
	function prpz_remove_global_styles_render_svg_filters(): void
	{
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );
	}
	add_action( 'after_setup_theme', 'prpz_remove_global_styles_render_svg_filters', 10, 0 );


	/**
	 * Custom Mime types
	 * 
	 * @param array $mimes - All mime types
	 * @return array
	 */
	if ( !function_exists( 'prpz_upload_mimes' ) )
	{
		function prpz_upload_mimes( array $mimes ): array
		{
			// Add SVG mime type for upload
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}
		add_filter( 'upload_mimes', 'prpz_upload_mimes' );
	}


	/**
	 * Add custom wp_headers
	 * 
	 * @param array $headers
	 * @return $array
	 */
	if ( !function_exists( 'prpz_wp_headers' ) )
	{
		function prpz_wp_headers( array $headers ): array
		{
			// Remove X-PINGBACK header
			if ( isset( $headers[ 'X-Pingback' ] ) )
				unset( $headers[ 'X-Pingback' ] );

			return $headers;
		}
		add_filter( 'wp_headers', 'prpz_wp_headers');
	}


	/**
	 * Hide all notices for non-admins
	 * 
	 * @return void
	 */
	function prpz_hide_notices(): void
	{
		if ( ! current_user_can( 'update_core' ) )
		{
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
			remove_all_actions( 'network_admin_notices' );
			remove_all_actions( 'user_admin_notices' );
		}
	}
	add_action( 'in_admin_header', 'prpz_hide_notices', 1000 );


	/**
	 * Deactivate WP Comment IP logging
	 * 
	 * @param string $comment_author_ip - Author IP
	 * @return string
	 */
	function prpz_pre_comment_user_ip( string $comment_author_ip ): string
	{
		return '';
	}
	add_filter( 'pre_comment_user_ip', 'prpz_pre_comment_user_ip' );


	/**
	 * Yoast - Custom separators
	 * 
	 * @param array $separators - All Separators
	 * @return array
	 */
	if ( !function_exists( 'prpz_wpseo_separator_options' ) )
	{
		function prpz_wpseo_separator_options( array $separators ): array
		{
			$separators[] = '›';
			$separators[] = '‹›';
			$separators[] = '›‹';
			return $separators;
		}
		add_filter( 'wpseo_separator_options', 'prpz_wpseo_separator_options' );
	}


/*	====================
	Includes
	==================== */

	foreach ( \glob(__DIR__ . '/inc/prpz-*.php' ) as $include )
		require_once $include;
