<?php //Silence is golden
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_image_size('team-thumbnail', 250, 250, true);

if ( !function_exists( 'wbc907_compat_sort_sections' ) ) {

    function wbc907_compat_sort_sections() {
		if ( !has_nav_menu( 'wbc907-primary' ) ) {
            return;
        }
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations['wbc907-primary'] ) ) {
			$menu = wp_get_nav_menu_object( $locations['wbc907-primary'] );

            if ( !isset( $menu->term_id ) ) return;

            $items  = wp_get_nav_menu_items( $menu->term_id );

            $sections = array();

            foreach ( (array) $items as $key => $menu_items ) {


                if ( 'page-sections' == $menu_items->object ) {

                    $sections[] = $menu_items->object_id;

                }


            }


            return $sections;

        }

    }

}

if(!function_exists('wbc907_compat_section_loop')){
	function wbc907_compat_section_loop( $id ){
		do_action('wbc907_compat_page_sections', $id );
		do_action('wbc907_compat_parallax_sections', $id );
	}
	add_action('wbc907_compat_sections_loop','wbc907_compat_section_loop');
}

if(!function_exists('wbc907_compat_after_pages')){
	function wbc907_compat_after_pages(){
		do_action('wbc907_compat_parallax_sections', get_the_id() );
		do_action('wbc907_compat_page_sections', get_the_id() );
	}
	add_action('get_footer', 'wbc907_compat_after_pages');
}

if(!function_exists('wbc907_compat_page_section')){
	function wbc907_compat_page_section( $id ) {
		global $post;
		$temp_post = $post;

		if( !is_home() ){
			$page_section_attach = get_post_meta( $id, 'nzs_page_section_custom_attach', true );
			
			if(!$page_section_attach || $page_section_attach == 'none'){
				return;
			}
			$id = $page_section_attach;
		}

		$args = array(
			'p' => $id,
			'post_type' => 'page-sections',
			'posts_per_page' => 1
		);

		$page_section_query = new WP_Query( $args );

		if ( $page_section_query->have_posts() ) {
			while ( $page_section_query->have_posts() ) {
				$page_section_query->the_post();
				load_template( plugin_dir_path( __FILE__ ).'assets/templates/pre-template-page-section.php', false);
			}
		}
		$post = $temp_post;
	}
	add_action( 'wbc907_compat_page_sections', 'wbc907_compat_page_section');
}
if(!function_exists('wbc907_compat_parallax_section')){
	function wbc907_compat_parallax_section( $id ) {
		global $post;
		$temp_post = $post;

		if(is_home()){
			$attached_parallax = get_post_meta( $id, 'nzs_parallax_attach', true );
		}else{
			$attached_parallax = get_post_meta( $id, 'nzs_parallax_custom_attach', true );
		}

		if ( $attached_parallax && $attached_parallax != 'none' ) {

			$args = array(
				'p'              => $attached_parallax,
				'post_type'      => 'parallax-sections',
				'posts_per_page' => 1
			);

			$parallax_section_query = new WP_Query( $args );

			if ( $parallax_section_query->have_posts() ) {
				while ( $parallax_section_query->have_posts() ) {
					$parallax_section_query->the_post();
					load_template( plugin_dir_path( __FILE__ ).'assets/templates/pre-template-parallax-section.php', false);
				}
			}

		}
		$post = $temp_post;
	}
	add_action( 'wbc907_compat_parallax_sections', 'wbc907_compat_parallax_section');
}

if ( !function_exists( 'wbc907_theme_compat_links' ) ) {
	function wbc907_theme_compat_links( $items ) {

		foreach ( $items as $item ) {

			if ( 'page-sections' == $item->object ) {

				$current_post = get_post( $item->object_id );

				$menu_title = "#".$current_post->post_name;

				if ( !is_home() ) {

					$item->url = home_url( '/' ).$menu_title;

				}else {

					$item->url = $menu_title;

				}

			}elseif ( 'custom' == $item->type && !is_home() ) {

				if ( 1 === preg_match( '/^#([^\/]+)$/', $item->url , $matches ) ) {

					$item->url = home_url( '/' ).$item->url;

				}

			}


		}

		return $items;
	}
	add_filter( 'wp_nav_menu_objects', 'wbc907_theme_compat_links' );
}


//TEMPLATE INCLUDE
if ( !function_exists( 'wbc907_theme_compat_template' ) ) {
	function wbc907_theme_compat_template( $template ) {
		if ( is_home() ) {
			return WBC_INCLUDES_DIRECTORY.'theme-compat/template-page-compat.php';
		}

		return $template;
	}
	add_filter( 'template_include', 'wbc907_theme_compat_template' );
}

if ( !function_exists( 'wbc907_theme_compat_menubar_class' ) ) {
	function wbc907_theme_compat_menubar_class( $classes ) {
		if ( is_home() ) {
			$options = get_option( 'wbc907_data' );

			if ( isset( $options['opts-compat-menu-position'] ) && !empty( $options['opts-compat-menu-position'] ) && $options['opts-compat-menu-position'] == 'menu-bottom' ) {
				$classes = str_replace( 'top-fixed-menu', 'bottom-fixed-menu', $classes );
			}
		}

		return $classes;
	}
	add_filter( 'wbc907_menu_class', 'wbc907_theme_compat_menubar_class', 20 );
}


if ( !function_exists( 'wbc907_theme_compat_body_class' ) ) {
	function wbc907_theme_compat_body_class( $classes ) {
		if ( is_home() ) {
			$options = get_option( 'wbc907_data' );

			if ( isset( $options['opts-compat-menu-position'] ) && !empty( $options['opts-compat-menu-position'] ) && $options['opts-compat-menu-position'] == 'menu-bottom' ) {
				$classes = str_replace( 'has-fixed-menu', 'has-bottom-menu', $classes );
			}else {
				if ( isset( $options['opts-compat-header-type'] ) && !empty( $options['opts-compat-header-type'] ) && $options['opts-compat-header-type'] != 'custom-header' && $options['opts-compat-header-type'] != 'flex-slider' ) {
					$classes = str_replace( 'has-fixed-menu', 'has-normal-menu', $classes );
				}
			}


			$classes[] = 'full-width-template';
		}
		return $classes;
	}
	add_filter( 'body_class', 'wbc907_theme_compat_body_class', 20 );
}
if ( !function_exists( 'wbc907_theme_compat_enqueue' ) ) {
	function wbc907_theme_compat_enqueue() {

		$wbc_options = get_option( 'wbc907_data' );

		wp_enqueue_style( 'wbc-compat-theme-style', plugins_url( 'assets/css/wbc-compat-theme.css', __FILE__ ) );

		wp_register_script( 'wbc-compat-form-custom', plugins_url( '/assets/js/jquery.form.js', __FILE__ ), array( 'jquery' ), '', true );
		wp_register_script( 'wbc-compat-form-validate', plugins_url( '/assets/js/jquery.validate.min.js', __FILE__ ), array( 'jquery' ), '', true );
		wp_register_script( 'wbc-compat-contact-form', plugins_url( '/assets/js/contact-form.js', __FILE__ ), array( 'jquery' ), '', true );

		if ( is_home() && isset( $wbc_options['opts-compat-header-type'] ) && !empty( $wbc_options['opts-compat-header-type'] ) ) {
			switch ( $wbc_options['opts-compat-header-type'] ) {
			case 'fullscreen-slider':
				wp_enqueue_style( 'wbc-compat-ss-slider-style', plugins_url( 'assets/css/supersized.css', __FILE__ ) );
				wp_enqueue_style( 'wbc-compat-ss-shutter-style', plugins_url( 'assets/css/supersized.shutter.css', __FILE__ ) );
				wp_enqueue_script( 'wbc-compat-ss-slider', plugins_url( 'assets/js/supersized.3.2.7.js', __FILE__ ), array( 'jquery' ), '', true );
				wp_enqueue_script( 'wbc-compat-ss-shutter', plugins_url( 'assets/js/supersized.shutter.min.js', __FILE__ ), array( 'jquery' ), '', true );
				break;
			case 'video-header':
				$video_types = array( 'youtube-video', 'vimeo-video' );
				if ( isset( $wbc_options['opts-compat-video-type'] ) && !empty( $wbc_options['opts-compat-video-type'] ) && in_array( $wbc_options['opts-compat-video-type'], $video_types ) ) {
					if ( $wbc_options['opts-compat-video-type'] == 'youtube-video' ) {
						wp_enqueue_script( 'wbc-compat-youtube-script', plugins_url( 'assets/js/jquery.tubular.1.0.js', __FILE__ ), array( 'jquery' ), '', true );
					}else {
						wp_enqueue_script( 'wbc-compat-vimeo-froogaloop', plugins_url( 'assets/js/froogaloop.min.js', __FILE__ ), array( 'jquery' ), '', true );
						wp_enqueue_script( 'wbc-compat-vimeo-script', plugins_url( 'assets/js/jquery.tubular.vimeo.js', __FILE__ ), array( 'jquery' ), '', true );
					}
				}
				break;
			}
		}


	}

	add_action( 'wp_enqueue_scripts', 'wbc907_theme_compat_enqueue', 25 );
}
if ( !function_exists( 'wbc_compat_social_links' ) ) {
	function wbc_compat_social_links() {
		$social_args = array(
			'opts-compat-social-twitter'    => 'twitter',
			'opts-compat-social-facebook'   => 'facebook',
			'opts-compat-social-google'     => 'google',
			'opts-compat-social-flickr'     => 'flickr',
			'opts-compat-social-linkedin'   => 'linkedin',
			'opts-compat-social-pinterest'  => 'pinterest',
			'opts-compat-social-dribbble'   => 'dribbble',
			'opts-compat-social-deviantart' => 'deviantart',
			'opts-compat-social-youtube'    => 'youtube',
			'opts-compat-social-vimeo'      => 'vimeo',
			'opts-compat-social-instagram'  => 'instagram',
			'opts-compat-social-email'      => 'envelope',
			'opts-compat-social-soundcloud' => 'soundcloud',
			'opts-compat-social-behance'    => 'behance',
			'opts-compat-social-ustream'    => 'magnet',
			'opts-compat-social-rss'        => 'rss',
		);

		$options = get_option( 'wbc907_data' );

		$social_links = '';
		foreach ( $social_args as $social_option => $social ) {
			if ( isset( $options[$social_option] ) && !empty( $options[$social_option] ) ) {
				$social_links .= '<a class="social-icon '.esc_attr( $social ).'" href="'.esc_url( $options[$social_option] ).'" target="_blank">';
				$social_links .= '<i class="fa fa-'.esc_attr( $social ).'"></i>';
				$social_links .= '</a>';
			}
		}

		if ( !empty( $social_links ) ) {
			echo '<div class="wbc-compat-social">'.$social_links.'</div>';
		}
	}
	add_action( 'wbc_compat_after_header_content', 'wbc_compat_social_links' );
	add_action( 'wbc_compat_social_links', 'wbc_compat_social_links' );
}

//Header
if ( !function_exists( 'wbc907_compat_load_header' ) ) {
	function wbc907_compat_load_header() {
		$options = get_option( 'wbc907_data' );

		if ( isset( $options['opts-compat-header-type'] ) && !empty( $options['opts-compat-header-type'] ) ) {
			switch ( $options['opts-compat-header-type'] ) {
			case 'custom-header':
			case 'fullscreen-slider':
			case 'flex-slider':
			case 'parallax-header':
				$header_file = $options['opts-compat-header-type'];
				break;
			case 'video-header':
				$video_types = array( 'youtube-video', 'vimeo-video' );
				if ( isset( $options['opts-compat-video-type'] ) && !empty( $options['opts-compat-video-type'] ) && in_array( $options['opts-compat-video-type'], $video_types ) ) {
					$header_file = $options['opts-compat-video-type'];
				}
				break;
			}

			if ( isset( $header_file ) && !empty( $header_file ) ) {
				$load_file = WBC_INCLUDES_DIRECTORY.'theme-compat/assets/templates/pre-template-'.$header_file.'.php';

				if ( file_exists( $load_file ) ) {
					@include $load_file;
				}
			}
		}
	}
	add_action( 'wbc907_compat_before_sections', 'wbc907_compat_load_header' );
}

/************************************************************************
* Contact Form
*************************************************************************/

if ( !function_exists( 'ajax_contact' ) ) {
	function ajax_contact() {

		if ( empty( $_POST ) || !wp_verify_nonce( $_POST['wbc_compat_contact_nonce'], 'contact_form' ) ) {
			print 'Sorry, your nonce did not verify.';
			exit;
		}

		$email = get_option( 'admin_email' );

		$errors = 0;

		$from = trim( $_POST['email'] );

		if ( !$email ) {
			$errors = 1;
		}
		if ( empty( $from ) ) {
			$errors = 1;
		}

		if ( !preg_match( "/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $from ) ) {
			$errors = 1;
		}

		if ( isset( $_POST ) ) {

			$subject = "Contact Form Submission";

			$name   = trim( $_POST['name'] );

			$message = trim( stripslashes( $_POST['message'] ) );

			if ( $errors == 0 ) {

				$mail = wp_mail( $email, $subject, $message, "From: ".$name." <".$from.">" );

				if ( $mail ) {

					echo "<h4>".__( 'Message sent.', 'wbc907-core' )."</h4> ".__( 'We will reply as soon as possible.', 'wbc907-core' );

				}else {

					echo __( "There was a problem, please try again.", "wbc907-core" );
				}

			}else {

				echo __( "Setup not completed.", "wbc907-core" );
			}
		}

		die();
	}
	add_action( 'wp_ajax_nopriv_wbc_compat_contact_form', 'ajax_contact' );
	add_action( 'wp_ajax_wbc_compat_contact_form', 'ajax_contact' );
}


if ( !function_exists( 'wbc907_compat_hex_rgba' ) ) {
	function wbc907_compat_hex_rgba( $hex , $alpha = false ) {
		$hex = str_replace( "#", "", $hex );
		$color = array();

		$r = $g = $b = 0;
		if ( strlen( $hex ) == 3 ) {
			$color['r'] = hexdec( substr( $hex, 0, 1 ) . $r );
			$color['g'] = hexdec( substr( $hex, 1, 1 ) . $g );
			$color['b'] = hexdec( substr( $hex, 2, 1 ) . $b );
		}elseif ( strlen( $hex ) == 6 ) {
			$color['r'] = hexdec( substr( $hex, 0, 2 ) );
			$color['g'] = hexdec( substr( $hex, 2, 2 ) );
			$color['b'] = hexdec( substr( $hex, 4, 2 ) );
		}

		if ( $alpha ) {

			if ( !preg_match( '/^[0-9]+$/', $alpha ) ) {

				$color['a'] = 0;

			}else {

				$color['a'] = $alpha / 100;

			}

		}else {

			$color['a'] = 0;

		}

		return implode( ',', $color );
	}
}
?>
