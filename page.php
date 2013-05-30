<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
				get_template_part( $carry_content_template, 'page' );
				comments_template( '', true );
			endwhile; 
		?>
		<?php get_sidebar( 'below' ); ?>
	</div><!-- #content -->
	<?php get_sidebar( 'right' ); ?>
</div><!-- #primary .site-content -->

<?php get_footer(); ?>