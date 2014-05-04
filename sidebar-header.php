<?php
/**
 * The sidebar area on the right side of the header.
 *
 * @since 1.0
 */
?>
		<div id="tertiary" class="widget-area" role="complementary">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'social',
					'container'      => false,
					'menu_class'     => 'menu-social',
					'depth'          => '1',
					'link_before'     => '<span class="assistive-text">',
					'link_after'      => '</span>',
			) ); ?>

			<?php if ( ! dynamic_sidebar( 'header' ) ) : ?>

				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>

			<?php endif; // end header widget area ?>
		</div><!-- #tertiary .widget-area -->
