<?php
/**
 * Install Function
 *
 * @package     Stock Advisor
 * @subpackage  Functions/Install
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install
 *
 * Runs on plugin install by setting up the post types, custom taxonomies, flushing rewrite rules to initiate new slug
 * @since 1.0
 *
 * @param bool $network_wide
 *
 * @global     $wpdb
 * @return void
 */
function stockadvisor_install( $network_wide = false ) {
	global $wpdb;
	if ( is_multisite() && $network_wide ) {
		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id ) {
			switch_to_blog( $blog_id );
			stockadvisor_run_install();
			restore_current_blog();
		}
	} else {
		stockadvisor_run_install();
	}
}

/**
 * Run the Stock Advisor Install process.
 *
 * @since  1.0.0
 * @return void
 */
function stockadvisor_run_install() {
	// Setup the Stock Advisor Custom Post Types.
	stockadvisor_setup_post_types();
	flush_rewrite_rules();
    
    do_action( 'stockadvisor_after_install' );
}

/**
 * Network Activated New Site Setup.
 *
 * When a new site is created when Stock Advisor is network activated this function runs the appropriate install function to set
 * up the site for Stock Advisor.
 *
 * @since      1.0.0
 *
 * @param  int    $blog_id The Blog ID created.
 * @param  int    $user_id The User ID set as the admin.
 * @param  string $domain  The URL.
 * @param  string $path    Site Path.
 * @param  int    $site_id The Site ID.
 * @param  array  $meta    Blog Meta.
 */
function stockadvisor_on_create_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	if ( is_plugin_active_for_network( STOCKADVISOR_PLUGIN_BASENAME ) ) {
		switch_to_blog( $blog_id );
		stockadvisor_install();
		restore_current_blog();
	}
}

add_action( 'wpmu_new_blog', 'stockadvisor_on_create_blog', 10, 6 );