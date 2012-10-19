<?php
/**
 * Debut functions and definitions
 *
 * @package debut
 * @since 1.0
 */


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0
 */
if ( ! isset( $content_width ) ) $content_width = 646; // pixels, at 1000px wide


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since 1.0
 */
function debut_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'debut', get_template_directory() . '/languages' );
	$locale = get_locale();
    $locale_file = get_template_directory() . '/languages/$locale.php';
    if ( is_readable( $locale_file ) ) require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add support for background color and images
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'fff',
	) );

	/**
	 * Add image sizes
	 */
	add_image_size( 'debut-featured', 646, 363, true ); // 16:9

	/**
	 * Custom header support
	 */
	add_theme_support( 'custom-header', array(
		'default-text-color' 	 => 'f00',
		'wp-head-callback'       => 'debut_header_style',
		'admin-head-callback'    => 'debut_admin_header_style',
		//'admin-preview-callback' => 'debut_admin_header_image',
	) );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'debut' ),
	) );
}
add_action( 'after_setup_theme', 'debut_setup' );


/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since 1.0
 */
function debut_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'debut' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Header', 'debut' ),
		'id' => 'header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'debut_widgets_init' );


/**
 * Enqueue scripts and styles
 */
function debut_scripts() {
	global $post;

	wp_enqueue_style( 'debut-style', get_stylesheet_uri() );

	wp_enqueue_script( 'debut-scripts', get_template_directory_uri() . '/js/debut.js', array( 'jquery' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'debut-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'debut_scripts' );


/**
 * Add CSS in <head> to assign the header image as the #masthead background
 *
 * @since 1.05
 */
function debut_add_image_header_css() {
	if ( get_header_image() && display_header_text() ) { ?>
		<!-- Debut styling for custom header images (displayed as background to #masthead) -->
		<style>
			#masthead {
				background: url('<?php header_image(); ?>') <?php echo apply_filters( 'debut_header_background_css', 'no-repeat center top' ); ?>;
				min-height: 260px;
			}
			.debut-has-header-image .debut-lang-switcher {
				right: 1.02%;
			}
			.debut-has-header-image .debut-identity {
				margin-left: 1.02%;
				width: 64.966%;
			}
			.debut-has-header-image #tertiary {
				margin-right: 1.02%;
				width: 28.878%;
			}

			@media screen and ( max-width: 680px ) {
				.debut-has-header-image .debut-identity,
				.debut-has-header-image #tertiary {
					margin-left: 1.5465%;
					margin-right: 1.5465%;
					width: 96.907%;
				}
			}

			@media screen and ( max-width: 480px ) {
				#masthead {
					margin-bottom: 2.5em;
				}
			}

		</style>
	<?php }
}
add_action( 'wp_head', 'debut_add_image_header_css' );


/**
 * Custom header styles for the site title and description
 *
 * @since 2.0
 */
function debut_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	if ( $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
		#tertiary {
			display: none;
		}
	<?php
		// If the user has set a custom color for the text, use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}


/**
 * Custom header styles for the Admin
 *
 * @since 2.0
 */
function debut_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#headimg h2 {
		line-height: 1.6;
		margin: 0;
		padding: 0;
	}
	#headimg h1 {
		font-size: 30px;
	}
	#headimg h1 a {
		color: #515151;
		text-decoration: none;
	}
	#headimg h1 a:hover {
		color: #21759b;
	}
	#headimg h2 {
		color: #777;
		font: normal 13px/1.8 "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
		margin-bottom: 24px;
	}
	#headimg img {
		max-width: <?php echo get_theme_support( 'custom-header', 'max-width' ); ?>px;
	}
	</style>
<?php
}


/**
 * Returns inline HTML for the custom header image,
 * rather than as a background for #masthead
 * 
 * Displayed only if header text has been removed
 *
 * @since 2.0
 */
function debut_get_custom_header() {
	$html = '';
	$header_image = get_header_image();
	if ( ! display_header_text() && ! empty( $header_image ) ) {
		$html .= '<a href="' . esc_url( home_url( '/' ) ) . '">';
		$html .= '<img class="debut-header-image" src="' . esc_url( $header_image ) . '" /></a>';
	}
	return apply_filters( 'debut_custom_header_inline_html', $html );
}

/**
 * Add html5.js script to <head> conditionally for IE8 and under
 *
 * @since 1.0.4
 */
function debut_ie_html5_js() { ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
<?php }
add_action('wp_head', 'debut_ie_html5_js');


/**
 * Add a menu item for the theme customizer
 *
 * @since 2.0
 */
function debut_add_customizer_menu_item() {
    add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}
add_action ('admin_menu', 'debut_add_customizer_menu_item');


/**
 * Theme customizer with real-time update
 * Very helpful: http://ottopress.com/2012/theme-customizer-part-deux-getting-rid-of-options-pages/
 *
 * @since 2.0
 */
function debut_theme_customizer( $wp_customize ) {
    $wp_customize->add_setting( 'debut_link_color', array(
        'default'        => '#ff0000',
        'transport' => 'postMessage'
    ) );
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'debut_link_color', array(
        'label'   => 'Link and Highlight Color',
        'section' => 'colors',
        'settings'   => 'debut_link_color',
    ) ) );

    $wp_customize->get_setting('blogname')->transport='postMessage';
	$wp_customize->get_setting('blogdescription')->transport='postMessage';
 

}
add_action('customize_register', 'debut_theme_customizer');


/**
 * Add CSS in <head> for styles handled by the theme customizer
 *
 * @since 1.05
 */
function debut_add_customizer_css() { ?>
	<!-- Debut customizer CSS -->
	<style>
		body {
			border-color: <?php echo get_theme_mod( 'debut_link_color' ); ?>;
		}
		a, a:visited {
			color: <?php echo get_theme_mod( 'debut_link_color' ); ?>;
		}
		.main-navigation a:hover,
		.main-navigation a:focus,
		.main-navigation a:active,
		.main-navigation .current-menu-item > a,
		.debut-lang:hover {
			background-color: <?php echo get_theme_mod( 'debut_link_color' ); ?>;
		}
	</style>
<?php }
add_action( 'wp_head', 'debut_add_customizer_css' );


/**
 * Display navigation to next/previous pages when applicable
 *
 * @since 1.0
 */
if ( ! function_exists( 'debut_content_nav' ) ):
function debut_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'debut' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'debut' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'debut' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'debut' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'debut' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif;


/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0
 */
if ( ! function_exists( 'debut_posted_on' ) ) :
function debut_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'debut' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( debut_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'debut' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;


/**
 * Returns true if a blog has more than one category
 *
 * @since 1.0
 */
if ( ! function_exists( 'debut_categorized_blog' ) ) :
function debut_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so debut_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so debut_categorized_blog should return false
		return false;
	}
}
endif;


/**
 * Flush out the transients used in debut_categorized_blog
 *
 * @since 1.0
 */
function debut_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'debut_category_transient_flusher' );
add_action( 'save_post', 'debut_category_transient_flusher' );


/**
 * Generate comment HTML
 * Based on the P2 theme by Automattic
 * http://wordpress.org/extend/themes/p2
 *
 * @since 1.0
 */
if ( ! function_exists( 'debut_comment' ) ) :
function debut_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	if ( !is_single() && get_comment_type() != 'comment' )
		return;
	$can_edit_post  = current_user_can( 'edit_post', $comment->comment_post_ID );
	$content_class  = 'comment-content';
	if ( $can_edit_post )
		$content_class .= ' comment-edit';
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">

		<?php echo get_avatar( $comment, 60 ); ?>
		<div class="comment-meta">
			<div class="perma-reply-edit">
				<a href="<?php echo esc_url( get_comment_link() ); ?>"><?php _e( 'Permalink', 'debut' ); ?></a>
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '&nbsp;&sdot;&nbsp;' ) ) );
				if ( $can_edit_post ) { edit_comment_link( __( 'Edit', 'debut' ), '&nbsp;&sdot;&nbsp;' ); } ?>
			</div><!-- .perma-reply-edit -->
			<h4><?php echo get_comment_author_link(); ?></h4>
			<?php echo debut_comment_time(); ?><br />
		</div><!-- .comment-meta -->
		<div id="comment-content-<?php comment_ID(); ?>" class="<?php echo esc_attr( $content_class ); ?>">
			<?php if ( $comment->comment_approved == '0' ): ?>
					<p class="comment-awaiting"><?php esc_html_e( 'Your comment is awaiting moderation.', 'debut' ); ?></p>
			<?php endif; ?>
			<?php echo apply_filters( 'comment_text', $comment->comment_content ); ?>	
		</div>
		</article>
	</li>	
<?php }
endif;


/**
 * Change HTML for comment form fields
 *
 * @since 1.0
 */
function debut_comment_form_args( $args ) {
	$args[ 'fields' ] = array(
		'author' => '<div class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'debut' ) . '</label><input type="text" class="field" name="author" id="author" aria-required="true" placeholder="' . esc_attr__( 'Name', 'debut' ) . '" /></div><!-- .comment-form-author -->',
		'email' => '<div class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'debut' ) . '</label><input type="text" class="field" name="email" id="email" aria-required="true" placeholder="' . esc_attr__( 'Email', 'debut' ) . '" /></div><!-- .comment-form-email -->',
		'url' => '<div class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'debut' ) . '</label><input type="text" class="field" name="url" id="url" placeholder="' . esc_attr__( 'Website', 'debut' ) . '" /></div><!-- .comment-form-url -->'
	);
	$args[ 'comment_field' ] = '<div class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'debut' ) . '</label><textarea id="comment" name="comment" rows="8" aria-required="true" placeholder="' . esc_attr__( 'Comment', 'debut' ) . '"></textarea></div><!-- .comment-form-comment -->';
	$args[ 'comment_notes_before' ] = '<p class="comment-notes">' . esc_html__( 'Your email will not be published. Name and Email fields are required.', 'debut' ) . '</p>';
	return $args;
}
add_filter( 'comment_form_defaults', 'debut_comment_form_args' );


/**
 * Remove ridiculous inline width style from captions
 * Source: http://wordpress.stackexchange.com/questions/4281/how-to-customize-the-default-html-for-wordpress-attachments
 *
 * @since 1.0
 */
function debut_remove_caption_width( $current_html, $attr, $content ) {
    extract(shortcode_atts(array(
        'id'    => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => ''
    ), $attr));
    if ( 1 > (int) $width || empty($caption) )
        return $content;

    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (int) $width . 'px">'
. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
add_filter( 'img_caption_shortcode', 'debut_remove_caption_width', 10, 3 );


/**
 * Add CSS class to menus for submenu indicator
 *
 * @since 1.0
 */
class Debut_Page_Navigation_Walker extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    	$id_field = $this->db_fields['id'];
        if ( !empty( $children_elements[ $element->$id_field ] ) ) { 
            $element->classes[] = 'menu-item-parent';
        }
        Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}


/**
 * Filter wp_nav_menu() arguments to specify the above walker
 *
 * @since 1.0
 */
function debut_nav_menu_args( $args ) {
	/**
	 * Set our new walker only if a menu is assigned,
	 * and a child theme hasn't modified it to one level
	 * (naughty child theme...)
	 */
	if ( 1 !== $args[ 'depth' ] && has_nav_menu( 'primary' ) ) {
		$args[ 'walker' ] = new Debut_Page_Navigation_Walker;
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'debut_nav_menu_args' );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since 1.0
 */
function debut_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'debut_page_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 */
function debut_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// Adds the class "debut-has-header-image" when a header image is present
	if ( get_header_image() ) {
		$classes[] = 'debut-has-header-image';
	}
	return $classes;
}
add_filter( 'body_class', 'debut_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since 1.0
 */
function debut_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'debut_enhanced_image_navigation', 10, 2 );


/**
 * WPML language switcher
 * Called only if WPML plugin is active: http://wpml.org
 *
 * @since 1.05
 */
function debut_lang_switcher() {
	define( 'ICL_DONT_LOAD_NAVIGATION_CSS', true );
	define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
	define( 'ICL_DONT_LOAD_LANGUAGES_JS', true );
	$lang = icl_get_languages( 'skip_missing=N' );
	if ( count( $lang ) > 1 ) {
		$html = '<div class="debut-lang-switcher">';
		foreach( $lang as $value ) {
			if ( 0 == $value[ 'active' ] ) {
				$html .= '<a class="debut-lang" href="' . $value[ 'url' ] . '">' . $value[ 'language_code' ]  . '</a>';
			}
		}
		$html .= '</div><!-- end .debut-lang-switcher -->';
		return apply_filters( 'debut_lang_switcher_html', $html, $lang );
	}
}


/**
 * Output the date with correct formatting per language
 *
 * @since 1.05
 */
function debut_date() {
    if ( class_exists( 'Sitepress', false ) && 'fr' == ICL_LANGUAGE_CODE ) {
        $date = get_the_time( 'j F Y' );
    } else {
        $date = get_the_time( 'F j, Y' );
    }
    return $date;
}


/**
 * Output the comment timestamp with correct formatting per language
 *
 * @since 1.05
 */
function debut_comment_time() {
	if ( class_exists( 'Sitepress', false ) && 'fr' == ICL_LANGUAGE_CODE ) {
        $timestamp = comment_time( '\l\e j F Y \à H\hi' );
    } else {
        $timestamp = comment_time( 'F j, Y \a\t g:ia' );
    }
    return $timestamp;
}
