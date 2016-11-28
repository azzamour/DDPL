<?php
/************************************************************************
 * Custom Shortcodes
 *
 * Content filter used ONLY on custom theme shortcodes to remove
 * p and br tags.
 *************************************************************************/


if ( !function_exists( 'nzs_the_content_filter' ) ) {
	function nzs_the_content_filter( $content ) {

		// array of custom shortcodes requiring the fix
		$block = join( "|", array( "portfolio",
				"one_fourth",
				"one_fourth_first",
				"one_fourth_last",
				"one_third",
				"one_third_first",
				"one_third_last",
				"two_thirds",
				"two_thirds_first",
				"two_thirds_last",
				"one_half",
				"one_half_first",
				"one_half_last",
				"three_fourth",
				"three_fourth_first",
				"three_fourth_last",
				"full",
				"full_nested",
				"title_bar",
				"video_box",
				"border_box",
				"clear",
				"button",
				"blog",
				"team",
				"member_info",
				"recent_works",
				"heading",
				"lightbox",
				"nzs_slider",
				"nzs_slides",
				"nzs_service",
				"nzs_heading",
				"social_links",
				"price_table",
				"price_plan",
				"price_option",
				"nzs_contact_form",
				"contact_info",
				"padding_box",
				"social_links",
				"icon_list",
				"icon_list_li",
				"sidebar_shortcode",
				"font_icon",
				"standard_list",
				"standard_list_li"
			) );

		// opening tag
		$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
		// closing tag
		$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep );

		return $rep;

	}
	add_filter( "the_content", "nzs_the_content_filter" );
}

/**************************************
* Sidebar Shortcode
***************************************/
if ( !function_exists( 'get_sidebar_shortcode' ) ) {
	function get_sidebar_shortcode( $atts, $content = null ) {

		$atts = extract( shortcode_atts( array(
					'sidebar' => ''
				), $atts ) );

		if ( empty( $sidebar ) ) {
			$sidebar = 'sidebar-1';
		}

		ob_start();
		dynamic_sidebar( $sidebar );
		$sidebar_code = ob_get_clean();
		return '<div class="sidebar">'.$sidebar_code.'</div>';

	}
	add_shortcode( 'sidebar_shortcode', 'get_sidebar_shortcode' );
}


/************************************************************************
* Columns
*************************************************************************/

if ( !function_exists( 'wrap_container' ) ) {
	function wrap_container( $atts, $content = null ) {

		return "<div class=\"container\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'container', 'wrap_container' );
}

//1/3
if ( !function_exists( 'one_thrid_column' ) ) {
	function one_thrid_column( $atts, $content = null ) {

		return "<div class=\"col-sm-4\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_third', 'one_thrid_column' );
}

if ( !function_exists( 'one_thrid_first' ) ) {
	function one_thrid_first( $atts, $content = null ) {

		return "<div class=\"col-sm-4\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_third_first', 'one_thrid_first' );
}

if ( !function_exists( 'one_thrid_last' ) ) {
	function one_thrid_last( $atts, $content = null ) {

		return "<div class=\"col-sm-4\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_third_last', 'one_thrid_last' );
}


//2/3
if ( !function_exists( 'two_third_column' ) ) {
	function two_third_column( $atts, $content = null ) {

		return "<div class=\"col-sm-8\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'two_thirds', 'two_third_column' );
}

if ( !function_exists( 'two_third_first' ) ) {
	function two_third_first( $atts, $content = null ) {

		return "<div class=\"col-sm-8\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'two_thirds_first', 'two_third_first' );
}

if ( !function_exists( 'two_third_last' ) ) {
	function two_third_last( $atts, $content = null ) {

		return "<div class=\"col-sm-8\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'two_thirds_last', 'two_third_last' );
}

//1/2
if ( !function_exists( 'one_half_column' ) ) {
	function one_half_column( $atts, $content = null ) {

		return "<div class=\"col-sm-6\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_half', 'one_half_column' );
}

if ( !function_exists( 'one_half_first' ) ) {
	function one_half_first( $atts, $content = null ) {

		return "<div class=\"col-sm-6\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_half_first', 'one_half_first' );
}

if ( !function_exists( 'one_half_last' ) ) {
	function one_half_last( $atts, $content = null ) {

		return "<div class=\"col-sm-6\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_half_last', 'one_half_last' );
}
//1/4
if ( !function_exists( 'one_fourth_column' ) ) {
	function one_fourth_column( $atts, $content = null ) {

		return "<div class=\"cols-sm-4\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_fourth', 'one_fourth_column' );
}

if ( !function_exists( 'one_fourth_first' ) ) {
	function one_fourth_first( $atts, $content = null ) {

		return "<div class=\"cols-sm-4\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_fourth_first', 'one_fourth_first' );
}

if ( !function_exists( 'one_fourth_last' ) ) {
	function one_fourth_last( $atts, $content = null ) {

		return "<div class=\"cols-sm-4\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'one_fourth_last', 'one_fourth_last' );
}

if ( !function_exists( 'three_fourth_column' ) ) {
	function three_fourth_column( $atts, $content = null ) {

		return "<div class=\"col-sm-9\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'three_fourth', 'three_fourth_column' );
}

if ( !function_exists( 'three_fourth_first' ) ) {
	function three_fourth_first( $atts, $content = null ) {

		return "<div class=\"col-sm-9\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'three_fourth_first', 'three_fourth_first' );
}

if ( !function_exists( 'three_fourth_last' ) ) {
	function three_fourth_last( $atts, $content = null ) {

		return "<div class=\"col-sm-9\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'three_fourth_last', 'three_fourth_last' );
}

if ( !function_exists( 'full_column' ) ) {
	function full_column( $atts, $content = null ) {

		return "<div class=\"cols-sm-12\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'full', 'full_column' );
}

if ( !function_exists( 'full_nested' ) ) {
	function full_nested( $atts, $content = null ) {

		return "<div class=\"cols-sm-12\">".do_shortcode( $content )."</div>";

	}
	add_shortcode( 'full_nested', 'full_nested' );
}

/************************************************************************
* Responsive video
*************************************************************************/
if ( !function_exists( 'nzs_responsive_video' ) ) {
	function nzs_responsive_video( $atts ) {
		$atts = extract( shortcode_atts( array(
					'video_url' => ''
				), $atts ) );

		if ( isset( $video_url ) ) {

			$video_url = esc_url( $video_url );


			if ( 1 === preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url , $matches ) ) {

				$video_url = 'http://www.youtube.com/embed/'.$matches[1];

			}elseif ( 1 === preg_match( '/vimeo.com\/(?:video\/)?([0-9]+)/', $video_url , $matches ) ) {

				$video_url = 'http://player.vimeo.com/video/'.$matches[1].'?title=0&amp;byline=0&amp;portrait=0';
			}

			if ( !empty( $video_url ) ):
				$video = '';

			$video .= '<div class="video-frame">';
			$video .= '<div class="wbc-video-wrap">';
			$video .= '<iframe src="'.$video_url.'" width="400" height="300" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			$video .= '</div>';
			$video .= '</div>';

			endif;

			return $video;

		}


	}

	add_shortcode( 'video_box', 'nzs_responsive_video' );
}

/************************************************************************
* Border Box
*************************************************************************/
if ( !function_exists( 'border_frame' ) ) {
	function border_frame( $atts, $content = null ) {
		return '<div class="img-frame">'.do_shortcode( $content ).'</div>';
	}

	add_shortcode( 'border_box', 'border_frame' );
}
/************************************************************************
* Standard LI list
*************************************************************************/
if ( !function_exists( 'nzs_standard_list' ) ) {
	function nzs_standard_list( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'list_type'=>''
				), $atts ) );

		$list = '';

		$list .= '<ul class="'.$list_type.'">';

		$list .= do_shortcode( $content );

		$list .= '</ul>';

		return $list;
	}
	add_shortcode( 'standard_list', 'nzs_standard_list' );
}

if ( !function_exists( 'nzs_standard_list_li' ) ) {
	function nzs_standard_list_li( $atts, $content = null ) {

		return '<li>'.$content.'</li>';
	}
	add_shortcode( 'standard_list_li', 'nzs_standard_list_li' );
}

/************************************************************************
* Font Icon list
*************************************************************************/
if ( !function_exists( 'nzs_icon_list' ) ) {
	function nzs_icon_list( $atts, $content = null ) {

		$list = '';

		$list .= '<ul class="shortcode-list-icons">';

		$list .= do_shortcode( $content );

		$list .= '</ul>';

		return $list;
	}

	add_shortcode( 'icon_list', 'nzs_icon_list' );
}

/************************************************************************
* Font Icon list LI's
*************************************************************************/
if ( !function_exists( 'nzs_icon_list_li' ) ) {
	function nzs_icon_list_li( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'icon'=>''
				), $atts ) );

		$icon = ( isset( $icon ) ) ? $icon : '';

		if ( !empty( $icon ) && true == preg_match( '/icon-/', $icon, $matched ) ) {
			$icon = str_replace( 'icon-', 'fa fa-', $icon );
		}elseif ( true == preg_match( '/fa-/', $icon, $matched ) ) {
			$icon = 'fa '.$icon;
		}

		$list = '';

		$list .= '<li>';

		$list .= '<i class="'.$icon.'"></i>';

		$list .= do_shortcode( $content );

		$list .= '</li>';

		return $list;
	}

	add_shortcode( 'icon_list_li', 'nzs_icon_list_li' );
}

/************************************************************************
* Font Icon's
*************************************************************************/
if ( !function_exists( 'nzs_icon_font' ) ) {
	function nzs_icon_font( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'icon'=>''
				), $atts ) );

		if ( !empty( $icon ) && true == preg_match( '/icon-/', $icon, $matched ) ) {
			$icon = str_replace( 'icon-', 'fa fa-', $icon );
		}elseif ( true == preg_match( '/fa-/', $icon, $matched ) ) {
			$icon = 'fa '.$icon;
		}

		return '<i class="shortcode-font-icon '.$icon.'"></i>';
	}

	add_shortcode( 'font_icon', 'nzs_icon_font' );
}

/************************************************************************
* LightBox
*************************************************************************/
if ( !function_exists( 'light_box' ) ) {
	function light_box( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'thumb_img'=>'',
					'full_img' => '',
					'align'=> 'left',
					'alt_text' => ''

				), $atts ) );

		$full_img = ( !empty( $full_img ) ) ? $full_img : $thumb_img;



		$string = sprintf( '<a href="%1$s" data-photo-up="prettyPhoto"><img class="align%2$s img-frame" alt="%3$s" src="%4$s" /></a>',
			esc_attr( $full_img ),
			$align,
			esc_attr( $alt_text ),
			esc_attr( $thumb_img ) );

		return $string;
	}

	add_shortcode( 'lightbox', 'light_box' );
}

/************************************************************************
* Slider
*************************************************************************/
if ( !function_exists( 'custom_slider' ) ) {
	function custom_slider( $atts, $content = null ) {

		$atts = extract( shortcode_atts( array(
					'sub_heading'=>'',
					'heading' => ''

				), $atts ) );

		global $sc_gallery_count;

		$sc_gallery_count = 0;


		$link_up = '';

		preg_match( '/full_img="([^"]+)"/', $content , $matched );

		if ( isset( $matched[1] ) ) {

			$link_up = $matched[1];

		}else {
			preg_match( '/slide_img="([^"]+)"/', $content , $matched );

			$link_up = $matched[1];
		}

		$slide = '';


		$slide .='<div class="flexslider">';
		$slide .='<ul class="slides">';
		$slide .= do_shortcode( $content );
		$slide .='</ul>';
		$slide .='</div>';

		return $slide;

	}
	add_shortcode( 'nzs_slider', 'custom_slider' );
}

if ( !function_exists( 'custom_slides' ) ) {
	function custom_slides( $atts, $content = null ) {

		global $sc_gallery_count, $sc_gallery;

		if ( empty( $sc_gallery_count ) ) $sc_gallery_count = 0;

		if ( $sc_gallery_count == 0 ) {
			$extra_class ='photo-box';
			$sc_gallery = 'sc_slider_'.rand( 0, 999 );
		}else {
			$extra_class ='';
		}

		if ( empty( $sc_gallery ) ) {
			$sc_gallery = 'sc_slider_'.rand( 0, 999 );
		}

		$atts = extract( shortcode_atts( array(
					'title'     => '',
					'full_img'  => '',
					'slide_img' => ''

				), $atts ) );

		$full_img = ( !empty( $full_img ) ) ? $full_img : $slide_img;

		$slides = sprintf( '<li><a href="%1s" title="%2$s" data-photo-up="prettyPhoto['.$sc_gallery.']" class="img-preview %4$s"><img src="%3$s" alt="%2$s" class="scale-with-grid" /></a></li>',
			esc_attr( $full_img ),
			esc_attr( $title ),
			esc_attr( $slide_img ),
			esc_attr( $extra_class ) );

		$sc_gallery_count++;

		return $slides;
	}
	add_shortcode( 'nzs_slides', 'custom_slides' );
}
/************************************************************************
* Title Bar / Headings
*************************************************************************/
if ( !function_exists( 'title_bar' ) ) {
	function title_bar( $atts ) {
		$atts = extract( shortcode_atts( array(
					'sub_heading'=>'',
					'heading' => ''

				), $atts ) );

		$str = "<div class='col-sm-12'><div class=\"titleBar\"><span>".$sub_heading."</span><h2>".$heading."</h2></div></div>";
		return $str;

	}
	add_shortcode( 'title_bar', 'title_bar' );
}

if ( !function_exists( 'heading_bar' ) ) {
	function heading_bar( $atts, $content ) {
		$atts = extract( shortcode_atts( array(
					'heading' => '1'

				), $atts ) );

		$str = "<div class=\"heading\"><h".$heading.">".$content."</h".$heading."></div>";

		return $str;
	}
	add_shortcode( 'nzs_heading', 'heading_bar' );
}

/************************************************************************
* Service
*************************************************************************/
if ( !function_exists( 'service_info' ) ) {
	function service_info( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'icon_url' => '',
					'title'    => '',
					'link'     => '',
					'icon' => '',
				), $atts ) );


		$icon_markup = '';
		$service = '';

		if ( !empty( $icon ) ) {
			$icon_markup .= '<div class="service-icon">';
			$icon_markup .= '<i class="fa '.esc_attr( $icon ).'"></i>';
			$icon_markup .= '</div>';
		}else {
			$icon_markup .= '<img src="'.$icon_url.'" alt="" class="scale-with-grid">';
		}

		$service_icon = $icon_markup;

		if ( !empty( $link ) ) {
			$service_icon = '<a href="'.esc_url( $link ).'">'.$icon_markup.'</a>';
		}

		$service .= '<div class="info">';
		$service .= $service_icon;
		$service .= '<h5>'.$title.'</h5>';
		$service .= do_shortcode( $content );
		$service .= '</div>';

		return $service;

	}
	add_shortcode( 'nzs_service', 'service_info' );
}

/************************************************************************
* Social
*************************************************************************/
if ( !function_exists( 'social_code' ) ) {
	function social_code( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'pos' => '#',
				), $atts ) );

		$links = ob_start();
		do_action( 'wbc_compat_social_links' );
		$links = ob_get_clean();

		if ( !empty( $links ) ) {
			$links = '<div class="wbc-compat-social-shortcode">'.$links.'</div>';
		}

		return $links;

	}

	add_shortcode( 'social_links', 'social_code' );
}

/************************************************************************
* Button
*************************************************************************/
if ( !function_exists( 'color_button' ) ) {
	function color_button( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'url' => '#',
					'color' => '',
					'target' => '_self'

				), $atts ) );

		return "<a href=\"".$url."\" target=\"".$target."\" class=\"button btn-primary ".$color."\">".$content."</a>";

	}
	add_shortcode( 'button', 'color_button' );
}

/************************************************************************
* Member Info
*************************************************************************/

if ( !function_exists( 'member_info' ) ) {
	function member_info( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'position' => '',
					'firstname' => '',
					'lastname' => '',
				), $atts ) );

		$member_out = "";

		$member_out .= "<div class=\"name\">\n";
		$member_out .= "$firstname <span>$lastname</span>\n";
		$member_out .= "<em>$position</em>\n";
		$member_out .= "</div>\n";

		return $member_out;

	}
	add_shortcode( 'member_info', 'member_info' );
}

/************************************************************************
* Clear
*************************************************************************/

if ( !function_exists( 'clear_float' ) ) {
	function clear_float( $atts, $content = null ) {

		return '<div style="clear:both;"></div>';

	}
	add_shortcode( 'clear', 'clear_float' );
}
/************************************************************************
* Portfolio
*************************************************************************/
if ( !function_exists( 'portfolio_show' ) ) {
	function portfolio_show( $atts, $content = null ) {

		global $nzs_category, $smof_data, $gallery_count;

		$atts = extract( shortcode_atts( array(
					'nzs_category' => ''
				), $atts ) );


		if ( !isset( $gallery_count ) ) {
			$gallery_count = 3425;
		}

		if ( !empty( $nzs_category ) && 'all' != $nzs_category ) {
			$nzs_category = $nzs_category;

			$portfolio_file = "portfolio.php";

		}else {
			$nzs_category = '';

			if ( 0 == $smof_data['nzs_iso_portfolio_option'] ) {

				$portfolio_file = "iso-filtered-portfolio.php";

			}else {

				$portfolio_file = "filtered-portfolio.php";
			}
		}

		// ob_start();
		// locate_template( '/assets/php/'.$portfolio_file, true, false );
		// $content = ob_get_clean();
		$gallery_count++;
		return '<div class="col-sm-12 wbc-compat-portfolio">'.do_shortcode( '[wbc_portfolio portfolio_cats="portfolio-item" show_post="12" img_size="post-600x400-image" show_filter="yes" portfolio_display="yes" cols_s="2" cols_xl="4" cols_l="4" excerpt_length="60"]' ).'</div>';//$content;

	}
	add_shortcode( 'portfolio', 'portfolio_show' );
}

/************************************************************************
* Recent Works
*************************************************************************/
if ( !function_exists( 'recent_works_show' ) ) {
	function recent_works_show( $atts, $content = null ) {

		global $nzs_category, $smof_data, $works_count;

		$atts = extract( shortcode_atts( array(
					'nzs_category' => 'recent-works-item'
				), $atts ) );

		if ( !isset( $works_count ) ) {
			$works_count = 3525;
		}

		if ( !empty( $nzs_category ) && 'all' != $nzs_category ) {
			$nzs_category = $nzs_category;

		}else {

			$nzs_category = '';

		}

		// ob_start();
		// locate_template( '/assets/php/recent-works.php', true, false );
		// $content = ob_get_clean();
		// $works_count++;
		return '<div class="col-sm-12 wbc-compat-portfolio">'.do_shortcode( '[wbc_portfolio portfolio_cats="recent-works-item" show_post="6" img_size="post-600x400-image" portfolio_display="yes" cols_s="3" cols_xl="3" cols_l="3" excerpt_length="70"]' ).'</div>';

	}
	add_shortcode( 'recent_works', 'recent_works_show' );
}

/************************************************************************
* Blog
*************************************************************************/

if ( !function_exists( 'blog_show' ) ) {
	function blog_show( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'post_count'    =>'',
					'post_category' =>'',
					'layout' => '',
				), $atts ) );

		$accepted_layouts = array(
			'left-sidebar'  => '2cl',
			'right-sidebar' => '2cr',
			'full-width'    => '1c'
		);

		if ( !empty( $layout ) && array_key_exists( $layout, $accepted_layouts ) ) {
			$blog_layout = $accepted_layouts[$layout];
		}else {
			$blog_layout = '2cr';

		}

		$blog_sc  = '';
		$blog_sc .= '[wbc_blog';

		if(!empty($post_count)){
			$blog_sc .= ' paginate="yes" ajaxed="yes" show_post="'.esc_attr($post_count).'"';
		}else{
			$blog_sc .= ' paginate="yes" ajaxed="yes" show_post="4"';
		}

		if(!empty($post_category)){
			$blog_sc .= ' blog_cats="'.esc_attr($post_category).'"';
		}
		$blog_sc .= ']';

		$blog_html = '';

		switch ( $blog_layout ) {
			case '2cr':
				$blog_html .= '<div class="col-sm-9">';
				$blog_html .= do_shortcode( $blog_sc );
				$blog_html .= '</div>';

				$blog_html .= '<div class="col-sm-3">';
				ob_start();
				dynamic_sidebar( 'sidebar-1' );
				$blog_html .= ob_get_clean();
				$blog_html .= '</div>';

			break;

			case '1c':
				$blog_html .= '<div class="col-sm-12">';
				$blog_html .= do_shortcode( $blog_sc );
				$blog_html .= '</div>';
			
			break;

			case '2cl':
				$blog_html .= '<div class="col-sm-3">';
				ob_start();
				dynamic_sidebar( 'sidebar-1' );
				$blog_html .= ob_get_clean();
				$blog_html .= '</div>';

				$blog_html .= '<div class="col-sm-9">';
				$blog_html .= do_shortcode( $blog_sc );
				$blog_html .= '</div>';

			break;

			default:
				$blog_html .= '<div class="col-sm-9">';
				$blog_html .= do_shortcode( $blog_sc );
				$blog_html .= '</div>';

				$blog_html .= '<div class="col-sm-3">';
				ob_start();
				dynamic_sidebar( 'sidebar-1' );
				$blog_html .= ob_get_clean();
				$blog_html .= '</div>';
			
			break;

		}


		$blog_wrap  = '';
		$blog_wrap .= '<div class="container">';
		$blog_wrap .= '<div class="row wbc-compat-blog">';
		$blog_wrap .= $blog_html;
		$blog_wrap .= '</div>';
		$blog_wrap .= '</div>';

		return $blog_wrap;

	}
	add_shortcode( 'blog', 'blog_show' );
}
/************************************************************************
* Team
*************************************************************************/
if ( !function_exists( 'team_show' ) ) {
	function team_show( $atts, $content = null ) {

		global $nzs_category;

		$atts = extract( shortcode_atts( array(
					'nzs_category' => ''
				), $atts ) );


		if ( !empty( $nzs_category ) && 'all' != $nzs_category ) {

			$nzs_category = $nzs_category;

		}else {

			$nzs_category = '';

		}


		ob_start();
		load_template( plugin_dir_path( __FILE__ ).'assets/templates/pre-template-team.php', false );
		$content = ob_get_clean();

		if(!empty($content)){
			$content_wrap = '';
			$content_wrap .= '<div class="container">';
			$content_wrap .= '<div class="row wbc-compat-team">';
			$content_wrap .= $content;
			$content_wrap .= '</div>';
			$content_wrap .= '</div>';
			$content = $content_wrap;
		}
		return $content;

	}
	add_shortcode( 'team', 'team_show' );
}

/************************************************************************
* Pricing Table
*************************************************************************/

if ( !function_exists( 'pricing_table' ) ) {
	function pricing_table( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'position' => '',
					'firstname' => '',
					'lastname' => '',
				), $atts ) );

		$table = '';

		$table .='<ul class="pricing-table">';

		$table .= do_shortcode( $content );

		$table .='</ul>';

		return $table;

	}
	add_shortcode( 'price_table', 'pricing_table' );
}

if ( !function_exists( 'pricing_plan' ) ) {
	function pricing_plan( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'featured' => '',
					'first_word' => '',
					'last_word' => 'Plan',
					'link' => '#',
					'btn_text' => 'Sign Up!'
				), $atts ) );

		$table = '';

		$table .='<li>';
		$table .='<ul class="plan '.$featured.'">';

		$table .='<li class="plan-head">'.$first_word.' <span>'.$last_word.'</span>';
		$table .= '</li>';

		$table .= do_shortcode( $content );

		$table .= '<li class="order-btn">';
		$table .= '<a href="'.$link.'" class="button btn-primary">'.$btn_text.'</a>';

		$table .= '</li>';

		$table .='</ul>';
		$table .='</li>';

		return $table;

	}
	add_shortcode( 'price_plan', 'pricing_plan' );
}

if ( !function_exists( 'pricing_option' ) ) {
	function pricing_option( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'position' => '',
					'firstname' => '',
					'lastname' => '',
				), $atts ) );


		return '<li>'.$content.'</li>';



	}
	add_shortcode( 'price_option', 'pricing_option' );
}
/************************************************************************
* Contact Form
*************************************************************************/

if ( !function_exists( 'show_contact_form' ) ) {
	function show_contact_form( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'email_label'   => 'Email',
					'name_label'    => 'Name',
					'message_label' => 'Message',
					'btn_label'     => 'Submit',
				), $atts ) );


		$contact_form_message = array(
			'nzs_required_name' => __( 'This field is required.', 'wbc907-core' ),
			'nzs_required_email' => __( 'This field is required.', 'wbc907-core' ),
			'nzs_valid_email' => __( 'Please enter a valid email address.', 'wbc907-core' ),
			'nzs_required_message' => __( 'Please enter a message', 'wbc907-core' ),
		);


		$contact_form_message = apply_filters( 'nzs_contact_form_messages', $contact_form_message );

		wp_enqueue_script( 'wbc-compat-form-custom' );
		wp_enqueue_script( 'wbc-compat-form-validate' );
		wp_enqueue_script( 'wbc-compat-contact-form' );
		wp_localize_script( 'wbc-compat-contact-form', 'nzs_contact_vars', $contact_form_message );


		if ( empty( $email_label ) ) {
			$email_label = 'Email';
		}
		if ( empty( $name_label ) ) {
			$name_label = 'Name';
		}
		if ( empty( $message_label ) ) {
			$message_label = 'Message';
		}
		if ( empty( $btn_label ) ) {
			$btn_label = 'Send';
		}

		$form = '';

		$form .= '<div class="contact-area">';
		$form .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="contactForm">';
		$form .= '<label class="first" for="name">'.$name_label.'</label>';
		$form .= '<input type="text" id="name" name="name" class="required" />';
		$form .= wp_nonce_field( 'contact_form', 'wbc_compat_contact_nonce', true, false );
		$form .= '<label for="cemail">'.$email_label.'</label>';
		$form .= '<input type="text" id="cemail" name="email" class="required email" />';
		$form .= '<label for="message">'.$message_label.'</label>';
		$form .= '<textarea id="message" name="message" class="required" cols="90" rows="5"></textarea>';
		$form .= '<div class="text-right"><input type="submit" class="submit-button color-btn main-btn" value="'.esc_attr( $btn_label ).'"></div>';
		$form .= '</form>';
		$form .= '<div class="successMessage" style="text-align:center; padding:30px 0;"></div>';
		$form .= '</div>';

		return $form;


	}

	add_shortcode( 'nzs_contact_form', 'show_contact_form' );
}

/************************************************************************
* Contact Info
*************************************************************************/
if ( !function_exists( 'show_contact_info' ) ) {
	function show_contact_info( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'name' => '',
					'phone' => '',
					'address' => '',
					'email' => '',
				), $atts ) );



		$info = '';

		$info .='<ul class="contact-info">';

		if ( !empty( $name ) ) {
			$info .='<li class="name"><i class="fa fa-user"></i>'.$name.'</li>';
		}

		if ( !empty( $phone ) ) {
			$info .='<li class="phone"><i class="fa fa-phone"></i>'.$phone.'</li>';
		}

		if ( !empty( $address ) ) {
			$info .='<li class="address"><i class="fa fa-map-marker"></i>'.$address.'</li>';
		}

		if ( !empty( $email ) ) {
			$info .='<li class="email"><i class="fa fa-envelope"></i><a href="mailto:'.esc_attr( $email ).'">'.$email.'</a></li>';
		}


		$info .='</ul>';

		return $info;



	}

	add_shortcode( 'contact_info', 'show_contact_info' );
}

/************************************************************************
* Padding Box
*************************************************************************/

if ( !function_exists( 'add_padding' ) ) {
	function add_padding( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'left' => '',
					'right' => '',
					'top' => '',
					'bottom' => '',
				), $atts ) );


		$left = ( preg_match( '/^([0-9]+)$/', $left ) ) ? $left : '0';
		$right = ( preg_match( '/^([0-9]+)$/', $right ) ) ? $right : '0';
		$top = ( preg_match( '/^([0-9]+)$/', $top ) ) ? $top : '0';
		$bottom = ( preg_match( '/^([0-9]+)$/', $bottom ) ) ? $bottom : '0';


		return '<div class="custom-padding-box clearfix" style="padding:'.$top.'px '.$right.'px '.$bottom.'px '.$left.'px;">'.do_shortcode( $content ).'</div>';

	}

	add_shortcode( 'padding_box', 'add_padding' );
}

if ( !function_exists( 'year_code' ) ) {
	function year_code( $atts, $content = null ) {

		return date( "Y" );

	}
	add_shortcode( 'the-year', 'year_code' );
}

if ( !function_exists( 'theme_link' ) ) {
	function theme_link( $atts, $content = null ) {

		$link = '<a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a>';

		return $link;

	}
	add_shortcode( 'theme-link', 'theme_link' );
}

if ( !function_exists( 'linked_code' ) ) {
	function linked_code( $atts, $content = null ) {
		$atts = extract( shortcode_atts( array(
					'title' => ''
				), $atts ) );

		return '<a href="'.esc_attr( $content ).'">'.$title.'</a>';
	}

	add_shortcode( 'link', 'linked_code' );
}
?>
