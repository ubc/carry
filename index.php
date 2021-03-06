<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
			if ( have_posts() ):
				while ( have_posts() ):
					the_post();
					/**
					 * Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					$carry_content_template = apply_filters( 'carry_content_template', 'content', $post->post_type );
					get_template_part( $carry_content_template, get_post_format() );
				endwhile;
				
				carry_content_nav( 'nav-below' );
			elseif ( current_user_can( 'edit_posts' ) ) :
				get_template_part( 'no-results', 'index' );
			endif;
		?>
		<?php get_sidebar( 'below' ); ?>
	</div><!-- #content -->

	<?php get_sidebar( 'right' ); ?>
</div><!-- #primary .site-content -->
<?php get_footer(); ?>