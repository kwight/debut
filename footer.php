<?php
/**
 * The template for displaying the footer.
 *
 * (Feel free to remove the WordPress link if you choose.)
 *
 * @package debut 
 * @since 1.0 
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php printf( __( 'Powered by %1$s. %2$s theme by %3$s.', 'debut' ),'<a href="http://wordpress.org/" target="_blank">WordPress</a>', 'Debut', '<a href="http://kwight.ca/" target="_blank">kwight</a>' ); ?>
	</footer><!-- #colophon .site-footer -->

<?php wp_footer(); ?>

</body>
</html>