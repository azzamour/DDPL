<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 *  Wbc_Shortcode_Loader - WBC907 Theme
 *  @author  Webcreations907
 *
 */
if ( !class_exists( 'Wbc_Shortcode_Loader' ) ) {
	class Wbc_Shortcode_Loader {

		/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @var      object
		 */
		protected static $instance = null;

		/**
		 * Holds shortcodes loaded in.
		 *
		 * @var array
		 */
		protected $wbc_shortcodes =  array();


		/**
		 * Fire it up
		 *
		 * @since  1.0.0
		 */
		public function __construct() {

		}


		public function init() {
			add_action( 'after_setup_theme', array( $this, 'get_shortcodes' ) );
			add_filter( 'the_content',  array( $this, 'fix_wpautop_content' ) );
		}

		public function fix_wpautop_content( $content ) {

			if ( !is_array( $this->wbc_shortcodes ) ) {
				return $content;
			}

			// array of custom shortcodes requiring the fix
			$block = join( "|", array_keys( $this->wbc_shortcodes ) );

			// opening tag
			$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
			// closing tag
			$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep );

			return $rep;
		}

		/**
		 * Loads shortcodes
		 */
		public function get_shortcodes() {
			//Check Child Theme Shortcodes
			if ( is_child_theme() ) {
				$child_theme_directory = apply_filters( 'wbc_child_theme_shortcode_directory',  get_stylesheet_directory().'/assets/php/shortcodes/' );
				if ( is_dir( $child_theme_directory ) ) {
					$this->load_shortcodes( $child_theme_directory );
				}
			}

			//Check Theme Shortcode Overrides;
			if ( is_dir( WBC_SHORTCODE_THEME_DIRECTORY ) ) {
				$this->load_shortcodes( WBC_SHORTCODE_THEME_DIRECTORY );
			}

			//Load Plugin Shortcodes;
			if ( is_dir( WBC_SHORTCODE_DIRECTORY ) ) {
				$this->load_shortcodes( WBC_SHORTCODE_DIRECTORY );
			}
		}


		public function load_shortcodes( $directory ) {
			if ( is_dir( $directory ) ) {
				$shortcode_files = glob( $directory.'sc_*.php', GLOB_NOSORT );
				
				if( is_array( $shortcode_files ) && count( $shortcode_files ) > 0 ){
					foreach ( $shortcode_files as $shortcode_file ) {
						if ( false !== preg_match( '/sc_([^.]+).php/', $shortcode_file, $matched ) ) {
							$sc_base = str_replace( '-', '_', $matched[1] );
							$sc_base = trim( str_replace( ' ', '_', $sc_base ) );

							if ( !shortcode_exists( $sc_base ) && !array_key_exists( $sc_base , $this->wbc_shortcodes ) ) {
								$this->wbc_shortcodes[$sc_base] = $shortcode_file;
								$sc_render = new Wbc_Shortcode_Handler( $sc_base );
							}
						}

					}
				}
			}
		}


		/**
		 * Return an instance of this class.
		 *
		 * @since     1.0.0
		 *
		 * @return    object    A single instance of this class.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

	}

	Wbc_Shortcode_Loader::get_instance()->init();
}

if ( !class_exists( 'Wbc_Shortcode_Handler' ) ) {
	class Wbc_Shortcode_Handler extends Wbc_Shortcode_Loader{

		//Shortcode name
		public $shortcode_base = '';

		//Shortcode atts
		public $shortcode_atts = '';

		//Shortcode template file
		public $shortcode_template = false;


		public function __construct( $settings ) {

			$this->shortcode_base = $settings;

			add_shortcode( $this->shortcode_base,  array( $this, 'render' ) );
		}

		/**
		 * Output shortcode content
		 *
		 * @param array   $atts
		 * @param string  $content
		 * @return string
		 */
		public function render( $atts, $content ) {
			$this->shortcode_atts = $atts;

			$this->get_shortcode_template();

			if ( $this->shortcode_template ) {
				$output = '';
				ob_start();
				include $this->shortcode_template;
				$output .= ob_get_contents();
				ob_end_clean();

				return apply_filters( 'wbc_shortcode_content', $output,  $this->shortcode_base, $this->shortcode_atts, $content );
			}
		}

		/**
		 * Sets shortcode template
		 */
		private function get_shortcode_template() {

			if ( array_key_exists( $this->shortcode_base , parent::get_instance()->wbc_shortcodes ) && is_file( parent::get_instance()->wbc_shortcodes[$this->shortcode_base] ) ) {
				$this->shortcode_template = parent::get_instance()->wbc_shortcodes[$this->shortcode_base];
			}else {
				$this->shortcode_template = false;
			}

		}

	}
}