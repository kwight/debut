<?php
/**
 * The template for displaying the footer.
 *
 * (Feel free to remove all links if you choose.)
 *
 * @package Debut 
 * @since 1.0 
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="widget-area footer-left" role="complementary">
			<?php dynamic_sidebar( 'footer-left' ); ?>
		</div>
		<div class="widget-area footer-center" role="complementary">
			<?php dynamic_sidebar( 'footer-center' ); ?>
		</div>
		<div class="widget-area footer-right" role="complementary">
			<?php
			if ( ! dynamic_sidebar( 'footer-right' ) ) : ?>
				<p class="debut-credit">
					<?php printf( __( 'Powered by %1$s. %2$s theme by %3$s.', 'debut' ),'<a href="http://wordpress.org/" target="_blank">WordPress</a>', '<a href="https://github.com/kwight/debut/" target="_blank">Debut</a>', 'kwight' ); ?>
				</p>
			<?php endif; ?>
		</div>
	</footer><!-- #colophon .site-footer -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>