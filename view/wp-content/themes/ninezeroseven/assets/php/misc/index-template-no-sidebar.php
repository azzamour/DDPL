<?php
/************************************************************************
* Standard Post Template w No Sidebar
*************************************************************************/
?>

				<div class="col-sm-12">
					<div class="posts <?php echo apply_filters( 'wbc907_blog_layout_class', '' ); ?>">

						<?php

						if ( have_posts() ) : while ( have_posts() ) : the_post();

							get_template_part( 'assets/php/post-formats/entry', get_post_format() );

						endwhile;

						else:

							get_template_part( 'assets/php/misc/no-results' );

						endif;
						?>
					</div> <!-- ./.posts -->

					<?php wbc907_paging_nav(); ?>

				</div><!-- ./right -->
