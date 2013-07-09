<?php
/**
 * @package Debut
 * @since 1.0
 */
?>

<?php $class = ( has_post_thumbnail() ) ? 'debut-has-thumb' : NULL; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<header class="entry-header">
		<?php
		if ( has_post_thumbnail() ) { ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
		<?php }
		?>
		
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'debut' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php debut_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( 'option2' == get_theme_mod( 'debut_post_content' ) ) :
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'debut' ) );
		else :
			the_excerpt();
		endif;
		?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'debut' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'debut' ) );
				if ( $categories_list && debut_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'debut' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'debut' ) );
				if ( $tags_list ) :
			?>
			<span class="sep">&nbsp;&nbsp;&bull;&nbsp;&nbsp;</span>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'debut' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="sep">&nbsp;&nbsp;&bull;&nbsp;&nbsp;</span>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'debut' ), __( '1 Comment', 'debut' ), __( '% Comments', 'debut' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'debut' ), '<span class="sep">&nbsp;&nbsp;&bull;&nbsp;&nbsp;</span><span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
