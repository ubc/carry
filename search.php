<?php
/**
 * The template for displaying Search Results pages.
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
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'carry' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>
			<?php carry_content_nav( 'nav-above' ); ?>
			
			<?php
				while ( have_posts() ):
					the_post();
					$carry_content_template = apply_filters( 'carry_content_template', 'content', $post->post_type );
					get_template_part( $carry_content_template, 'search' );
				endwhile;
			?>
			
			<?php carry_content_nav( 'nav-below' ); ?>
		<?php else : ?>
			<?php get_template_part( 'no-results', 'search' ); ?>
		<?php endif; ?>
		<?php get_sidebar( 'below' ); ?>
	</div><!-- #content -->
	<?php get_sidebar( 'right' ); ?>
</div><!-- #primary .site-content -->
<?php get_footer(); ?>