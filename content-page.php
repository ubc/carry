<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package carry
 * @since carry 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php carry_single_header(); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'carry' ).'</span>', 'after' => '</div>', 'pagelink' => '<span>%</span>' ) ); ?>
		<?php /* edit_post_link( __( 'Edit', 'carry' ), '<span class="edit-link">', '</span>' ); */ ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
