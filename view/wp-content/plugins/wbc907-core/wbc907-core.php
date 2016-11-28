<?php
/*
Plugin Name: WBC907 Core
Description: 907 theme custom post types, demo data, etc.
Plugin URI: http://themeforest.net/user/webcreations907
Author: Webcreations907
Author URI: http://themeforest.net/user/webcreations907
Version: 1.0.9
Text Domain: wbc907-core
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WBC_INCLUDES_DIRECTORY', plugin_dir_path( __FILE__ ).'includes/' );
define( 'WBC_INCLUDES_DIRECTORY_URI', plugin_dir_url( __FILE__ ).'includes/' );
define( 'WBC_SHORTCODE_DIRECTORY', WBC_INCLUDES_DIRECTORY.'shortcodes/' );
define( 'WBC_SHORTCODE_THEME_DIRECTORY', apply_filters( 'wbc_shortcode_theme_directory', get_template_directory().'/assets/php/shortcodes/' ) );

//Loads ReduxFramework + Extensions
include WBC_INCLUDES_DIRECTORY.'options/index.php';


//Load Updater
if ( !function_exists( 'wbc907_load_updater' ) ) {
	function wbc907_load_updater() {
		if ( defined( 'WBC907THEME' ) && true === WBC907THEME ) {
			include WBC_INCLUDES_DIRECTORY.'theme-compat/theme-compat-pre-4.0.php';
		}
	}
	add_action( 'after_setup_theme', 'wbc907_load_updater' );
}

//Shortcode Loader
include WBC_INCLUDES_DIRECTORY.'classes/class_wbc_shortcode_loader.php';



// Remove Next Update
if ( !function_exists( 'wbc907_update_envato_market_plugin' ) ) {
	function wbc907_update_envato_market_plugin( $plugins ) {

		if ( is_array( $plugins ) ) {
			foreach ( $plugins as $key => $plugin ) {

				if ( isset( $plugin['slug'] ) && $plugin['slug'] == 'wp-envato-market' ) {
					$plugins[$key]['slug'] = 'envato-market';
				}

			}
		}
		return $plugins;
	}
	add_filter( 'wbc907_theme_plugins_filter', 'wbc907_update_envato_market_plugin', 5 );
}

//Custom Post Types
if ( !function_exists( 'wbc_register_portfolo' ) ) {
	function wbc_register_portfolo() {
		$wbc_portfolio_slug = sanitize_title( apply_filters( 'wbc_portfolio_slug' , 'portfolio' ) );

		register_post_type( 'wbc-portfolio',
			array(
				'labels' => array(
					'name'          => esc_html__( 'Portfolio', 'wbc907-core' ),
					'singular_name' => esc_html__( 'Portfolio', 'wbc907-core' ),
					'search_items'  => esc_html__( 'Search Portfolio Items', 'wbc907-core' ),
					'all_items'     => esc_html__( 'Portfolio', 'wbc907-core' ),
					'parent_item'   => esc_html__( 'Parent Portfolio Item', 'wbc907-core' ),
					'edit_item'     => esc_html__( 'Edit Portfolio Item', 'wbc907-core' ),
					'update_item'   => esc_html__( 'Update Portfolio Item', 'wbc907-core' ),
					'add_new_item'  => esc_html__( 'Add New Portfolio Item', 'wbc907-core' )
				),
				'public'             => true,
				'menu_icon'          => 'dashicons-camera',
				'query_var'          => false,
				'publicly_queryable' => true,
				'show_in_nav_menus'  => true,
				'show_ui'            => true,
				'hierarchical'       => false,
				'rewrite'            => array( 'slug' => $wbc_portfolio_slug , 'with_front' => false ),
				'menu_position'      => 16 ,
				'supports'           => array( 'title' , 'editor' , 'thumbnail' , 'comments' , 'revisions', 'excerpt' )
			)
		);

		register_taxonomy( "portfolio-filter",
			array( "wbc-portfolio" ),
			array(
				"hierarchical"      => true,
				"labels"            => array(
					'name'          => esc_html__( "Filters", 'wbc907-core' ),
					'singular_name' => esc_html__( 'Fitler', 'wbc907-core' ),
					'all_items'     => esc_html__( 'All Filters', 'wbc907-core' ),
					'search_items'  => esc_html__( 'Search Filters', 'wbc907-core' ),
					'edit_item'     => esc_html__( 'Edit Filter', 'wbc907-core' ),
					'update_item'   => esc_html__( 'Update Filter', 'wbc907-core' ),
					'add_new_item'  => esc_html__( 'Add New Filter', 'wbc907-core' )
				),
				"singular_label"    => esc_html__( "Filter", 'wbc907-core' ),
				'show_in_nav_menus' => false,
			)
		);

		register_taxonomy( "portfolio-categories",
			array( "wbc-portfolio" ),
			array(
				"hierarchical"      => true,
				"labels"            => array(
					'name'          => esc_html__( "Categories", 'wbc907-core' ),
					'singular_name' => esc_html__( 'Fitler', 'wbc907-core' ),
					'all_items'     => esc_html__( 'All Categories', 'wbc907-core' ),
					'search_items'  => esc_html__( 'Search Categories', 'wbc907-core' ),
					'edit_item'     => esc_html__( 'Edit Category', 'wbc907-core' ),
					'update_item'   => esc_html__( 'Update Category', 'wbc907-core' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'wbc907-core' )
				),
				"singular_label"    => esc_html__( "Category", 'wbc907-core' ),
				'show_in_nav_menus' => false,
			)
		);


		// Check if portfolio slug has been updated through theme options.
		// if it has, flush_rewrite_rules and update transient.
		// Saves from having to click save changes button on permalinks page :)
		if ( !get_transient( 'wbc_portfolio_saved_slug' ) ) {

			set_transient( 'wbc_portfolio_saved_slug' , $wbc_portfolio_slug , 0 );

		}elseif ( get_transient( 'wbc_portfolio_saved_slug' ) != $wbc_portfolio_slug ) {

			set_transient( 'wbc_portfolio_saved_slug' , $wbc_portfolio_slug , 0 );

			flush_rewrite_rules();
		}


		/************************************************************************
		* Reuseables
		*************************************************************************/
		register_post_type( 'wbc-reuseables',
			array(
				'labels' => array(
					'name'          => esc_html__( 'Reuseables', 'wbc907-core' ),
					'singular_name' => esc_html__( 'Reuseable', 'wbc907-core' ),
					'search_items'  => esc_html__( 'Search Reuseable Items', 'wbc907-core' ),
					'all_items'     => esc_html__( 'Reuseables', 'wbc907-core' ),
					'parent_item'   => esc_html__( 'Parent Reuseable Item', 'wbc907-core' ),
					'edit_item'     => esc_html__( 'Edit Reuseable Item', 'wbc907-core' ),
					'update_item'   => esc_html__( 'Update Reuseable Item', 'wbc907-core' ),
					'add_new_item'  => esc_html__( 'Add New Reuseable Item', 'wbc907-core' )
				),
				'public'              => true,
				'menu_icon'           => 'dashicons-chart-pie',
				'query_var'           => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'hierarchical'        => false,
				'menu_position'       => 18,
				'supports'            => array( 'title' , 'editor', 'revisions' )
			)
		);
	}

	add_action( 'after_setup_theme' , 'wbc_register_portfolo' );
}
?>