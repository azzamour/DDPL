<?php
$wbc_compat_options = get_option('wbc907_data');
$image_bg = '';
if(isset($wbc_compat_options['opts-compat-youtube-image']) && is_array($wbc_compat_options['opts-compat-youtube-image']) && isset($wbc_compat_options['opts-compat-youtube-image']['url']) && !empty($wbc_compat_options['opts-compat-youtube-image']['url'])){
	$image_bg = 'style="background-image:url(\''.$wbc_compat_options['opts-compat-youtube-image']['url'].'\')"';
}

if(!function_exists('wbc_compat_vimeo_header')){
	function wbc_compat_vimeo_header(){
		$wbc_compat_options = get_option('wbc907_data');

		if(isset($wbc_compat_options['opts-compat-youtube-url']) && !empty($wbc_compat_options['opts-compat-youtube-url'])){
			if( 1 === preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $wbc_compat_options['opts-compat-youtube-url'] , $matches)){
		
				$video_url = $matches[1];

			}else{

				$video_url = "pTTkTN_IIck";

			}

			if(isset($wbc_compat_options['opts-compat-youtube-repeat'])){
				$loop_video = ($wbc_compat_options['opts-compat-youtube-repeat'] == 1) ? 'true' : 'false';
			}else{
				$loop_video = 'true';
			}

			if(isset($wbc_compat_options['opts-compat-youtube-volume'])){
				$video_volume = $wbc_compat_options['opts-compat-youtube-volume'];
			}else{
				$video_volume = 30;
			}
			$video_quality ='';
			if(isset($wbc_compat_options['opts-compat-youtube-quality']) && $wbc_compat_options['opts-compat-youtube-quality'] != 'default'){
				$video_quality = ',quality:\''.$wbc_compat_options['opts-compat-youtube-quality'].'\'';
			}
	?>
	<script src="//www.youtube.com/iframe_api"></script>
	<script type="text/javascript">
		(function(){
		   jQuery('#wbc-compat-fullvideo-header').tubular(
		   					{videoId: '<?php echo $video_url;?>',
		   					volumeDefault:<?php echo $video_volume;?>,
		   					repeat:<?php echo $loop_video;?><?php echo $video_quality;?>
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
<section id="wbc-compat-fullvideo-header" class="text-center wbc-youtube-header wbc-compat-header full-height full-width-section">
	
	<div class="video-header-content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php 
						if(isset($wbc_compat_options['opts-compat-youtube-logo']) && is_array($wbc_compat_options['opts-compat-youtube-logo']) && isset($wbc_compat_options['opts-compat-youtube-logo']['url']) && !empty($wbc_compat_options['opts-compat-youtube-logo']['url'])){
							echo '<div class="header-logo-wrap">';
							echo '<img src="'.esc_attr($wbc_compat_options['opts-compat-youtube-logo']['url']).'"/>';
							echo '</div>';
						}

						if(isset($wbc_compat_options['opts-compat-youtube-heading']) && !empty($wbc_compat_options['opts-compat-youtube-heading'])){
							echo '<h2>'.$wbc_compat_options['opts-compat-youtube-heading'].'</h2>';
						}

						if(isset($wbc_compat_options['opts-compat-youtube-desc']) && !empty($wbc_compat_options['opts-compat-youtube-desc'])){
							echo '<div class="wbc-compat-text-wrap">';
							echo '<p>'.$wbc_compat_options['opts-compat-youtube-desc'].'</p>';
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
