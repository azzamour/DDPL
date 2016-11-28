<?php
$styles = array();
$section_bg_image   = get_post_meta( get_the_id(), 'nzs_parallax_bg_image', true );
$section_bg_color   = get_post_meta( get_the_id(), 'nzs_parallax_bg_color', true );
$section_font_color = get_post_meta( get_the_id(), 'nzs_parallax_font_color', true );
$section_height     = get_post_meta( get_the_id(), 'nzs_parallax_size', true );

if ( $section_bg_image && !empty( $section_bg_image ) ) {
	$styles[] = 'background-image:url(\''.$section_bg_image.'\');';
}

if ( $section_bg_color && !empty( $section_bg_color ) ) {
	$styles[] = 'background-color:'.$section_bg_color.';';
}

if ( $section_font_color && !empty( $section_font_color ) ) {
	$styles[] = 'color:'.$section_font_color.';';
}

if ( $section_height && !empty( $section_height ) && $section_height != '500px' ) {
	$styles[] = 'min-height:'.$section_height.';';
}

$style = '';
if ( count( $styles ) > 0 ) {
	$style = ' style="'.join( ' ', $styles ).'"';
}

$section_title_bar_color  = get_post_meta( get_the_id(), 'nzs_parallax_tb_h_color', true );
$section_sub_title_color  = get_post_meta( get_the_id(), 'nzs_parallax_tb_sh_color', true );

$section_heading_color    = get_post_meta( get_the_id(), 'nzs_parallax_h_color', true );
$section_link_color       = get_post_meta( get_the_id(), 'nzs_parallax_link_color', true );
$section_link_hover_color = get_post_meta( get_the_id(), 'nzs_parallax_link_hover_color', true );

$css_style = '';
$section_selector = '.parallax-sections-'.get_the_id();
if ( $section_title_bar_color && !empty( $section_title_bar_color ) ) {
	$css_style .= $section_selector.' .titleBar h2{color:'.$section_title_bar_color.';}';
	$css_style .= $section_selector.' .titleBar h2:after{background-color:'.$section_title_bar_color.';}';
}
if ( $section_sub_title_color && !empty( $section_sub_title_color ) ) {
	$css_style .= $section_selector.' .titleBar span{color:'.$section_sub_title_color.';}';
}

if ( $section_heading_color && !empty( $section_heading_color ) ) {
	$css_style .= $section_selector.' h1,'.$section_selector.' h2,'.$section_selector.' h3,'.$section_selector.' h4,'.$section_selector.' h5,'.$section_selector.' h6{color:'.$section_heading_color.';}';
}

if ( $section_link_color && !empty( $section_link_color ) ) {
	$css_style .= $section_selector.' a{color:'.$section_link_color .';}';
}

if ( $section_link_hover_color && !empty( $section_link_hover_color ) ) {
	$css_style .= $section_selector.' a:hover{color:'.$section_link_hover_color .';}';
}


if ( !empty( $css_style ) ) {
	echo '<style>'.$css_style.'</style>';
}

$ex_html = '';

$section_overlay_color = get_post_meta( get_the_id(), 'nzs_parallax_overlay_color', true );

if ( $section_overlay_color && !empty( $section_overlay_color ) ) {
	$ex_html .= '<div class="section-overlay" style="background-color:rgba('.wbc907_compat_hex_rgba( $section_overlay_color, get_post_meta( get_the_id(), 'nzs_parallax_overlay_alpha', true ) ).');"></div>';
}

$section_video_enabled = get_post_meta( get_the_id(), 'nzs_video_bg_enable', true );
$css_classes = array();

if ( $section_video_enabled && !empty( $section_video_enabled ) && $section_video_enabled == 'enabled' ) {
	$webm_url = get_post_meta( get_the_id(), 'nzs_video_bg_path_webm', true );
	$mp4_url = get_post_meta( get_the_id(), 'nzs_video_bg_path_mp4', true );
	$ogv_url = get_post_meta( get_the_id(), 'nzs_video_bg_path_ogv', true );
	$video_bg_image = get_post_meta( get_the_id(), 'nzs_video_poster_image', true );

	$poster_video_bg_image = '';
	$video_html = '';
	$css_classes[] = 'video-section self-hosted';
	wp_enqueue_script( 'wp-mediaelement' );
	wp_enqueue_style( 'wp-mediaelement' );

	if ( $video_bg_image ) {

		$poster_video_bg_image = 'poster="'.$video_bg_image .'"';

		$video_html .= '<div class="mobile-video-image" style="background:url(\''.$video_bg_image.'\');"></div>';
	}

	$video_html .= '<div class="wbc-video-bg">';

	$video_html .= '<video class="video-background" muted controls="controls" width="1700" height="970" '.$poster_video_bg_image.' preload="auto" loop autoplay>';

	if ( !empty( $mp4_url ) ) $video_html  .= '<source src="'.esc_attr( $mp4_url ).'" type="video/mp4">';
	if ( !empty( $webm_url ) ) $video_html .= '<source src="'.esc_attr( $webm_url ).'" type="video/webm">';
	if ( !empty( $ogv_url ) ) $video_html  .= '<source src="'.esc_attr( $ogv_url ).'" type="video/ogv">';

	$video_html .='</video>';
	$video_html .='</div>';

	$ex_html .= $video_html;

}


$parallax_speed = get_post_meta( get_the_ID(), 'nzs_parallax_speed', true );

$parallax_repeat = get_post_meta( get_the_ID(), 'nzs_parallax_repeat', TRUE );

if ( empty( $parallax_repeat ) || 'cover' == $parallax_repeat || 'none' == $parallax_repeat ) {
	$css_classes[] = 'has-cover-bg ';
}

$p_data_tag = '';
if ( $parallax_speed == false || 'default' == $parallax_speed ) {
	$p_data_tag = ' data-parallax-speed="0.3"';
}else {
	$p_data_tag = ' data-parallax-speed="'.esc_attr( $parallax_speed ).'"';
}

$ex_classes ='';

if ( count( $css_classes ) > 0 ) {
	$ex_classes = ' '.join( ' ', $css_classes );
}

echo '<div id="'.sanitize_title( get_the_title() ).'" class="wbc-compat-parallax-section parallax-section parallax-sections-'.get_the_id().$ex_classes.'"'.$p_data_tag.$style.'>';
echo $ex_html;
echo '<div class="container">';
echo '<div class="row">';
echo the_content();
echo '</div></div></div>';

?>
