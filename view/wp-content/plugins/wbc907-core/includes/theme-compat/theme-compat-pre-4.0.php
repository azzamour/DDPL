<?php //Silence is golden
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Checks if pre 4.0 was installed
if ( !function_exists( 'wbc907_is_pre' ) ) {
	function wbc907_is_pre() {
		// delete_option( 'nzs_version_info' );
		$version_check = get_option( 'nzs_version_info' );
		if ( $version_check && version_compare( $version_check, '4.0', '<' ) ) {
			return true;
		}elseif ( $version_check === false ) {
			$mods = get_theme_mods();
			if ( isset( $mods['smof_init'] ) && isset( $mods['nzs_plain_text_logo'] ) ) {
				update_option( 'nzs_version_info', '3.1.19' );
				return true;
			}else {
				update_option( 'nzs_version_info', '4.0' );
			}
		}

		return false;
	}
}

if ( !function_exists( 'wbc907_compat_mode' ) ) {
	function wbc907_compat_mode() {
		$wbc_options = get_option( 'wbc907_data' );

		if ( isset( $wbc_options['opts-compat-theme-mode'] ) && $wbc_options['opts-compat-theme-mode'] == 1 ||  isset( $wbc_options['opts-compat-theme-mode'] ) && $wbc_options['opts-compat-theme-mode'] == 0 ) {
			return true;
		}

		return false;
	}
}

if ( !function_exists( 'wbc907_is_compat_enabled' ) ) {
	function wbc907_is_compat_enabled() {
		$wbc_options = get_option( 'wbc907_data' );

		if ( isset( $wbc_options['opts-compat-theme-mode'] ) && $wbc_options['opts-compat-theme-mode'] == 1 || true === wbc907_is_pre() ) {
			return true;
		}

		return false;
	}
}

// Load The Updater
if ( !function_exists( 'wbc907_updater_load' ) ) {
	function wbc907_updater_load() {
		if ( wbc907_is_pre() && current_user_can( 'update_themes' ) || defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['wbc_update_action'] ) && $_REQUEST['wbc_update_action'] == 'message' ) {
			//Theme Updater
			include WBC_INCLUDES_DIRECTORY.'theme-compat/class_wbc907_updater.php';
		}
	}
	add_action( 'admin_init', 'wbc907_updater_load' );
}


if ( wbc907_is_pre() || wbc907_compat_mode() ) {

	if ( wbc907_is_compat_enabled() ) {
		// if ( !is_admin() ) {
			//Depreciated Shortcodes
			include WBC_INCLUDES_DIRECTORY.'theme-compat/pre-shortcodes.php';
			include WBC_INCLUDES_DIRECTORY.'theme-compat/pre-theme-functions.php';
		// }

		// Load Pre Post Types
		include WBC_INCLUDES_DIRECTORY.'theme-compat/pre-post-types.php';

	} // END COMPAT ENABLED

	// Require Regenerate Thumbnails, make it easy for upgrading users. :)
	
	if(!function_exists('wbc907_compat_regenerate_thumbnails')){
		function wbc907_compat_regenerate_thumbnails( $plugins ){
			if(!is_array($plugins)){
				$plugins = array();
			}

			$plugins[] = array(
				'name'     => 'Regenerate Thumbnails', // The plugin name
				'slug'     => 'regenerate-thumbnails', // The plugin slug (typically the folder name)
				'required' => false,
				'version'  => ''
			);

			return $plugins;
		}

		add_filter('wbc907_theme_plugins_filter', 'wbc907_compat_regenerate_thumbnails');
	}

	// Adds to themeoptions panel
	if ( !function_exists( 'wbc907_compat_options_panel' ) ) {
		function wbc907_compat_options_panel( $sections ) {
			//$sections = array();
			$sections[] = array(
				'title' => __( 'Depreciated Options', 'wbc907-core' ),
				'desc' => __( 'These settings are depreciated, you can use these settings while Theme Compatibility is enabled.', 'wbc907-core' ),
				'icon' => 'el-icon-remove-sign',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array(
					array(
						'id'        => 'opts-compat-theme-mode',
						'type'      => 'switch',
						'title'     => esc_html__( 'Theme Compatibility Mode', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Enables pre 4.0 mode.', 'wbc907-core' ),
						'desc'      => esc_html__( 'You can disable this once you\'ve setup your new homepage and changed the depreciated shortcodes', 'wbc907-core' ),
						'default' => 0,
						'on'        => esc_html__( 'Enable', 'wbc907-core' ),
						'off'       => esc_html__( 'Disable', 'wbc907-core' ),
						// 'hint' => array(
						//     'title' => 'Hint Title',
						//     'content' => 'This is a <b>hint</b> for the media field with a Title.',
						// )
					),
					array(
						'id'       => 'opts-compat-header-option-info',
						'type'     => 'info',
						'icon'     => 'el el-info-circle',
						'title'    => esc_html__( 'Header Options', 'wbc907-core' ),
						// 'desc'     => esc_html__( 'Header Options', 'wbc907-core' ),
						'required' => array( 'opts-compat-theme-mode', "=", 1 ),
						'style'    => 'info',
					),
					array(
						'id'        => 'opts-compat-header-type',
						'type'      => 'select',
						'title'     => esc_html__( 'Header Options', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Can select your default blog style here', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						//Must provide key => value pairs for select options
						'options'   => array(
							'custom-header'     => 'Custom Header',
							'fullscreen-slider' => 'Full Screen Slider',
							'flex-slider'       => 'Flex Slider',
							'parallax-header'   => 'Parallax Header',
							'video-header'      => 'Video Header'
						),
						'default'   => 'fullscreen-slider'
					),
					//Full Screen Slider
					array(
						'id'          => 'opts-compat-fullscreen-slider',
						'type'        => 'slides',
						'title'       => __( 'Full Screen Slider', 'wbc907-core' ),
						// 'subtitle'    => __('Unlimited slides with drag and drop sortings.', 'wbc907-core'),
						// 'desc'        => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'wbc907-core'),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'fullscreen-slider' ),
						),
						'placeholder' => array(
							'title'           => __( 'This is a title', 'wbc907-core' ),
							'description'     => __( 'Description Here', 'wbc907-core' ),
							'url'             => __( 'Give us a link!', 'wbc907-core' ),
						),
					),
					array(
						'id'        => 'opts-compat-fullscreen-transition',
						'type'      => 'select',
						'title'     => esc_html__( 'Slide Transition', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes slider transition', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'fullscreen-slider' ),
						),
						//Must provide key => value pairs for select options
						'options'   => array(
							'0' => 'None',
							'1' => 'Fade',
							'2' => 'Slide Top',
							'3' => 'Slide Right',
							'4' => 'Slide Bottom',
							'5' => 'Slide Left',
							'6' => 'Carousel Right',
							'7' => 'Carousel Left',
						),
						'default'   => '0'
					),
					array(
						'id'        => 'opts-compat-fullscreen-duration',
						'type'      => 'slider',
						'title'     => __( 'Slide Duration', 'wbc907-core' ),
						'subtitle'  => __( 'Amount of time between slides.', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'fullscreen-slider' ),
						),
						"default"   => 4000,
						"min"       => 1000,
						"step"      => 1,
						"max"       => 20000,
						'display_value' => 'label'
					),
					array(
						'id'        => 'opts-compat-fullscreen-slider-logo',
						'type'      => 'media',
						'title'     => esc_html__( 'Header Logo', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Logo displayed within header.', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'fullscreen-slider' ),
						),
						'default' => '',
					),
					array(
						'id'          => 'opts-compat-fullscreen-slider-heading-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Slider Title Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes heading color for fullscreen slider', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'fullscreen-slider' ),
						),
						'output'    => array(
							'color' => '.wbc-fullscreen-slider-header h2'
						)
					),
					array(
						'id'          => 'opts-compat-fullscreen-slider-desc-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Slider Description Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes description color for fullscreen slider', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'fullscreen-slider' ),
						),
						'output'    => array(
							'color' => '.wbc-fullscreen-slider-header p'
						)
					),

					//Flex Slider
					array(
						'id'          => 'opts-compat-flex-slider',
						'type'        => 'slides',
						'title'       => __( 'Flex Slider', 'wbc907-core' ),
						// 'subtitle'    => __('Unlimited slides with drag and drop sortings.', 'wbc907-core'),
						// 'desc'        => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'wbc907-core'),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'flex-slider' ),
						),
						'placeholder' => array(
							'title'           => __( 'This is a title', 'wbc907-core' ),
							'description'     => __( 'Description Here', 'wbc907-core' ),
							'url'             => __( 'Give us a link!', 'wbc907-core' ),
						),
					),
					array(
						'id'        => 'opts-compat-flex-slider-image',
						'type'      => 'media',
						'title'     => esc_html__( 'Background Image', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Image to display in background', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'flex-slider' ),
						),
						'default' => '',
					),
					array(
						'id'          => 'opts-compat-flex-slider-heading-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Slider Title Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes heading color for Flex Slider', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'flex-slider' ),
						),
						'output'    => array(
							'color' => '.wbc-flex-slider-header .flex-content h4'
						)
					),
					array(
						'id'          => 'opts-compat-flex-slider-desc-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Slider Description Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes description color for Flex Slider', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'flex-slider' ),
						),
						'output'    => array(
							'color' => '.wbc-flex-slider-header .flex-content p'
						)
					),

					//Custom Header
					array(
						'id'        => 'opts-compat-custom-header',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Custom Header Code', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'custom-header' ),
						),
						'subtitle'  => esc_html__( 'Accepts HTML and shortcodes such as Revolution Slider and Cute3d Slider', 'wbc907-core' ),
						'desc'      => '',
					),
					array(
						'id'        => 'opts-compat-custom-header-image',
						'type'      => 'media',
						'title'     => esc_html__( 'Background Image', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Image to display in background', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'custom-header' ),
						),
						'default' => '',
					),

					// Parallax Header
					array(
						'id'        => 'opts-compat-parallax-header-image',
						'type'      => 'media',
						'title'     => esc_html__( 'Parallax Image', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Image to display in header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'parallax-header' ),
						),
						'default' => '',
					),
					array(
						'id'        => 'opts-compat-parallax-header-heading',
						'type'      => 'text',
						'title'     => esc_html__( 'Parallax Heading', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Heading to display on parallax header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'parallax-header' ),
						),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-parallax-header-desc',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Parallax Description', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Text within the header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'parallax-header' ),
						),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-parallax-header-logo',
						'type'      => 'media',
						'title'     => esc_html__( 'Header Logo', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Logo displayed within header.', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'parallax-header' ),
						),
						'default' => '',
					),
					array(
						'id'          => 'opts-compat-parallax-header-heading-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Parallax Title Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes heading color for Parallax Header', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'parallax-header' ),
						),
						'output'    => array(
							'color' => '.wbc-parallax-header h2'
						)
					),
					array(
						'id'          => 'opts-compat-parallax-header-desc-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Parallax Description Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes description color for Parallax Header', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'parallax-header' ),
						),
						'output'    => array(
							'color' => '.wbc-parallax-header p'
						)
					),

					// Video Header
					array(
						'id'        => 'opts-compat-video-type',
						'type'      => 'select',
						'title'     => esc_html__( 'Video Type', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Choose between Youtube or Vimeo', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
						),
						//Must provide key => value pairs for select options
						'options'   => array(
							'youtube-video'     => 'Youtube Video',
							'vimeo-video'     => 'Vimeo Video',
						),
						'default'   => 'youtube-video'
					),
					//Vimeo
					array(
						'id'        => 'opts-compat-vimeo-url',
						'type'      => 'text',
						'title'     => esc_html__( 'Vimeo Embed URL', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Embed url like: http://player.vimeo.com/video/7449107', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'default'   => ''
					), array(
						'id'        => 'opts-compat-vimeo-image',
						'type'      => 'media',
						'title'     => esc_html__( 'Cover Image', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Image to display in header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'default' => '',
					),
					array(
						'id'        => 'opts-compat-vimeo-repeat',
						'type'      => 'switch',
						'title'     => esc_html__( 'Video Loop', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Loops video when enabled', 'wbc907-core' ),
						'default'  => 1,
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'on'        => esc_html__( 'Enable', 'wbc907-core' ),
						'off'       => esc_html__( 'Disable', 'wbc907-core' ),
						// 'hint' => array(
						//     'title' => 'Hint Title',
						//     'content' => 'This is a <b>hint</b> for the media field with a Title.',
						// )
					),
					array(
						'id'        => 'opts-compat-vimeo-volume',
						'type'      => 'slider',
						'title'     => __( 'Starting Volume', 'wbc907-core' ),
						'subtitle'  => __( 'Sets volume video will be played at', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						"default"   => 30,
						"min"       => 0,
						"step"      => 1,
						"max"       => 100,
						'display_value' => 'label'
					),
					array(
						'id'        => 'opts-compat-vimeo-heading',
						'type'      => 'text',
						'title'     => esc_html__( 'Video Heading', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Heading to display on video header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-vimeo-desc',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Video Description', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Text within the header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-vimeo-logo',
						'type'      => 'media',
						'title'     => esc_html__( 'Header Logo', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Logo displayed within header.', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'default' => '',
					),
					array(
						'id'          => 'opts-compat-vimeo-heading-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Title Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes heading color for Video Header', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'output'    => array(
							'color' => '.wbc-vimeo-header h2'
						)
					),
					array(
						'id'          => 'opts-compat-vimeo-desc-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Description Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes description color for Video Header', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'vimeo-video' ),
						),
						'output'    => array(
							'color' => '.wbc-vimeo-header p'
						)
					),
					//Youtube
					array(
						'id'        => 'opts-compat-youtube-url',
						'type'      => 'text',
						'title'     => esc_html__( 'Youtube Embed URL', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Embed url like: http://www.youtube.com/embed/pTTkTN_IIck', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'default'   => ''
					), array(
						'id'        => 'opts-compat-youtube-image',
						'type'      => 'media',
						'title'     => esc_html__( 'Cover Image', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Image to display in header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'default' => '',
					),
					array(
						'id'        => 'opts-compat-youtube-repeat',
						'type'      => 'switch',
						'title'     => esc_html__( 'Video Loop', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Loops video when enabled', 'wbc907-core' ),
						'default'  => 1,
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'on'        => esc_html__( 'Enable', 'wbc907-core' ),
						'off'       => esc_html__( 'Disable', 'wbc907-core' ),
						// 'hint' => array(
						//     'title' => 'Hint Title',
						//     'content' => 'This is a <b>hint</b> for the media field with a Title.',
						// )
					),
					array(
						'id'        => 'opts-compat-youtube-volume',
						'type'      => 'slider',
						'title'     => __( 'Starting Volume', 'wbc907-core' ),
						'subtitle'  => __( 'Sets volume video will be played at', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						"default"   => 30,
						"min"       => 0,
						"step"      => 1,
						"max"       => 100,
						'display_value' => 'label'
					),
					array(
						'id'        => 'opts-compat-youtube-quality',
						'type'      => 'select',
						'title'     => esc_html__( 'Video Quality', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Tries to load selected quality', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						//Must provide key => value pairs for select options
						'options'   => array(
							'default' => 'Default',
							'small'   => 'Small',
							'medium'  => 'Medium',
							'large'   => 'Large',
							'hd720'   => 'HD 720',
							'hd1080'  => 'HD 1080',
							'highres' => 'High Res'
						),
						'default'   => 'default'
					),
					array(
						'id'        => 'opts-compat-youtube-heading',
						'type'      => 'text',
						'title'     => esc_html__( 'Video Heading', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Heading to display on video header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-youtube-desc',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Video Description', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Text within the header', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-youtube-logo',
						'type'      => 'media',
						'title'     => esc_html__( 'Header Logo', 'wbc907-core' ),
						'mode'      => 'image', // Can be set to false to allow any media type, or can also be set to any mime type.
						//'desc'      => esc_html__('Basic media uploader with disabled URL input field.', 'wbc907-core'),
						'subtitle'  => esc_html__( 'Logo displayed within header.', 'wbc907-core' ),
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'default' => '',
					),
					array(
						'id'          => 'opts-compat-youtube-heading-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Title Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes heading color for Video Header', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'output'    => array(
							'color' => '.wbc-youtube-header h2'
						)
					),
					array(
						'id'          => 'opts-compat-youtube-desc-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Description Color', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Changes description color for Video Header', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'required'  => array(
							array( 'opts-compat-theme-mode', "=", 1 ),
							array( 'opts-compat-header-type', "=", 'video-header' ),
							array( 'opts-compat-video-type', "=", 'youtube-video' ),
						),
						'output'    => array(
							'color' => '.wbc-youtube-header p'
						)
					),

					//menu
					array(
						'id'        => 'opts-compat-menu-position',
						'type'      => 'select',
						'title'     => esc_html__( 'Menu Position', 'wbc907-core' ),
						'subtitle'  => esc_html__( 'Position for menu to be displayed', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						//Must provide key => value pairs for select options
						'options'   => array(
							'menu-top'     => 'Top Of Page',
							'menu-bottom' => 'Bottom Of Page',
						),
						'default'   => 'menu-top'
					),
					//Team
					array(
						'id'   => 'opts-compat-team-info',
						'type' => 'info',
						'title' => __( 'Team Settings', 'wbc907-core' ),
						'icon' => 'el el-info-circle',
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'style' => 'info',
					),
					array(
						'id'        => 'opts-team-row-count',
						'type'      => 'select',
						'title'     => esc_html__( 'Team Row Count', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'subtitle'  => esc_html__( 'Changes number of team display per row', 'wbc907-core' ),
						//Must provide key => value pairs for select options
						'options'   => array(
							4 => '4 Per Row',
							3 => '3 Per Row',
							2 => '2 Per Row',
						),
						'default'   => 4
					),
					array(
						'id'          => 'opts-compat-team-frame-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Image BG Color', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'subtitle'  => esc_html__( 'Changes image background color', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'output'    => array(
							'background-color' => '.wbc-compat-team .img-wrap'
						)
					),
					array(
						'id'          => 'opts-compat-team-frame-hover-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Image BG Hover Color', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'subtitle'  => esc_html__( 'Changes image hover background color', 'wbc907-core' ),
						'transparent' => false,
						'default'     => '',
						'output'    => array(
							'background-color' => '.wbc-compat-team .img-wrap:hover'
						)
					),
					array(
						'id'          => 'opts-compat-team-first-name-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Member First Name Color', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'transparent' => false,
						'default'     => '',
						'output'    => array(
							'color' => '.wbc-compat-team .name'
						)
					),
					array(
						'id'          => 'opts-compat-team-last-name-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Member Last Name Color', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'transparent' => false,
						'default'     => '',
						'output'    => array(
							'color' => '.wbc-compat-team .name span'
						)
					),
					array(
						'id'          => 'opts-compat-team-position-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Member Position Color', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'transparent' => false,
						'default'     => '',
						'output'    => array(
							'color' => '.wbc-compat-team .name em'
						)
					),
					array(
						'id'          => 'opts-compat-team-description-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Description Color', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'transparent' => false,
						'default'     => '',
						'output'    => array(
							'color' => '.wbc-compat-team'
						)
					),
					//Social
					array(
						'id'   => 'opts-compat-social-icon-info',
						'type' => 'info',
						'title' => __( 'Social Links', 'wbc907-core' ),
						'icon' => 'el el-info-circle',
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'style' => 'info',
					),
					array(
						'id'        => 'opts-compat-social-twitter',
						'type'      => 'text',
						'title'     => esc_html__( 'Twitter URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-facebook',
						'type'      => 'text',
						'title'     => esc_html__( 'Facebook URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-google',
						'type'      => 'text',
						'title'     => esc_html__( 'Google URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-flickr',
						'type'      => 'text',
						'title'     => esc_html__( 'Flickr URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-linkedin',
						'type'      => 'text',
						'title'     => esc_html__( 'Linkedin URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-pinterest',
						'type'      => 'text',
						'title'     => esc_html__( 'Pinterest URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-dribbble',
						'type'      => 'text',
						'title'     => esc_html__( 'Dribbble URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-deviantart',
						'type'      => 'text',
						'title'     => esc_html__( 'Deviantart', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-youtube',
						'type'      => 'text',
						'title'     => esc_html__( 'Youtube URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-vimeo',
						'type'      => 'text',
						'title'     => esc_html__( 'Vimeo URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-instagram',
						'type'      => 'text',
						'title'     => esc_html__( 'Instagram URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-email',
						'type'      => 'text',
						'title'     => esc_html__( 'Email URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-soundcloud',
						'type'      => 'text',
						'title'     => esc_html__( 'Soundcloud URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-behance',
						'type'      => 'text',
						'title'     => esc_html__( 'Behance URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-ustream',
						'type'      => 'text',
						'title'     => esc_html__( 'Ustream URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),
					array(
						'id'        => 'opts-compat-social-rss',
						'type'      => 'text',
						'title'     => esc_html__( 'RSS URL', 'wbc907-core' ),
						'required'  => array( 'opts-compat-theme-mode', "=", 1 ),
						'default'   => ''
					),

				)
			);
			return $sections;
		}
		add_filter( 'redux/options/wbc907_data/sections', 'wbc907_compat_options_panel' );
	}
}
?>
