<?php
/**
 * The Template for displaying all single posts.
 *
 * @package carry
 * @since carry 1.0
 */
?>
<?php get_header(); ?>
<?php get_sidebar( 'left' ); ?>
<?php get_sidebar( 'full' ); ?>

<div id="primary" class="site-content">
	<div id="content" role="main">
		<?php get_sidebar( 'above' ); ?>
		<?php
			while ( have_posts() ):
				the_post(); 
				$carry_content_template = apply_filters( 'carry_content_template', 'content', $post->post_type );
				get_template_part( $carry_content_template, 'single' ); 
				
				carry_content_nav( 'nav-below' ); 
				
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ):
					comments_template( '', true );
				endif;
			endwhile; // end of the loop.
		?>
		<?php get_sidebar( 'below' ); ?>
	</div><!-- #content -->
	<?php get_sidebar( 'right' ); ?>
</div><!-- #primary .site-content -->

<?php get_footer(); ?>