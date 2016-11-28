<?php
/*
Template Name: ThemeCompat Pre 4.0
 */

/* Load Header */
get_header();

?>

		<!-- BEGIN MAIN -->

	    <div class="main-content-area full-width-template">

			<div class="page-content clearfix">
				<?php

					do_action( 'wbc907_compat_before_sections' );

					$page_sort_sections = wbc907_compat_sort_sections();

					if ( isset( $page_sort_sections ) && is_array( $page_sort_sections ) && count( $page_sort_sections ) > 0 ) {
						foreach ( $page_sort_sections as $page_section ) {
							do_action( 'wbc907_compat_sections_loop', $page_section );
						}
					}

				?>

			</div> <!-- ./page-content -->

	    <!-- END Main -->
		</div>


<?php
	/* Load Footer */
	get_footer();
?>
