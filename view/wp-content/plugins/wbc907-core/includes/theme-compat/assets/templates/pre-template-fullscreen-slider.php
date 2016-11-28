<?php
$wbc_compat_options = get_option('wbc907_data');

function wbc_compate_fullscreen_script(){
	$wbc_compat_options = get_option('wbc907_data');
	
	if(isset($wbc_compat_options['opts-compat-fullscreen-slider']) && is_array($wbc_compat_options['opts-compat-fullscreen-slider']) && count($wbc_compat_options['opts-compat-fullscreen-slider']) > 0){
		$slides = array();
		$x = 0;
		foreach ($wbc_compat_options['opts-compat-fullscreen-slider'] as $slide ) {
			

			if(isset($slide['image']) && !empty($slide['image'])){
				$slides[$x] = array();

				$slides[$x]['image'] = $slide['image'];
				$content = '';
				if(isset($slide['title']) && !empty($slide['title'])){
					$content .= '<h2>'.$slide['title'].'</h2>';
				}

				if(isset($slide['description']) && !empty($slide['description'])){
					$content .= '<div class="wbc-compat-text-wrap"><p>'.$slide['description'].'</p></div>';
				}

				$slides[$x]['title'] = $content;

				if(isset($slide['url']) && !empty($slide['url'])){
					$slides[$x]['url'] = $slide['url'];
				}
				$x++;
			}


			
		}

		?>
		<script type="text/javascript">
			jQuery(window).load(function(){
			    jQuery(".wbc-fullscreen-slider-header .supersized-slider").supersized({
			        slide_interval: <?php echo ( isset( $wbc_compat_options['opts-compat-fullscreen-duration'] ) ) ? (int) $wbc_compat_options['opts-compat-fullscreen-duration'] : '4000'; ?>,
			        transition: <?php echo ( isset( $wbc_compat_options['opts-compat-fullscreen-transition'] ) ) ? (int) $wbc_compat_options['opts-compat-fullscreen-transition'] : '1'; ?>,
			        transition_speed: 700,
			        new_window: 1,
			        slides: <?php echo json_encode($slides); ?>
			    
			    });
			});
		</script>
		<?php
	}
}
add_action('wp_footer','wbc_compate_fullscreen_script',200);
?>
<section id="wbc-compat-fullscreen-slider-header" class="text-center wbc-fullscreen-slider-header wbc-compat-header full-height full-width-section">
	<div class="supersized-slider">
		<a id="prevslide" class="load-item"></a>
		<a id="nextslide" class="load-item"></a>

		<div id="progress-back" class="load-item">
			<div id="progress-bar"></div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php 
						if(isset($wbc_compat_options['opts-compat-fullscreen-slider-logo']) && is_array($wbc_compat_options['opts-compat-fullscreen-slider-logo']) && isset($wbc_compat_options['opts-compat-fullscreen-slider-logo']['url']) && !empty($wbc_compat_options['opts-compat-fullscreen-slider-logo']['url'])){
							$image_bg = 'style="background-image:url(\''.$wbc_compat_options['opts-compat-fullscreen-slider-logo']['url'].'\')"';
							echo '<div class="header-logo-wrap">';
							echo '<img src="'.esc_attr($wbc_compat_options['opts-compat-fullscreen-slider-logo']['url']).'"/>';
							echo '</div>';
						}
					?>
					<div id="slidecaption" class="message"></div>
				</div>
			</div>
		</div>
		<?php do_action( 'wbc_compat_after_header_content' ); ?>
	</div>

</section>
