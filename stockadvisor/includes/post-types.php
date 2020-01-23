<?php
/**
 * Post Type Functions
 *
 * @package     Stock Advisor
 * @subpackage  Functions
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers and sets up the Stock Advisor News custom post type
 *
 * @return void
 * @since 1.0
 */
function stockadvisor_setup_post_types() {

    /** Stock News Post Type */
	$stock_news_slug = defined( 'STOCK_NEWS_SLUG' ) ? STOCK_NEWS_SLUG : 'stock_news';

	$stock_news_rewrite = array(
		'slug'       => $stock_news_slug,
		'with_front' => false,
	);

	$stock_news_labels = apply_filters( 'stock_news_labels', array(
		'name'               => esc_html__( 'Stock News', 'stockadvisor' ),
		'singular_name'      => esc_html__( 'Stock News', 'stockadvisor' ),
		'add_new'            => esc_html__( 'Add Stock News', 'stockadvisor' ),
		'add_new_item'       => esc_html__( 'Add New Stock News', 'stockadvisor' ),
		'edit_item'          => esc_html__( 'Edit Stock News', 'stockadvisor' ),
		'new_item'           => esc_html__( 'New Stock News', 'stockadvisor' ),
		'all_items'          => esc_html__( 'All Stock News', 'stockadvisor' ),
		'view_item'          => esc_html__( 'View Stock News', 'stockadvisor' ),
		'search_items'       => esc_html__( 'Search Stock News', 'stockadvisor' ),
		'not_found'          => esc_html__( 'No news found.', 'stockadvisor' ),
		'not_found_in_trash' => esc_html__( 'No news found in Trash.', 'stockadvisor' ),
		'parent_item_colon'  => '',
		'menu_name'          => apply_filters( 'stockadvisor_news_menu_name', esc_html__( 'Stock News', 'stockadvisor' ) ),
		'name_admin_bar'     => apply_filters( 'stockadvisor_news_name_admin_bar_name', esc_html__( 'Stock News', 'stockadvisor' ) ),
	) );

	$stock_news_args = array(
		'labels'          => $stock_news_labels,
		'public'          => true,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'show_in_rest'    => true,
		'query_var'       => true,
		'rewrite'         => $stock_news_rewrite,
		'map_meta_cap'    => true,
		'capability_type' => 'post',
		'has_archive'     => true,
		'menu_icon'       => 'dashicons-welcome-widgets-menus',
		'hierarchical'    => false,
        'supports'        => apply_filters( 'stock_news_supports', array( 'title', 'editor', 'revisions', 'author' ) ),
	);
	register_post_type( 'stock_news', apply_filters( 'stock_news_post_type_args', $stock_news_args ) );

    /** Stock Recommendation Post Type */
	$stock_recommendation_slug = defined( 'STOCK_RECOMMENDATION_SLUG' ) ? STOCK_RECOMMENDATION_SLUG : 'stock_recommendation';

	$sstock_recommendation_rewrite = array(
		'slug'       => $stock_recommendation_slug,
		'with_front' => false,
	);

	$stock_recommendation_labels = apply_filters( 'stock_recommendation_labels', array(
		'name'               => esc_html__( 'Stock Recommendation', 'stockadvisor' ),
		'singular_name'      => esc_html__( 'Stock Recommendation', 'stockadvisor' ),
		'add_new'            => esc_html__( 'Add Stock Recommendation', 'stockadvisor' ),
		'add_new_item'       => esc_html__( 'Add New Stock Recommendation', 'stockadvisor' ),
		'edit_item'          => esc_html__( 'Edit Stock Recommendation', 'stockadvisor' ),
		'new_item'           => esc_html__( 'New Stock Recommendation', 'stockadvisor' ),
		'all_items'          => esc_html__( 'All Stock Recommendations', 'stockadvisor' ),
		'view_item'          => esc_html__( 'View Stock Recommendation', 'stockadvisor' ),
		'search_items'       => esc_html__( 'Search Stock Recommendation', 'stockadvisor' ),
		'not_found'          => esc_html__( 'No news found.', 'stockadvisor' ),
		'not_found_in_trash' => esc_html__( 'No news found in Trash.', 'stockadvisor' ),
		'parent_item_colon'  => '',
		'menu_name'          => apply_filters( 'stockadvisor_recommendation_menu_name', __( 'Stock Recommendation', 'stockadvisor' ) ),
		'name_admin_bar'     => apply_filters( 'stockadvisor_recommendation_name_admin_bar_name', __( 'Stock Recommendation', 'stockadvisor' ) ),
	) );

	$stock_recommendation_args = array(
		'labels'          => $stock_recommendation_labels,
		'public'          => true,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'show_in_rest'    => true,
		'query_var'       => true,
		'rewrite'         => $sstock_recommendation_rewrite,
		'map_meta_cap'    => true,
		'capability_type' => 'post',
		'has_archive'     => true,
		'menu_icon'       => 'dashicons-chart-area',
		'hierarchical'    => false,
        'supports'        => apply_filters( 'stock_recommendation_supports', array( 'title', 'editor', 'revisions', 'author' ) ),
	);
	register_post_type( 'stock_recommendation', apply_filters( 'stock_recommendation_post_type_args', $stock_recommendation_args ) );

    /** Company Post Type */
	$company_post_type_slug = defined( 'STOCK_COMPANY_SLUG' ) ? STOCK_COMPANY_SLUG : 'company';

	$company_post_type_rewrite = array(
		'slug'       => $company_post_type_slug,
		'with_front' => false,
	);

	$company_post_type_labels = apply_filters( 'company_post_type_labels', array(
		'name'               => esc_html__( 'Companies', 'stockadvisor' ),
		'singular_name'      => esc_html__( 'Company', 'stockadvisor' ),
		'add_new'            => esc_html__( 'Add Company', 'stockadvisor' ),
		'add_new_item'       => esc_html__( 'Add New Company', 'stockadvisor' ),
		'edit_item'          => esc_html__( 'Edit Company', 'stockadvisor' ),
		'new_item'           => esc_html__( 'New Company', 'stockadvisor' ),
		'all_items'          => esc_html__( 'All Companies', 'stockadvisor' ),
		'view_item'          => esc_html__( 'View Company', 'stockadvisor' ),
		'search_items'       => esc_html__( 'Search Company', 'stockadvisor' ),
		'not_found'          => esc_html__( 'No company found.', 'stockadvisor' ),
		'not_found_in_trash' => esc_html__( 'No company found in Trash.', 'stockadvisor' ),
		'parent_item_colon'  => '',
		'menu_name'          => apply_filters( 'stockadvisor_company_menu_name', esc_html__( 'Company', 'stockadvisor' ) ),
		'name_admin_bar'     => apply_filters( 'stockadvisor_company_name_admin_bar_name', esc_html__( 'Company', 'stockadvisor' ) ),
	) );

	$company_post_type_args = array(
		'labels'          => $company_post_type_labels,
		'public'          => true,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'show_in_rest'    => true,
		'query_var'       => true,
		'rewrite'         => $company_post_type_rewrite,
		'map_meta_cap'    => true,
		'capability_type' => 'post',
		'has_archive'     => true,
		'menu_icon'       => 'dashicons-analytics',
		'hierarchical'    => false,
        'supports'        => apply_filters( 'stock_company_supports', array( 'title', 'editor' ) ),
	);
	register_post_type( 'company', apply_filters( 'company_post_type_args', $company_post_type_args ) );
}

add_action( 'init', 'stockadvisor_setup_post_types', 1 );


/**
 * Stock Advisor Setup Taxonomies
 *
 * Registers the custom taxonomies for the stock_news custom post type
 *
 * @return void
 * @since      1.0
 */
function stockadvisor_setup_taxonomies() {

	$slug = defined( 'STOCKADVISOR_TICKER_SLUG' ) ? STOCKADVISOR_TICKER_SLUG : 'ticker';

	/** Stock Tickers */
	$ticker_labels = array(
		'name'              => esc_html_x( 'Stock Tickers', 'taxonomy general name', 'stockadvisor' ),
		'singular_name'     => esc_html_x( 'Stock Ticker', 'taxonomy singular name', 'stockadvisor' ),
		'search_items'      => esc_html__( 'Search Tickers', 'stockadvisor' ),
		'all_items'         => esc_html__( 'All Tickers', 'stockadvisor' ),
		'edit_item'         => esc_html__( 'Edit Stock Ticker', 'stockadvisor' ),
		'update_item'       => esc_html__( 'Update Stock Ticker', 'stockadvisor' ),
		'add_new_item'      => esc_html__( 'Add New Stock Ticker', 'stockadvisor' ),
		'new_item_name'     => esc_html__( 'New Stock Ticker Name', 'stockadvisor' ),
		'menu_name'         => esc_html__( 'Stock Tickers', 'stockadvisor' ),
	);

	$ticker_args = apply_filters( 'stockadvisor_ticker_args', array(
			'hierarchical' => false,
			'labels'       => apply_filters( 'stockadvisor_ticker_labels', $ticker_labels ),
			'show_ui'      => true,
			'query_var'    => 'stockadvisor_ticker',
			'rewrite'      => array(
				'slug'         => $slug,
				'with_front'   => false,
				'hierarchical' => false,
			),
			// @TODO: add new roles and capabilities on plugin install
			// 'capabilities' => array(
			// 	'manage_terms' => 'manage_stockadvisor_terms',
			// 	'edit_terms'   => 'edit_stockadvisor_terms',
			// 	'assign_terms' => 'assign_stockadvisor_terms',
			// 	'delete_terms' => 'delete_stockadvisor_terms',
			// ),
		)
	);

    register_taxonomy( 'stockadvisor_ticker', array( 'stock_news', 'stock_recommendation', 'company' ), $ticker_args );
}

add_action( 'init', 'stockadvisor_setup_taxonomies', 0 );

/**
 * Change default "Enter title here" input
 *
 * @param string $title Default title placeholder text
 *
 * @return string $title New placeholder text
 * @since 1.0.0
 *
 */
function stockadvisor_change_default_title( $title ) {
	// Check for frontend
	if ( ! is_admin() ) {
		$title = esc_html__( 'Enter form title here', 'stockadvisor' );
		return $title;
	}

	$screen = get_current_screen();

	if ( 'company' == $screen->post_type ) {
		$title = esc_html__( 'Enter company name', 'stockadvisor' );
	}

	return $title;
}

add_filter( 'enter_title_here', 'stockadvisor_change_default_title' );