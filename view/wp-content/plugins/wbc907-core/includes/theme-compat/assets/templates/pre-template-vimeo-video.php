<?php
$wbc_compat_options = get_option('wbc907_data');
$image_bg = '';
if(isset($wbc_compat_options['opts-compat-vimeo-image']) && is_array($wbc_compat_options['opts-compat-vimeo-image']) && isset($wbc_compat_options['opts-compat-vimeo-image']['url']) && !empty($wbc_compat_options['opts-compat-vimeo-image']['url'])){
	$image_bg = 'style="background-image:url(\''.$wbc_compat_options['opts-compat-vimeo-image']['url'].'\')"';
}

if(!function_exists('wbc_compat_vimeo_header')){
	function wbc_compat_vimeo_header(){
		$wbc_compat_options = get_option('wbc907_data');

		if(isset($wbc_compat_options['opts-compat-vimeo-url']) && !empty($wbc_compat_options['opts-compat-vimeo-url'])){
			if( 1 === preg_match('/vimeo.com\/(?:video\/)?([0-9]+)/', $wbc_compat_options['opts-compat-vimeo-url'] , $matches)){
		
				$video_url = $matches[1];

			}else{

				$video_url = "1084537";

			}

			if(isset($wbc_compat_options['opts-compat-vimeo-repeat'])){
				$loop_video = ($wbc_compat_options['opts-compat-vimeo-repeat'] == 1) ? '1' : '0';
			}else{
				$loop_video = '1';
			}

			if(isset($wbc_compat_options['opts-compat-vimeo-volume'])){
				$video_volume = $wbc_compat_options['opts-compat-vimeo-volume'] / 100;
			}else{
				$video_volume = 0.3;
			}
	?>

	<script type="text/javascript">
		(function(){
		   jQuery('#wbc-compat-fullvideo-header').tubular(
		   					{videoId: '<?php echo $video_url;?>',
		   					volumeDefault:<?php echo $video_volume;?>,
		   					repeat:<?php echo $loop_video;?>
		   				});

		   jQuery('.video-header-controls').mouseover(function(){

		   	jQuery('.video-header-controls').stop().animate({'right':'0'});

		   }).mouseout(function(){

		   	jQuery('.video-header-controls').stop().animate({'right':'-180px'});

		   });

		})(jQuery,window);
	</script>
					
	<?php
		}
	}

	add_action( 'wp_footer', 'wbc_compat_vimeo_header', 30);
}
?>
<section id="wbc-compat-fullvideo-header" class="text-center wbc-vimeo-header wbc-compat-header full-height full-width-section">
	
	<div class="video-header-content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php 
						if(isset($wbc_compat_options['opts-compat-vimeo-logo']) && is_array($wbc_compat_options['opts-compat-vimeo-logo']) && isset($wbc_compat_options['opts-compat-vimeo-logo']['url']) && !empty($wbc_compat_options['opts-compat-vimeo-logo']['url'])){
							echo '<div class="header-logo-wrap">';
							echo '<img src="'.esc_attr($wbc_compat_options['opts-compat-vimeo-logo']['url']).'"/>';
							echo '</div>';
						}

						if(isset($wbc_compat_options['opts-compat-vimeo-heading']) && !empty($wbc_compat_options['opts-compat-vimeo-heading'])){
							echo '<h2>'.$wbc_compat_options['opts-compat-vimeo-heading'].'</h2>';
						}

						if(isset($wbc_compat_options['opts-compat-vimeo-desc']) && !empty($wbc_compat_options['opts-compat-vimeo-desc'])){
							echo '<div class="wbc-compat-text-wrap">';
							echo '<p>'.$wbc_compat_options['opts-compat-vimeo-desc'].'</p>';
							echo '</div>';
						}
					?>
				</div>
			</div>
		</div>
		<?php do_action( 'wbc_compat_after_header_content' ); ?>
	</div>

	<div class="video-header-controls clearfix">
		<ul>
			<li class="tubular-play active"><i class="fa fa-play"></i></li>
			<li class="tubular-pause"><i class="fa fa-pause"></i></li>
			<li class="tubular-mute"><i class="fa fa-volume-off"></i></li>
			<li class="tubular-volume-down"><i class="fa fa-volume-down"></i></li>
			<li class="tubular-volume-up"><i class="fa fa-volume-up"></i></li>
		</ul>
		<div class="control-handle"><i class="fa fa-video-camera"></i></div>
	</div>
	<div id="tubular-cover-image" class="wbc-video-header-cover" <?php echo $image_bg; ?>></div>
</section>
