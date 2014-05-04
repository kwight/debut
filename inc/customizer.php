<?php
/**
 * Theme Customizer settings.
 *
 * @package Debut 
 * @since 1.7 
 */

/**
 * Theme customizer settings with real-time update
 * Very helpful: http://ottopress.com/2012/theme-customizer-part-deux-getting-rid-of-options-pages/
 *
 * @since 1.5
 */
function debut_theme_customizer( $wp_customize ) {
    $wp_customize->add_setting( 'debut_link_color', array(
        'default'   => '#ff0000',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'debut_link_color', array(
        'label'	   => 'Link and Highlight Color',
        'section'  => 'colors',
        'settings' => 'debut_link_color',
    ) ) );

    // Logo upload
    $wp_customize->add_section( 'debut_logo_section' , array(
	    'title'       => __( 'Logo', 'debut' ),
	    'priority'    => 30,
	    'description' => 'Upload a logo to replace the default site name and description in the header',
	) );
	$wp_customize->add_setting( 'debut_logo', array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'debut_logo', array(
		'label'        => __( 'Logo', 'debut' ),
		'section'    => 'debut_logo_section',
		'settings'   => 'debut_logo',
	) ) );

    // Choose excerpt or full content on blog
    $wp_customize->add_section( 'debut_layout_section' , array(
	    'title'       => __( 'Layout', 'debut' ),
	    'priority'    => 30,
	    'description' => 'Change how Debut displays posts',
	) );
	$wp_customize->add_setting( 'debut_post_content', array(
		'default'	=> 'option1',
		'sanitize_callback' => 'debut_sanitize_index_content',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'debut_post_content', array(
		'label'		=> __( 'Post content', 'debut' ),
		'section'	=> 'debut_layout_section',
		'settings'	=> 'debut_post_content',
		'type'		=> 'radio',
		'choices'	=> array(
			'option1'	=> 'Excerpts',
			'option2'	=> 'Full content',
			),
	) ) );

	// Set site name and description to be previewed in real-time
	$wp_customize->get_setting('blogname')->transport='postMessage';
	$wp_customize->get_setting('blogdescription')->transport='postMessage';

	// Enqueue scripts for real-time preview
	wp_enqueue_script( 'debut-customizer', get_template_directory_uri() . '/js/debut-customizer.js', array( 'jquery' ) );
 

}
add_action('customize_register', 'debut_theme_customizer');


/**
 * Sanitizes a hex color. Identical to core's sanitize_hex_color(), which is not available on the wp_head hook.
 *
 * Returns either '', a 3 or 6 digit hex color (with #), or null.
 * For sanitizing values without a #, see sanitize_hex_color_no_hash().
 *
 * @since 1.7
 */
function debut_sanitize_hex_color( $color ) {
	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return null;
}


/**
 * Sanitizes our post content value (either excerpts or full post content).
 *
 * @since 1.7
 */
function debut_sanitize_index_content( $content ) {
	if ( 'option2' == $content ) {
		return 'option2';
	} else {
		return 'option1';
	}
}


/**
 * Add CSS in <head> for styles handled by the theme customizer
 *
 * @since 1.5
 */
function debut_add_customizer_css() {
	$color = debut_sanitize_hex_color( get_theme_mod( 'debut_link_color' ) );
	?>
	<!-- Debut customizer CSS -->
	<style>
		body {
			border-color: <?php echo $color; ?>;
		}
		a, a:visited {
			color: <?php echo $color; ?>;
		}
		.main-navigation a:hover,
		.main-navigation .sub-menu a:hover,
		.main-navigation .children a:hover,
		.main-navigation a:focus,
		.main-navigation a:active,
		.main-navigation .current-menu-item > a,
		.main-navigation .current_page_item > a,
		.debut-lang:hover {
			background-color: <?php echo $color; ?>;
		}
	</style>
<?php }
add_action( 'wp_head', 'debut_add_customizer_css' );