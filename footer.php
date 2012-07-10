<?php
/**
 * The template for displaying the footer.
 *
 * Don't like all that Pordwress-theme-code-y crap down there? Replace it
 * with whatever you like, or remove it all together :)
 *
 * @since 1.0 
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wp-credit">
			<?php printf( __( 'Proudly powered by %s.', 'debut' ), '<a href="http://wordpress.org/" target="_blank">WordPress</a>' ); ?>
		</div><!-- .wp-credit -->
		<div class="dev-credit">
			<?php printf( __( '%1$s theme by %2$s.', 'debut' ), '<a href="https://github.com/kwight/debut/" target="_blank">Debut</a>', '<a href="http://kwight.ca/" rel="designer" target="_blank">kwight</a>' ); ?>
		</div><!-- .dev-credit -->
	</footer><!-- #colophon .site-footer -->

<?php wp_footer(); ?>

</body>
</html>