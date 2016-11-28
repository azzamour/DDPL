<?php
$styles = array();
$section_bg_image   = get_post_meta( get_the_id(), 'nzs_section_bg_image', true );
$section_bg_color   = get_post_meta( get_the_id(), 'nzs_section_bg_color', true );
$section_font_color = get_post_meta( get_the_id(), 'nzs_section_font_color', true );

if ( $section_bg_image && !empty( $section_bg_image ) ) {
	$styles[] = 'background-image:url(\''.$section_bg_image.'\');';
}

if ( $section_bg_color && !empty( $section_bg_color ) ) {
	$styles[] = 'background-color:'.$section_bg_color.';';
}

if ( $section_font_color && !empty( $section_font_color ) ) {
	$styles[] = 'color:'.$section_font_color.';';
}

$style = '';
if ( count( $styles ) > 0 ) {
	$style = ' style="'.join( ' ', $styles ).'"';
}

$section_title_bar_color  = get_post_meta( get_the_id(), 'nzs_section_tb_h_color', true );
$section_sub_title_color  = get_post_meta( get_the_id(), 'nzs_section_tb_sh_color', true );

$section_heading_color    = get_post_meta( get_the_id(), 'nzs_section_h_color', true );
$section_link_color       = get_post_meta( get_the_id(), 'nzs_section_link_color', true );
$section_link_hover_color = get_post_meta( get_the_id(), 'nzs_section_link_hover_color', true );

$css_style = '';
$section_selector = '.page-sections-'.get_the_id();
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

echo '<div class="wbc-compat-page-section page-sections-'.get_the_id().'"'.$style.'>';
echo '<div class="container"><div class="row">';
echo '<span class="anchor-link" id="'.esc_attr( sanitize_title( get_the_title( ) ) ).'"></span>';
echo the_content();
echo '</div></div></div>';
?>
