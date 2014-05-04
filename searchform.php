<?php
/**
 * The template for displaying search forms
 *
 * @package Debut
 * @since 1.0
 */
?>
	<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="assistive-text"><?php esc_html_e( 'Search', 'debut' ); ?></label>
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'debut' ); ?>" />
		<input type="submit" class="submit searchsubmit" name="submit" value="<?php esc_attr_e( 'Search', 'debut' ); ?>" />
	</form>
