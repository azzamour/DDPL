<section class="wbc-flex-slider-header full-width-section">
	<script>
	jQuery(window).load(function () {

	    jQuery(".wbc-flex-slider-slides").flexslider({
	        animation: "slide",
	        animationLoop: true,
	        directionNav: true,
	        controlNav: true,
	        start:function(){
	            jQuery(window).trigger('resize');
	        }
	    });

	});
	</script>
	<div class="container">
		<div class="wbc-flex-slider-slides">
			<ul class="slides">

				<?php 

					$wbc_compat_options = get_option('wbc907_data');
					if(isset($wbc_compat_options['opts-compat-flex-slider']) && is_array($wbc_compat_options['opts-compat-flex-slider']) && count($wbc_compat_options['opts-compat-flex-slider']) > 0){
					
						foreach ($wbc_compat_options['opts-compat-flex-slider'] as $slide) {

							if(isset($slide['image']) && !empty($slide['image'])){
								echo '<li>';
								
								if(isset($slide['url']) && !empty($slide['url'])){
									echo '<a href="'.esc_url($slide['url']).'"><img width="970" class="scale-with-grid" alt="" src="'.esc_attr( $slide['image'] ).'"></a>';
								}else{
									echo '<img width="970" class="scale-with-grid" alt="" src="'.esc_attr( $slide['image'] ).'">';
								}

								if(isset($slide['title']) && !empty($slide['title']) || isset($slide['description']) && !empty($slide['description'])){
									echo '<div class="flex-content">';

									if(isset($slide['title']) && !empty($slide['title'])){
										echo '<h4>'.$slide['title'].'</h4>';
									}
									if(isset($slide['description']) && !empty($slide['description'])){
										echo '<p>'.$slide['description'].'</p>';
									}

									echo '</div>';
								}
								echo '</li>';
							}
						}
					}

				 ?>
			</ul>
		</div>
	</div>
</section>