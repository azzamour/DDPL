<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WBC907_Updater {

	function __construct() {
		add_action( 'admin_notices', array( &$this, 'update_notice' ) );

		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

		add_action( 'wp_ajax_wbc907_update', array( $this, 'ajax_update' ) );
	}

	function enqueue_scripts() {
		wp_enqueue_script( 'wbc907-updater', WBC_INCLUDES_DIRECTORY_URI.'theme-compat/assets/js/wbc907-updater.js', '', '1.0', true );
	}

	function ajax_update() {
		if ( !isset( $_REQUEST['nounce'] ) || !wp_verify_nonce( $_REQUEST['nounce'], 'wbc_updater_nonce' ) ) {
			die( 0 );
		}
		if ( isset( $_REQUEST['wbc_update_action'] ) && $_REQUEST['wbc_update_action'] == 'update' ) {
			@set_time_limit( 0 );
			delete_option( 'wbc_update_status' );
			$this->setMessage( '<br/>Starting...<br/>' );
			$new = new WBC907_Compat_Updater;
			$new->run();
		}elseif ( isset( $_REQUEST['wbc_update_action'] ) && $_REQUEST['wbc_update_action'] == 'message' ) {
			echo $this->getMessage();
		}elseif ( isset( $_REQUEST['wbc_update_action'] ) && $_REQUEST['wbc_update_action'] == 'skip-update' ) {
			$wbc_options = get_option('wbc907_data');
			if(is_array($wbc_options) && array_key_exists('opts-compat-theme-mode', $wbc_options)){
				unset($wbc_options['opts-compat-theme-mode']);
				update_option('wbc907_data', $wbc_options);
			}
			update_option( 'nzs_version_info', '4.0' );
		}

		die();
	}

	public function update_notice() {
		$nounce = wp_create_nonce( 'wbc_updater_nonce' );

		echo '<div class="error wbc907-update-notice" style="width:100%;max-width:800px;">';
		echo '<h3>Pre 4.0 907WP Theme Detected, Needs to Run Updater</h3>';
		echo '<p>Dected you have version installed prior to 4.0, please run updater if you\'d like to switch to 4.0.<br/>If you <strong>DON\'T</strong> want to switch to 4.0 you can find the pre 4.0 zip in full package download.</p>';
		echo '<h4><span style="color:red;">WARNING</span>: BACKUP YOUR SITE</h4>';
		echo '<p>Before running updater, you may want to back up your site as settings and posts will be changed<br/><br/></p>';
		echo '<a href="#" class="button button-primary wbc907-run-update" data-nounce="'.esc_attr( $nounce ).'">Run Updater</a>';
		echo '&nbsp;&nbsp;<a data-nounce="'.esc_attr( $nounce ).'" class="button button-secondary wbc907-skip-update" href="#">Skip This Step</a>&nbsp;&nbsp;<a target="_blank" href="http://support.webcreations907.com/forums/topic/updating-to-4-0-from-below-4-0/" style="display:inline-block;margin:5px 0 0 5px;">Check Out Tutorial</a>';
		echo '<br/><br/></div>';

		echo '<div class="updated wbc907-updating-notice" style="width:100%;max-width:800px;display:none;">';
		echo '<p>Starting...</p>';
		echo '</div>';
	}

	public static function getMessage() {
		return get_option( 'wbc_update_status' );
	}

	public static function setMessage( $message ) {
		// delete_option('wbc_update_status');
		$status = get_option( 'wbc_update_status' );
		update_option( 'wbc_update_status', $status.$message.'<br/>' );
	}
}

new WBC907_Updater;

class WBC907_Compat_Updater {

	private $post_id;

	private $post_type;

	private $posts_array = array();

	function __construct() {}

	//Start Updater
	public function run() {
		$this->update_theme_options();
		$this->update_terms();
		$this->process_posts();
		$this->update_sidebars();
		$this->update_menu();

		$this->update_complete();
	}

	private function update_menu() {
		WBC907_Updater::setMessage( 'Updating Menu' );
		$menus = get_theme_mod( 'nav_menu_locations' );

		if ( $menus && is_array( $menus ) && array_key_exists( 'primary', $menus ) && is_int( $menus['primary'] ) ) {
			$menus['wbc907-primary'] = $menus['primary'];
			set_theme_mod( 'nav_menu_locations', $menus );
		}
	}

	private function update_complete() {
		update_option( 'nzs_version_info', '4.0' );
		flush_rewrite_rules();
		WBC907_Updater::setMessage( 'All Done....<br/>' );

		if(class_exists('RegenerateThumbnails')){
			WBC907_Updater::setMessage( '<br/>Make sure to <a href="'.esc_url(admin_url('tools.php?page=regenerate-thumbnails' )).'">Regenerate Thumbnails</a><br/><br/>' );
		}else{
			WBC907_Updater::setMessage( '<br/>Make sure to Regenerate Thumbnails<br/><br/>' );
		}
	}


	private function get_image_by_path( $url ) {
		if ( empty( $url ) ) return;

		$attachment_id = 0;
		$dir = wp_upload_dir();

		if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
			$file = basename( $url );
			$query_args = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'fields'      => 'ids',
				'meta_query'  => array(
					array(
						'value'   => $file,
						'compare' => 'LIKE',
						'key'     => '_wp_attachment_metadata',
					),
				)
			);

			$query = new WP_Query( $query_args );
			if ( $query->have_posts() ) {
				foreach ( $query->posts as $post_id ) {
					$meta = wp_get_attachment_metadata( $post_id );
					$original_file       = basename( $meta['file'] );
					$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
						$attachment_id = $post_id;
						break;
					}
				}
			}

		}
		return $attachment_id;

	}

	private function update_theme_options() {
		WBC907_Updater::setMessage( 'Updating Theme Options' );

		$old_options = get_theme_mods();

		$new_options = get_option( 'wbc907_data' );


		// Update Footer
		if ( isset( $old_options['nzs_footer_text'] ) && !empty( $old_options['nzs_footer_text'] ) ) {
			$new_options['opts-footer-credit'] = $old_options['nzs_footer_text'];
		}

		// Footer Colors
		if ( isset( $old_options['nzs_footer_background'] ) && !empty( $old_options['nzs_footer_background'] ) ) {
			$new_options['opts-enable-footer2-color'] = 1;
			$new_options['opts-footer2-background-color'] = $old_options['nzs_footer_background'];
		}

		if ( isset( $old_options['nzs_footer_font_color'] ) && !empty( $old_options['nzs_footer_font_color'] ) ) {
			$new_options['opts-enable-footer2-color'] = 1;
			$new_options['opts-footer2-color'] = $old_options['nzs_footer_font_color'];
		}

		if ( isset( $old_options['nzs_footer_link_color'] ) && !empty( $old_options['nzs_footer_link_color'] ) ) {
			$new_options['opts-enable-footer2-color'] = 1;
			$new_options['opts-footer2-link-color'] = $old_options['nzs_footer_link_color'];
		}

		if ( isset( $old_options['nzs_footer_link_hover_color'] ) && !empty( $old_options['nzs_footer_link_hover_color'] ) ) {
			$new_options['opts-enable-footer2-color'] = 1;
			$new_options['opts-footer2-link-color-hover'] = $old_options['nzs_footer_link_hover_color'];
		}

		//Update Custom CSS
		if ( isset( $old_options['nzs_custom_css'] ) && !empty( $old_options['nzs_custom_css'] ) ) {
			$new_options['opts-custom-css'] = $old_options['nzs_custom_css'];
		}

		//Update JS
		if ( isset( $old_options['nzs_google_analytics'] ) && !empty( $old_options['nzs_google_analytics'] ) ) {
			$new_options['opts-custom-js'] = $old_options['nzs_google_analytics'];
		}

		//Update Logo
		$new_options['logo-enabled']  = 0;
		$new_options['opts-nav-text'] = get_option( 'blogname' );

		if ( isset( $old_options['nzs_logo'] ) && !empty( $old_options['nzs_logo'] ) ) {
			$new_options['logo-enabled'] = 1;
		}


		// Image Replace
		$image_replace = array(
			'nzs_logo'                   => 'opts-nav-logo',
			'nzs_fullscreen_logo_image'  => 'opts-compat-fullscreen-slider-logo',
			'nzs_parallax_image'         => 'opts-compat-parallax-header-image',
			'nzs_parallax_logo_image'    => 'opts-compat-parallax-header-logo',
			'nzs_custom_slider_bg_image' => 'opts-compat-custom-header-image',
			'nzs_flex_slider_bg_image'   => 'opts-compat-flex-slider-image',
			'nzs_vimeo_image'            => 'opts-compat-vimeo-image',
			'nzs_vimeo_logo_image'       => 'opts-compat-vimeo-logo',
			'nzs_youtube_image'          => 'opts-compat-youtube-image',
			'nzs_youtube_logo_image'     => 'opts-compat-youtube-logo',
		);
		foreach ( $image_replace as $key => $new_key ) {
			if ( isset( $old_options[$key] ) && !empty( $old_options[$key] ) ) {
				$image_url = str_replace( '[site_url]', site_url( '', 'http' ), $old_options[$key] );

				$image_id = $this->get_image_by_path( $image_url );

				if ( $image_id != 0 ) {
					$img_info = wp_get_attachment_image_src( $image_id , 'full' );
					$new_options[$new_key] = array(
						'url'       => $image_url,
						'id'        => $image_id,
						'width'     => $img_info[1],
						'height'    => $img_info[2],
						'thumbnail' => wp_get_attachment_thumb_url( $image_id )
					);
				}else {
					$new_options[$new_key] = array(
						'url'       => $image_url,
						'thumbnail' => $image_url
					);
				}
			}
		}



		// Main Menu Colors
		if ( isset( $old_options['nzs_nav_bg_color'] ) && !empty( $old_options['nzs_nav_bg_color'] ) ) {
			$new_options['opts-enable-menu-color'] = 1;
			$new_options['opts-nav-background'] = $old_options['nzs_nav_bg_color'];
		}

		if ( isset( $old_options['nzs_nav_link_color'] ) && !empty( $old_options['nzs_nav_link_color'] ) ) {
			$new_options['opts-enable-menu-color'] = 1;
			$new_options['opts-nav-link-color'] = $old_options['nzs_nav_link_color'];
		}

		if ( isset( $old_options['nzs_nav_link_hover'] ) && !empty( $old_options['nzs_nav_link_hover'] ) ) {
			$new_options['opts-enable-menu-color'] = 1;
			$new_options['opts-nav-link-color-hover'] = $old_options['nzs_nav_link_hover'];
			$new_options['opts-nav-link-color-active'] = $old_options['nzs_nav_link_hover'];
		}

		//SUB NAV
		if ( isset( $old_options['nzs_nav_subbg'] ) && !empty( $old_options['nzs_nav_subbg'] ) ) {
			$new_options['opts-enable-menu-color'] = 1;
			$new_options['opts-subnav-background'] = $old_options['nzs_nav_subbg'];
		}
		if ( isset( $old_options['nzs_nav_subborder'] ) && !empty( $old_options['nzs_nav_subborder'] ) ) {
			$new_options['opts-enable-menu-color'] = 1;
			$new_options['opts-subnav-link-color-border'] = $old_options['nzs_nav_subborder'];
		}

		if ( isset( $old_options['nzs_header_options'] ) && !empty( $old_options['nzs_header_options'] ) ) {
			$new_header_option = array(
				'fullscreen'   => 'fullscreen-slider',
				'parallax'     => 'parallax-header',
				'flexslider'   => 'flex-slider',
				'customheader' => 'custom-header',
				'video-header' => 'video-header',
			);
			if ( array_key_exists( $old_options['nzs_header_options'], $new_header_option ) ) {
				$new_options['opts-compat-header-type'] = $new_header_option[$old_options['nzs_header_options']];
			}

		}

		if ( isset( $old_options['nzs_nav_position'] ) && !empty( $old_options['nzs_nav_position'] ) ) {
			$menu_location = array(
				'top'    => 'menu-top',
				'bottom' => 'menu-bottom',
			);
			if ( array_key_exists( $old_options['nzs_nav_position'], $menu_location ) ) {
				$new_options['opts-compat-menu-position'] = $menu_location[$old_options['nzs_nav_position']];
			}

		}


		// Sliders
		$slider_array = array(
			'nzs_flex_slider'        => 'opts-compat-flex-slider',
			'nzs_full_screen_slider' => 'opts-compat-fullscreen-slider',
		);
		foreach ( $slider_array as $key => $new_key ) {
			if ( isset( $old_options[$key] ) && !empty( $old_options[$key] ) && is_array( $old_options[$key] ) && count( $old_options[$key] ) > 0 ) {
				$new_slides = array();
				$x = 0;
				foreach ( $old_options[$key] as $value ) {

					if ( isset( $value['url'] ) && !empty( $value['url'] ) ) {
						$image_url = str_replace( '[site_url]', site_url( '', 'http' ), $value['url'] );

						$image_id = $this->get_image_by_path( $image_url );

						if ( $image_id != 0 ) {
							$img_info = wp_get_attachment_image_src( $image_id , 'full' );
							$new_slides[] = array(
								'title'         => $value['title'],
								'url'           => $value['link'],
								'sort'          => $x,
								'description'   => $value['description'],
								'image'         => $image_url,
								'attachment_id' => $image_id,
								'width'         => $img_info[1],
								'height'        => $img_info[2],
								'thumb'         => wp_get_attachment_thumb_url( $image_id )
							);
						}else {
							$new_slides[] = array(
								'title'       => $value['title'],
								'url'         => $value['link'],
								'sort'        => $x,
								'description' => $value['description'],
								'image'       => $image_url,
								'thumb'       => $image_url
							);
						}
					}

					$x++;
				}
				$new_options[$new_key] = $new_slides;
			}
		}

		if ( isset( $old_options['nzs_full_video_type'] ) && !empty( $old_options['nzs_full_video_type'] ) ) {
			$new_options['opts-compat-video-type'] = ( $old_options['nzs_full_video_type'] == 1 ) ? 'vimeo-video' : 'youtube-video';
		}

		// Field Replace
		$field_replace = array(
			'nzs_custom_header_code'        => 'opts-compat-custom-header',
			'nzs_heading_font_fullscreen'   => 'opts-compat-fullscreen-slider-heading-color',
			'nzs_desc_font_fullscreen'      => 'opts-compat-fullscreen-slider-desc-color',
			'nzs_heading_font_flexslider'   => 'opts-compat-flex-slider-heading-color',
			'nzs_desc_font_flexslider'      => 'opts-compat-flex-slider-desc-color',
			'nzs_parallax_heading_text'     => 'opts-compat-parallax-header-heading',
			'nzs_parallax_description_text' => 'opts-compat-parallax-header-desc',
			'nzs_heading_font_parallax'     => 'opts-compat-parallax-header-desc-color',
			'nzs_desc_font_parallax'        => 'opts-compat-parallax-header-heading-color',
			'nzs_vimeo_video_embed'         => 'opts-compat-vimeo-url',
			'nzs_vimeo_volume'              => 'opts-compat-vimeo-volume',
			'nzs_vimeo_video_repeat'        => 'opts-compat-vimeo-repeat',
			'nzs_vimeo_heading_text'        => 'opts-compat-vimeo-heading',
			'nzs_vimeo_description_text'    => 'opts-compat-vimeo-desc',
			'nzs_heading_font_vimeo'        => 'opts-compat-vimeo-heading-color',
			'nzs_desc_font_vimeo'           => 'opts-compat-vimeo-desc-color',
			'nzs_youtube_video_embed'       => 'opts-compat-youtube-url',
			'nzs_youtube_heading_text'      => 'opts-compat-youtube-heading',
			'nzs_youtube_description_text'  => 'opts-compat-youtube-desc',
			'nzs_youtube_volume'            => 'opts-compat-youtube-volume',
			'nzs_youtube_video_repeat'      => 'opts-compat-youtube-repeat',
			'nzs_video_quality'             => 'opts-compat-youtube-quality',
			'nzs_heading_font_youtube'      => 'opts-compat-youtube-heading-color',
			'nzs_desc_font_youtube'         => 'opts-compat-youtube-desc-color',
			'nzs_social_twitter'            => 'opts-compat-social-twitter',
			'nzs_social_facebook'           => 'opts-compat-social-facebook',
			'nzs_social_google'             => 'opts-compat-social-google',
			'nzs_social_flickr'             => 'opts-compat-social-flickr',
			'nzs_social_linkedin'           => 'opts-compat-social-linkedin',
			'nzs_social_pinterest'          => 'opts-compat-social-pinterest',
			'nzs_social_dribbble'           => 'opts-compat-social-dribbble',
			'nzs_social_deviantart'         => 'opts-compat-social-deviantart',
			'nzs_social_youtube'            => 'opts-compat-social-youtube',
			'nzs_social_vimeo'              => 'opts-compat-social-vimeo',
			'nzs_social_instagram'          => 'opts-compat-social-instagram',
			'nzs_social_email'              => 'opts-compat-social-email',
			'nzs_social_soundcloud'         => 'opts-compat-social-soundcloud',
			'nzs_social_behance'            => 'opts-compat-social-behance',
			'nzs_social_ustream'            => 'opts-compat-social-ustream',
			'nzs_social_rss'                => 'opts-compat-social-rss',
			'nzs_fullscreen_speed'          => 'opts-compat-fullscreen-duration',
			'nzs_fullscreen_trans'          => 'opts-compat-fullscreen-transition',
			'nzs_team_cols'                 => 'opts-team-row-count',
			'nzs_team_frame_bg'             => 'opts-compat-team-frame-color',
			'nzs_team_hover_bg'             => 'opts-compat-team-frame-hover-color',
			'nzs_team_name_last'            => 'opts-compat-team-last-name-color',
		);
		foreach ( $field_replace as $key => $new_key ) {
			if ( isset( $old_options[$key] ) && !empty( $old_options[$key] ) ) {
				$new_options[$new_key] = $old_options[$key];
			}
		}

		if(isset( $old_options['nzs_team_name'] ) && is_array($old_options['nzs_team_name']) && array_key_exists('color', $old_options['nzs_team_name']) && !empty($old_options['nzs_team_name']['color'])){
			$new_options['opts-compat-team-first-name-color'] = $old_options['nzs_team_name']['color'];
		}
		if(isset( $old_options['nzs_team_desc'] ) && is_array($old_options['nzs_team_desc']) && array_key_exists('color', $old_options['nzs_team_desc']) && !empty($old_options['nzs_team_desc']['color'])){
			$new_options['opts-compat-team-description-color'] = $old_options['nzs_team_desc']['color'];
		}
		if(isset( $old_options['nzs_team_position'] ) && is_array($old_options['nzs_team_position']) && array_key_exists('color', $old_options['nzs_team_position']) && !empty($old_options['nzs_team_position']['color'])){
			$new_options['opts-compat-team-position-color'] = $old_options['nzs_team_position']['color'];
		}

		//Fonts
		$fonts_array = array(
			'nzs_body_font'         => 'opts-typography-body',
			'nzs_heading_face_font' => 'opts-typography-heading',
			'nzs_menu_face_font'    => 'opts-typography-menu'
		);

		foreach ( $fonts_array as $key => $new_key ) {
			if ( isset( $old_options[$key] ) && !empty( $old_options[$key] ) && is_array( $old_options[$key] ) && count( $old_options[$key] ) > 0 ) {
				$new_font = array();

				$defaults = array(
					'font-family'     => '',
					'font-options'    => '',
					'google'          => true,
					'font-backup'     => '',
					'font-style'      => '',
					'subsets'         => '',
					'font-size'       => '',
					'letter-spacing'  => '',
				);

				if ( isset( $old_options[$key]['size'] ) && !empty( $old_options[$key]['size'] ) ) {
					$new_font['font-size']   = $old_options[$key]['size'];
					$new_font['line-height'] = '';
				}

				if ( isset( $old_options[$key]['face'] ) && !empty( $old_options[$key]['face'] ) ) {
					$new_font['font-family'] = $old_options[$key]['face'];
				}

				if ( isset( $old_options[$key]['color'] ) && !empty( $old_options[$key]['color'] ) && $old_options[$key]['color'] != '#303030' && $old_options[$key]['color'] != '#cc6633') {
					$new_font['color'] = $old_options[$key]['color'];
				}

				if ( count( $new_font ) > 0 ) {
					$new_options[$new_key] = wp_parse_args( $new_font, $defaults );
				}
			}
		}

		//Additional Overrides
		$new_options['opts-bread-crumb'] = 0;
		$new_options['opts-sticky-menu'] = 1;
		$new_options['opts-footer-widget-area-disable'] = 0;
		$new_options['opts-compat-theme-mode'] = 1;

		//update options
		update_option( 'wbc907_data', $new_options );


	}

	private function process_posts() {
		WBC907_Updater::setMessage( 'Updating Posts, Pages, etc' );
		global $post;

		$temp_post = $post;

		$args = array(
			'post_type' => array( 'post', 'page', 'one_page_portfolio', 'team_members', 'page-sections', 'parallax-sections', 'recent_works' ),
			'posts_per_page' => -1
		);

		$custom = new WP_Query( $args );

		if ( $custom->have_posts() ) {
			while ( $custom->have_posts() ) {
				$custom->the_post();
				$this->post_id   = get_the_id();
				$this->post_type = get_post_type();

				switch ( $this->post_type ) {
				case 'one_page_portfolio':
					$this->update_portfolio();
					break;

				case 'recent_works':
					$this->update_recent_works();
					break;

				case 'post':
				case 'page':
					$this->update_meta();
					break;
				}
			}
		}

		$post = $temp_post;
	}

	private function update_portfolio() {
		// Move To wbc-portfolio
		wp_update_post( array(
				'ID'        => $this->post_id,
				'post_type' => 'wbc-portfolio'
			) );

		// Update/Add Filter Buttons
		$old_post_terms = wp_get_post_terms( $this->post_id, 'filter' );
		if ( $old_post_terms ) {
			$terms = array();
			foreach ( $old_post_terms as $term ) {
				$terms[] = $term->name;
			}
			wp_set_object_terms( $this->post_id, $terms , 'portfolio-filter' );
		}

		// Add As Portfolio Item
		wp_set_object_terms( $this->post_id, 'Portfolio Item' , 'portfolio-categories' );


		// Update Post Meta
		$this->update_meta();
	}

	private function update_recent_works() {
		// Move To wbc-portfolio
		wp_update_post( array(
				'ID'        => $this->post_id,
				'post_type' => 'wbc-portfolio'
			) );

		// Add As Recent Work Item
		wp_set_object_terms( $this->post_id, 'Recent Works Item' , 'portfolio-categories' );


		// Update Post Meta
		$this->update_meta();
	}



	private function update_meta() {

		// Update Layout
		$page_layout = get_post_meta( $this->post_id, 'nzs_page_layout', true );

		if ( $page_layout ) {
			$layouts = array(
				'2cl' => 'sidebar-left',
				'2cr' => 'default',
				'1c'  => 'no-sidebar'
			);
			$page_layout = strtr( $page_layout , $layouts );

			if ( $this->post_type == 'post' ) {
				update_post_meta( $this->post_id, 'opts-blog-layout', $page_layout );
			}elseif ( $this->post_type == 'one_page_portfolio' || $this->post_type == 'recent_works' ) {
				update_post_meta( $this->post_id, 'opts-portfolio-layout', $page_layout );
			}
		}

		$sidebars = get_post_meta( $this->post_id, 'nzs_unlimited_sidebar', true );

		if( $sidebars && !empty( $sidebars )){
			switch ( $this->post_type ) {
				case 'post':
					update_post_meta( $this->post_id , 'opts-single-page-sidebar', $sidebars );
					break;

				case 'one_page_portfolio':
				case 'recent_works':
					update_post_meta( $this->post_id , 'opts-single-portfolio-sidebar', $sidebars );
					break;
				
				case 'page':
					update_post_meta( $this->post_id , 'opts-single-page-sidebar', $sidebars );
					break;
			}
		}

		// Update post format type ie gallery/video
		$portfolio_type = get_post_meta( $this->post_id, 'nzs_portfolio_type', true );

		if ( isset( $portfolio_type ) && !empty( $portfolio_type ) ) {
			switch ( $portfolio_type ) {
			case 'image':
				$convert = get_post_meta( $this->post_id, 'nzs_portfolio_gallery', true );
				if ( $convert && is_array( $convert ) ) {
					$convert = join( ',', $convert );

					if ( $this->post_type == 'post' ) {
						set_post_format( $this->post_id, 'gallery' );
						update_post_meta( $this->post_id, 'wbc-gallery-format', $convert );
					}elseif ( $this->post_type == 'one_page_portfolio' || $this->post_type == 'recent_works' ) {
						update_post_meta( $this->post_id, 'opts-portfolio-type', 'gallery' );
						update_post_meta( $this->post_id, 'wbc-portfolio-gallery-format', $convert );
					}
				}

				break;

			case 'video':
				$convert = get_post_meta( $this->post_id, 'nzs_video_link', true );
				if ( $convert ) {
					if ( $this->post_type == 'post' ) {
						set_post_format( $this->post_id, 'video' );
						update_post_meta( $this->post_id, 'wbc-video-embed', $convert );
					}elseif ( $this->post_type == 'one_page_portfolio' || $this->post_type == 'recent_works' ) {
						update_post_meta( $this->post_id, 'opts-portfolio-type', 'video' );
						update_post_meta( $this->post_id, 'wbc-portfolio-video-embed', $convert );
					}

				}
				break;
			}
		}
	}


	private function update_terms() {
		WBC907_Updater::setMessage( 'Updating Portfolio Terms' );
		$old_terms = get_terms( 'filter' , array( 'hide_empty' => 0 ) );

		if ( $old_terms ) {
			foreach ( $old_terms as $term ) {

				$parent_term = term_exists( $term->name, 'portfolio-filter' );

				if ( !$parent_term || empty( $parent_term ) ) {

					$args = array(
						'name'        => $term->name,
						'slug'        => $term->slug,
						'description' => $term->description,
						'parent'      => $term->parent,
					);

					$update = wp_insert_term( $term->name, 'portfolio-filter', $args );
				}
			}
		}
	}


	private function update_sidebars() {
		WBC907_Updater::setMessage( 'Updating Sidebars' );
		$mods = get_theme_mods();
		if ( isset( $mods['nzs_side_bars'] ) && is_array( $mods['nzs_side_bars'] ) ) {
			if( isset($mods['nzs_side_bars']['sidebar-1'])){
				unset($mods['nzs_side_bars']['sidebar-1']);
			}
			$redux_widgets = get_theme_mod( 'redux-widget-areas' );
			if ( isset( $redux_widgets ) && is_array( $redux_widgets ) ) {
				$widgets = array_merge( $redux_widgets, $mods['nzs_side_bars'] );
				set_theme_mod( 'redux-widget-areas', $widgets );
			}else {
				set_theme_mod( 'redux-widget-areas', $mods['nzs_side_bars'] );
			}
		}
	}

}
?>