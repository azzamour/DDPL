<?php

	global $post,$nzs_category;
	$old = $post;

	$wbc_options = get_option('wbc907_data' );
	
	$team_column_num = "col-sm-3";

	if(isset($wbc_options['opts-team-row-count']) && is_numeric($wbc_options['opts-team-row-count'])){
		switch ($wbc_options['opts-team-row-count']) {
			case '4':
				$team_column_num = 'col-sm-3';
				break;

			case '3':
				$team_column_num = 'col-sm-4';
				break;

			case '2':
				$team_column_num = 'col-sm-6';
				break;
			
			default:
				$team_column_num = 'col-sm-3';
				break;
		}
	}
	
	$target_window   = '_blank';

	$team_query = new WP_Query( array( 'post_type' => 'team_members', 'posts_per_page' => -1, 'order' => 'ASC','filter_team'=>$nzs_category  ) ); 
		
		if($team_query->have_posts()): while($team_query->have_posts()) : $team_query->the_post();

		$team_link        = get_post_meta(get_the_ID(), 'nzs_team_link_option', true);
		$team_link_window = get_post_meta(get_the_ID(), 'nzs_team_link_window', true);

?>
			<div class="<?php echo $team_column_num; ?> compat-member">

				<?php
				if(has_post_thumbnail()){
			 		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'team-thumbnail');
				?>

				<span class="img-wrap">

					<?php if($team_link){?>

					<a href="<?php echo esc_url($team_link);?>" target="<?php esc_attr_e($team_link_window); ?>"><img src="<?php echo $thumb[0];?>" alt="" class="rounded scale-with-grid"></a>

					<?php }else{ ?>
					
					<img src="<?php echo $thumb[0];?>" alt="" class="rounded scale-with-grid">

					<?php } ?>

				</span>

				<?php
				}

				the_content();

				$team_twitter    = get_post_meta( get_the_ID(), 'nzs_member_social_twitter', true);
				$team_facebook   = get_post_meta( get_the_ID(), 'nzs_member_social_facebook', true);
				$team_google     = get_post_meta( get_the_ID(), 'nzs_member_social_google', true);
				$team_flickr     = get_post_meta( get_the_ID(), 'nzs_member_social_flickr', true);
				$team_linkedin   = get_post_meta( get_the_ID(), 'nzs_member_social_linkedin', true);
				$team_dribbble   = get_post_meta( get_the_ID(), 'nzs_member_social_dribbble', true);
				$team_deviantart = get_post_meta( get_the_ID(), 'nzs_member_social_deviantart', true);
				$team_pinterest  = get_post_meta( get_the_ID(), 'nzs_member_social_pinterest', true);
				
				$team_youtube    = get_post_meta( get_the_ID(), 'nzs_member_social_youtube', true);
				$team_vimeo      = get_post_meta( get_the_ID(), 'nzs_member_social_vimeo', true);
				$team_instagram  = get_post_meta( get_the_ID(), 'nzs_member_social_instagram', true);
				$team_email      = get_post_meta( get_the_ID(), 'nzs_member_social_email', true);
				$team_soundcloud = get_post_meta( get_the_ID(), 'nzs_member_social_soundcloud', true);
				$team_behance    = get_post_meta( get_the_ID(), 'nzs_member_social_behance', true);
				$team_ustream    = get_post_meta( get_the_ID(), 'nzs_member_social_ustream', true);
				$team_rss        = get_post_meta( get_the_ID(), 'nzs_member_social_rss', true);


				$social_markup = '';

				if(!empty($team_twitter)){
					$social_markup .= '<a class="social-icon twitter" target="'.esc_attr($target_window).'" href="'.esc_html($team_twitter).'"><i class="fa fa-twitter"></i></a>';
				}
				if(!empty($team_facebook)){
					$social_markup .= '<a class="social-icon facebook" target="'.esc_attr($target_window).'" href="'.esc_html($team_facebook).'"><i class="fa fa-facebook"></i></a>';
				}
				if(!empty($team_google)){
					$social_markup .= '<a class="social-icon google" target="'.esc_attr($target_window).'" href="'.esc_html($team_google).'"><i class="fa fa-google"></i></a>';
				}
				if(!empty($team_flickr)){
					$social_markup .= '<a class="social-icon flickr" target="'.esc_attr($target_window).'" href="'.esc_html($team_flickr).'"><i class="fa fa-flickr"></i></a>';
				}
				if(!empty($team_linkedin)){
					$social_markup .= '<a class="social-icon linkedin" target="'.esc_attr($target_window).'" href="'.esc_html($team_linkedin).'"><i class="fa fa-linkedin"></i></a>';
				}
				if(!empty($team_pinterest)){
					$social_markup .= '<a class="social-icon pinterest" target="'.esc_attr($target_window).'" href="'.esc_html($team_pinterest).'"><i class="fa fa-pinterest"></i></a>';
				}
				if(!empty($team_dribbble)){
					$social_markup .= '<a class="social-icon dribbble" target="'.esc_attr($target_window).'" href="'.esc_html($team_dribbble).'"><i class="fa fa-dribbble"></i></a>';
				}
				if(!empty($team_deviantart)){
					$social_markup .= '<a class="social-icon deviantart" target="'.esc_attr($target_window).'" href="'.esc_html($team_deviantart).'"><i class="fa fa-deviantart"></i></a>';
				}

				if(!empty($team_youtube)){
					$social_markup .= '<a class="social-icon youtube" target="'.esc_attr($target_window).'" href="'.esc_html($team_youtube).'"><i class="fa fa-youtube"></i></a>';
				}

				if(!empty($team_vimeo)){
					$social_markup .= '<a class="social-icon vimeo" target="'.esc_attr($target_window).'" href="'.esc_html($team_vimeo).'"><i class="fa fa-vimeo"></i></a>';
				}

				if(!empty($team_instagram)){
					$social_markup .= '<a class="social-icon instagram" target="'.esc_attr($target_window).'" href="'.esc_html($team_instagram).'"><i class="fa fa-instagram"></i></a>';
				}

				if(!empty($team_email)){
					$social_markup .= '<a class="social-icon email" target="'.esc_attr($target_window).'" href="mailto:'.esc_html($team_email).'"><i class="fa fa-envelope"></i></a>';
				}

				if(!empty($team_soundcloud)){
					$social_markup .= '<a class="social-icon soundcloud" target="'.esc_attr($target_window).'" href="'.esc_html($team_soundcloud).'"><i class="fa fa-soundcloud"></i></a>';
				}

				if(!empty($team_behance)){
					$social_markup .= '<a class="social-icon behance" target="'.esc_attr($target_window).'" href="'.esc_html($team_behance).'"><i class="fa fa-behance"></i></a>';
				}

				if(!empty($team_ustream)){
					$social_markup .= '<a class="social-icon ustream" target="'.esc_attr($target_window).'" href="'.esc_html($team_ustream).'"><i class="fa fa-magnet"></i></a>';
				}

				if(!empty($team_rss)){
					$social_markup .= '<a class="social-icon rss" target="'.esc_attr($target_window).'" href="'.esc_html($team_rss).'"><i class="fa fa-rss"></i></a>';
				}
				
			?>

				<div class="wbc-compat-social">
					<?php echo $social_markup; ?>
				</div>

			</div>
			<?php
			 		
		endwhile;
		endif;

$post = $old;
?>

