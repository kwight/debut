<?php
/**
 * The sidebar area on the right side of the header.
 *
 * @since _s 1.0
 */
?>
		<div id="tertiary" class="widget-area" role="complementary">
			<?php if ( ! dynamic_sidebar( 'header' ) ) : ?>

				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>

			<?php endif; // end header widget area ?>
		</div><!-- #tertiary .widget-area -->
