<?php
$wbc_compat_options = get_option('wbc907_data');
$style = '';
if(isset($wbc_compat_options['opts-compat-parallax-header-image']) && is_array($wbc_compat_options['opts-compat-parallax-header-image']) && isset($wbc_compat_options['opts-compat-parallax-header-image']['url'])){
	$image_bg = 'style="background-image:url(\''.$wbc_compat_options['opts-compat-parallax-header-image']['url'].'\')"';
}
?>
<section id="wbc-compat-parallax-header" class="text-center wbc-parallax-header wbc-compat-header full-height full-width-section parallax-section bg-cover-stretch" data-parallax-speed="0.3" <?php echo $image_bg; ?>>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php 
					if(isset($wbc_compat_options['opts-compat-parallax-header-logo']) && is_array($wbc_compat_options['opts-compat-parallax-header-logo']) && isset($wbc_compat_options['opts-compat-parallax-header-logo']['url']) && !empty($wbc_compat_options['opts-compat-parallax-header-logo']['url'])){
						echo '<div class="header-logo-wrap">';
						echo '<img src="'.esc_attr($wbc_compat_options['opts-compat-parallax-header-logo']['url']).'"/>';
						echo '</div>';
					}

					if(isset($wbc_compat_options['opts-compat-parallax-header-heading']) && !empty($wbc_compat_options['opts-compat-parallax-header-heading'])){
						echo '<h2>'.$wbc_compat_options['opts-compat-parallax-header-heading'].'</h2>';
					}

					if(isset($wbc_compat_options['opts-compat-parallax-header-desc']) && !empty($wbc_compat_options['opts-compat-parallax-header-desc'])){
						echo '<div class="wbc-compat-text-wrap">';
						echo '<p>'.$wbc_compat_options['opts-compat-parallax-header-desc'].'</p>';
						echo '</div>';
					}
				?>
			</div>
		</div>
	</div>
	<?php do_action( 'wbc_compat_after_header_content' ); ?>
</section>
