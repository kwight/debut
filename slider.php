<?php

$slider = debut_get_featured_content();

if ( empty( $slider ) )
	return;
?>

<div class="flexslider">
	<ul class="slides">
	<?php foreach ( $slider as $post ) : setup_postdata( $post ); ?>
		
		<li class="slide">
			
			<?php the_post_thumbnail(); ?>
			<h2 class="post-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h2>
			<?php the_excerpt(); ?>

		</li><!-- .slide -->

	<?php endforeach; ?>
	</ul>

</div><!-- .features -->
