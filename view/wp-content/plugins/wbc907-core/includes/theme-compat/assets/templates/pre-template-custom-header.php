<?php 
$wbc_compat_options = get_option('wbc907_data');
$image_bg = '';
if(isset($wbc_compat_options['opts-compat-parallax-header-image']) && is_array($wbc_compat_options['opts-compat-parallax-header-image']) && isset($wbc_compat_options['opts-compat-parallax-header-image']['url'])){
	$image_bg = ' style="background-image:url(\''.$wbc_compat_options['opts-compat-parallax-header-image']['url'].'\')"';
}

?>
<section class="custom-header-option wbc-custom-header"<?php echo $image_bg; ?>>
	
	<?php 
		global $wbc907_data;
		echo do_shortcode( $wbc907_data['opts-compat-custom-header'] );

	 ?>

</section> <!-- ./custom-header-option -->