<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/************************************************************************
* Redux Extension Loader
*************************************************************************/

if ( !function_exists( 'wbc907_custom_extension_loader' ) ) {
	function wbc907_custom_extension_loader( $ReduxFramework ) {
		$path = dirname( __FILE__ ) . '/extend/';
		$folders = scandir( $path, 1 );
		foreach ( $folders as $folder ) {
			if ( $folder === '.' or $folder === '..' or !is_dir( $path . $folder ) ) {
				continue;
			}
			$extension_class = 'ReduxFramework_Extension_' . $folder;
			if ( !class_exists( $extension_class ) ) {
				// In case you wanted override your override, hah.
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/'.$ReduxFramework->args['opt_name'].'/'.$folder, $class_file );
				if ( $class_file ) {
					require_once $class_file;
					$extension = new $extension_class( $ReduxFramework );
				}
			}
		}
	}

	add_action( "redux/extensions/wbc907_data/before", 'wbc907_custom_extension_loader', 0 );
}

/************************************************************************
* Redux Options Panel
*************************************************************************/
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxCore/framework.php' ) ) {
	require_once dirname( __FILE__ ) . '/ReduxCore/framework.php';
}

/************************************************************************
* Remove Redux About Page
*************************************************************************/
if(!function_exists('wbc907_remove_redux_menu')){
	function wbc907_remove_redux_menu() {
	    remove_submenu_page('tools.php','redux-about');
	}
	add_action( 'admin_menu', 'wbc907_remove_redux_menu',12 );
}

/************************************************************************
* WBC Importer Extension
*************************************************************************/

if ( !function_exists( 'wbc_after_content_import' ) ) {
	function wbc_after_content_import( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );

		$current_key = key( $demo_active_import );

		//Import Sliders
		if ( class_exists( 'RevSlider' ) ) {
			$wbc_sliders_array = array(
				'creative'       => 'Creative.zip',
				'photography'    => 'photography-demo-slider.zip',
				'photography-v2' => 'photography-v2-demo.zip',
			);

			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
				$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];

				if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
				}
			}
		}

		//Set Menus
		$wbc_menu_array = array(
			'adventure'       => 'Adventure Demo Menu',
			'gym'             => 'Gym Demo Menu',
			'construction'    => 'Construction Demo Menu',
			'drone'           => 'Drone Demo Menu',
			'creative'        => 'Creative Demo Menu',
			'creative-v2'     => 'Creative V2 Demo Menu',
			'single-property' => 'Single Property Demo Menu',
			'barber'          => 'Barber Demo Menu',
			'freelancer'      => 'Freelancer Demo Menu',
			'photography'     => 'Photography Main Demo Menu',
			'photography-v2'  => 'Photography V2 Menu',
			'designer'        => 'Designer Main Demo Menu',
			'app'             => 'Mobile App Demo Menu',
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$top_menu = get_term_by( 'name', $wbc_menu_array[$demo_active_import[$current_key]['directory']] , 'nav_menu' );
			if ( isset( $top_menu->term_id ) ) {
				set_theme_mod( 'nav_menu_locations', array(
						'wbc907-primary' => $top_menu->term_id,
						'wbc907-footer'  => $top_menu->term_id
					)
				);
			}
		}

		//Set Home Page
		$wbc_home_pages = array(
			'adventure'       => 'Homepage Adventure',
			'gym'             => 'Homepage Gym',
			'construction'    => 'Homepage Construction',
			'drone'           => 'Homepage Drone',
			'creative'        => 'Homepage Creative',
			'creative-v2'     => 'Homepage Creative v2',
			'single-property' => 'Homepage Single Property',
			'barber'          => 'Homepage Barber',
			'freelancer'      => 'Homepage Freelancer',
			'photography'     => 'Homepage Photography',
			'photography-v2'  => 'Homepage Photography v2',
			'designer'        => 'Homepage Designer',
			'app'             => 'Homepage APP',
		);
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

	}
	add_action( 'wbc_importer_after_content_import', 'wbc_after_content_import', 10, 2 );
}

if ( !function_exists( 'wbc_filter_title' ) ) {
	function wbc_filter_title( $title ) {
		return trim( ucfirst( str_replace( "-", " ", $title ) ) );
	}
	add_filter( 'wbc_importer_directory_title', 'wbc_filter_title', 10 );
}


/**
 * WP_IMPORTER Filter
 *
 * Filter ran only when import demo content, replaces URL's set by VC
 * when using buttons, links, etc.
 *
 */
if ( !function_exists( 'wbc_url_post_update' ) ) {
	function wbc_url_post_update( $import_data, $wp_import_post ) {

		if ( isset( $import_data['post_type'] ) && $import_data['post_type'] == 'page' && isset( $import_data['post_content'] ) && !empty( $import_data['post_content'] ) ) {

			$encode_url = urlencode( trailingslashit( home_url() ) );
			$replace_array = array(
				'http%3A%2F%2Fthemes.webcreations907.com%2Fninezeroseven%2Fdemo7%2F' => $encode_url,
				'http%3A%2F%2Fthemes.webcreations907.com%2Fninezeroseven%2Fdemo8%2F' => $encode_url
			);

			$import_data['post_content'] = strtr( $import_data['post_content'] , $replace_array );
		}

		return $import_data;
	}

	add_filter( 'wp_import_post_data_processed', 'wbc_url_post_update', 10, 2 );
}
?>