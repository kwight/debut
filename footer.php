<?php
/**
 * The template for displaying the footer.
 *
 * (Feel free to remove all links if you choose.)
 *
 * @package debut 
 * @since 1.0 
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="widget-area footer-left" role="complementary">
			<?php if ( ! dynamic_sidebar( 'footer-left' ) ) : ?>
				<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
			<?php endif; ?>
		</div>
		<div class="widget-area footer-center" role="complementary">
			<?php if ( ! dynamic_sidebar( 'footer-center' ) ) : ?>
				<?php the_widget( 'WP_Widget_Recent_Comments' ); ?>
			<?php endif; ?>
		</div>
		<div class="widget-area footer-right" role="complementary">
			<?php if ( ! dynamic_sidebar( 'footer-right' ) ) : ?>
				<?php the_widget( 'WP_Widget_Meta' ); ?>
			<?php endif; ?>
		</div>
	</footer><!-- #colophon .site-footer -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>