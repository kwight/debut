<?php
/**
 * _s functions and definitions
 *
 * @package _s
 * @since _s 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since _s 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 620; /* pixels */

if ( ! function_exists( '_s_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since _s 1.0
 */
function _s_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', '_s' ),
	) );
}
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since _s 1.0
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', '_s' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Header', '_s' ),
		'id' => 'header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function _s_scripts() {
	global $post;

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Display navigation to next/previous pages when applicable
 *
 * @since _s 1.0
 */
if ( ! function_exists( '_s_content_nav' ) ):
function _s_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', '_s' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', '_s' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', '_s' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', '_s' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', '_s' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // _s_content_nav

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since _s 1.0
 */
if ( ! function_exists( '_s_posted_on' ) ) :
function _s_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', '_s' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', '_s' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since _s 1.0
 */
function _s_categorized_blog() {
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
		// This blog has more than 1 category so _s_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so _s_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in _s_categorized_blog
 *
 * @since _s 1.0
 */
function _s_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', '_s_category_transient_flusher' );
add_action( 'save_post', '_s_category_transient_flusher' );

/**
 * Generate comment HTML
 * Based on the P2 theme by Automattic
 * http://wordpress.org/extend/themes/p2
 *
 * @since 1.0
 */
if ( ! function_exists( 'debut_comment' ) ) {

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
					<a href="<?php echo esc_url( get_comment_link() ); ?>"><?php _e( 'Permalink', 'straightup' ); ?></a>
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '&nbsp;&sdot;&nbsp;' ) ) );
					if ( $can_edit_post ) { edit_comment_link( __( 'Edit', 'straightup' ), '&nbsp;&sdot;&nbsp;' ); } ?>
				</div><!-- .perma-reply-edit -->
				<h4><?php echo get_comment_author_link(); ?></h4>
				<?php comment_time( 'F j, Y \a\t g:ia' ); ?><br />
			</div><!-- .comment-meta -->
			<div id="comment-content-<?php comment_ID(); ?>" class="<?php echo esc_attr( $content_class ); ?>">
				<?php if ( $comment->comment_approved == '0' ): ?>
						<p class="comment-awaiting"><?php esc_html_e( 'Your comment is awaiting moderation.', 'straightup' ); ?></p>
				<?php endif; ?>
				<?php echo apply_filters( 'comment_text', $comment->comment_content ); ?>	
			</div>
			</article>
		</li>
		
	<?php }

}

/**
 * Change HTML for comment form fields
 *
 * @since 1.0
 */
if ( ! function_exists( 'straightup_comment_form_args' ) ) {

	function straightup_comment_form_args( $args ) {
	$args[ 'fields' ] = array(
							'author' => '<div class="comment-form-author"><label for="author" class="assistive-text">' . esc_html__( 'Name', 'straightup' ) . '</label><input type="text" class="field" name="author" id="author" aria-required="true" placeholder="' . esc_attr__( 'Name', 'straightup' ) . '" /></div><!-- .comment-form-author -->',
							'email' => '<div class="comment-form-email"><label for="email" class="assistive-text">' . esc_html__( 'Email', 'straightup' ) . '</label><input type="text" class="field" name="email" id="email" aria-required="true" placeholder="' . esc_attr__( 'Email', 'straightup' ) . '" /></div><!-- .comment-form-email -->',
							'url' => '<div class="comment-form-url"><label for="url" class="assistive-text">' . esc_html__( 'Website', 'straightup' ) . '</label><input type="text" class="field" name="url" id="url" placeholder="' . esc_attr__( 'Website', 'straightup' ) . '" /></div><!-- .comment-form-url -->'
						);
	$args[ 'comment_field' ] = '<div class="comment-form-comment"><label for="comment" class="assistive-text">' . esc_html__( 'Comment', 'straightup' ) . '</label><textarea id="comment" name="comment" rows="8" aria-required="true" placeholder="' . esc_attr__( 'Comment', 'straightup' ) . '"></textarea></div><!-- .comment-form-comment -->';
	$args[ 'comment_notes_before' ] = '<p class="comment-notes">' . esc_html__( 'Your email will not be published. Name and Email fields are required.', 'straightup' ) . '</p>';
	return $args;
	}

}
add_filter( 'comment_form_defaults', 'straightup_comment_form_args' );

/**
 * Add CSS class to menus for submenu indicator
 *
 * Side note: there's gotta be a better way to do all this sub-menu stuff. Or maybe another way that I
 * understand (I really should learn this PHP class stuff).
 *
 * @since 1.0
 */
class StraightUp_Page_Navigation_Walker extends Walker_Nav_Menu {
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
if ( ! function_exists( 'straightup_nav_menu_args' ) ) {

	function straightup_nav_menu_args( $args ) {
		/**
		 * Set our new walker only if a child theme hasn't
		 * modified it to one level (naughty child theme...)
		 */
		if ( 1 !== $args[ 'depth' ] ) {
			$args[ 'walker' ] = new StraightUp_Page_Navigation_Walker;
		}
		return $args;
	}

}
add_filter( 'wp_nav_menu_args', 'straightup_nav_menu_args' );