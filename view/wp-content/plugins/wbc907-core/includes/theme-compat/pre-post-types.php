<?php
add_action( 'init', 'one_page_section' );
add_action( 'init', 'one_page_parallax' );
add_action( 'init', 'team_members' );

if ( wbc907_is_pre() ) {
	add_action( 'init', 'one_page_recent_works' );
	add_action( 'init', 'one_page_portfolio' );
}

if ( !function_exists( 'one_page_section' ) ) {
	function one_page_section() {
		$labels = array(
			'name'               => __( 'Page Sections', 'wbc907-core' ),
			'singular_name'      => __( 'Page Sections', 'wbc907-core' ),
			'add_new'            => __( 'Add New Section', 'wbc907-core' ),
			'add_new_item'       => __( 'Add New Section', 'wbc907-core' ),
			'edit_item'          => __( 'Edit section', 'wbc907-core' ),
			'new_item'           => __( 'New section', 'wbc907-core' ),
			'view_item'          => __( 'View section', 'wbc907-core' ),
			'search_items'       => __( 'Search sections', 'wbc907-core' ),
			'not_found'          =>  __( 'No sections found', 'wbc907-core' ),
			'not_found_in_trash' => __( 'No sections found in Trash', 'wbc907-core' ),
			'parent_item_colon'  => ''
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'query_var'           => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'show_in_nav_menus'   => true,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-dismiss',
			'supports'            => array( 'title', 'editor' )
		);
		register_post_type( 'page-sections', $args );
	}
}

if ( !function_exists( 'one_page_parallax' ) ) {
	function one_page_parallax() {
		$labels = array(
			'name'               => __( 'Parallax Sections', 'wbc907-core' ),
			'singular_name'      => __( 'Parallax Sections', 'wbc907-core' ),
			'add_new'            => __( 'Add New Parallax', 'wbc907-core' ),
			'add_new_item'       => __( 'Add New Parallax', 'wbc907-core' ),
			'edit_item'          => __( 'Edit parallax', 'wbc907-core' ),
			'new_item'           => __( 'New parallax', 'wbc907-core' ),
			'view_item'          => __( 'View parallax', 'wbc907-core' ),
			'search_items'       => __( 'Search parallax', 'wbc907-core' ),
			'not_found'          =>  __( 'No parallax found', 'wbc907-core' ),
			'not_found_in_trash' => __( 'No parallax found in Trash', 'wbc907-core' ),
			'parent_item_colon'  => ''
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'query_var'           => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'show_in_nav_menus'   => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-dismiss',
			'supports'            => array( 'title', 'editor' )
		);
		register_post_type( 'parallax-sections', $args );
	}
}

if ( !function_exists( 'one_page_recent_works' ) ) {
	function one_page_recent_works() {
		$labels = array(
			'name'               => __( 'Recent Works', 'wbc907-core' ),
			'singular_name'      => __( 'Recent Works', 'wbc907-core' ),
			'add_new'            => __( 'Add Recent Works', 'wbc907-core' ),
			'add_new_item'       => __( 'Add Recent Works', 'wbc907-core' ),
			'edit_item'          => __( 'Edit Recent Works', 'wbc907-core' ),
			'new_item'           => __( 'New Recent Works', 'wbc907-core' ),
			'view_item'          => __( 'View Recent Works', 'wbc907-core' ),
			'search_items'       => __( 'Search Recent Works', 'wbc907-core' ),
			'not_found'          =>  __( 'No Recent Works found', 'wbc907-core' ),
			'not_found_in_trash' => __( 'No Recent Works found in Trash', 'wbc907-core' ),
			'parent_item_colon'  => ''
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'query_var'           => true,
			'capability_type'     => 'post',
			'show_in_nav_menus'   => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'menu_position'       => 5,
			'rewrite'             => array( 'slug' => 'project' ),
			'menu_icon'           => 'dashicons-dismiss',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' )
		);
		register_post_type( 'recent_works', $args );
	}
}

if ( !function_exists( 'works_categories' ) ) {
	function works_categories() {
		register_taxonomy( "filter_works",
			array( "recent_works" ),
			array(
				"hierarchical"      => true,
				"label"             => __( "Categories", 'wbc907-core' ),
				"singular_label"    => __( "Category", 'wbc907-core' ),
				'show_in_nav_menus' => false,
			)
		);
	}

	add_action( 'init', 'works_categories', 0 );
}

if ( !function_exists( 'team_members' ) ) {
	function team_members() {
		$labels = array(
			'name'               => __( 'Team', 'wbc907-core' ),
			'singular_name'      => __( 'Team', 'wbc907-core' ),
			'add_new'            => __( 'Add Member', 'wbc907-core' ),
			'add_new_item'       => __( 'Add Member', 'wbc907-core' ),
			'edit_item'          => __( 'Edit Member', 'wbc907-core' ),
			'new_item'           => __( 'New Member', 'wbc907-core' ),
			'view_item'          => __( 'View Member', 'wbc907-core' ),
			'search_items'       => __( 'Search Member', 'wbc907-core' ),
			'not_found'          =>  __( 'No Members found', 'wbc907-core' ),
			'not_found_in_trash' => __( 'No Members found in Trash', 'wbc907-core' ),
			'parent_item_colon'  => ''
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'query_var'           => true,
			'rewrite'             => true,
			'show_in_nav_menus'   => false,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-dismiss',
			'supports'            => array( 'title', 'editor', 'thumbnail' )
		);
		register_post_type( 'team_members', $args );
	}
}

if ( !function_exists( 'team_categories' ) ) {
	function team_categories() {
		register_taxonomy( "filter_team",
			array( "team_members" ),
			array(
				"hierarchical"      => true,
				"label"             => __( "Categories", 'wbc907-core' ),
				"singular_label"    => __( "Category", 'wbc907-core' ),
				'show_in_nav_menus' => false,
			)
		);
	}

	add_action( 'init', 'team_categories', 0 );
}

if ( !function_exists( 'one_page_portfolio' ) ) {
	function one_page_portfolio() {
		$labels = array(
			'name'               => __( 'Portfolio', 'wbc907-core' ),
			'singular_name'      => __( 'Portfolio', 'wbc907-core' ),
			'add_new'            => __( 'Add Portfolio', 'wbc907-core' ),
			'add_new_item'       => __( 'Add Portfolio', 'wbc907-core' ),
			'edit_item'          => __( 'Edit Portfolio', 'wbc907-core' ),
			'new_item'           => __( 'New Portfolio', 'wbc907-core' ),
			'view_item'          => __( 'View Portfolio', 'wbc907-core' ),
			'search_items'       => __( 'Search Portfolio', 'wbc907-core' ),
			'not_found'          =>  __( 'No Portfolio found', 'wbc907-core' ),
			'not_found_in_trash' => __( 'No Portfolio found in Trash', 'wbc907-core' ),
			'parent_item_colon'  => ''
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'query_var'           => true,
			'capability_type'     => 'post',
			'show_in_nav_menus'   => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'menu_position'       => 5,
			'rewrite'             => array( 'slug' => 'old-portfolio' ),
			'menu_icon'           => 'dashicons-dismiss',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' )
		);
		register_post_type( 'one_page_portfolio', $args );
	}
}

if ( !function_exists( 'portfolio_filter' ) ) {
	function portfolio_filter() {
		register_taxonomy( "filter",
			array( "one_page_portfolio" ),
			array(
				"hierarchical"      => true,
				"label"             => __( "Filter", 'wbc907-core' ),
				"singular_label"    => __( "Filter", 'wbc907-core' ),
				"rewrite"           => array( 'slug' => 'filter', 'hierarchical' => true ),
				'show_in_nav_menus' => false,
			)
		);
	}

	add_action( 'init', 'portfolio_filter', 0 );
}
?>
