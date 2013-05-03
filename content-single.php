<?php
/**
 * @package carry
 * @since carry 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php carry_single_header(); ?>

	<div class="entry-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before'   => '<div class="page-links"><span class="page-links-title">'.__( 'Pages:', 'carry' ).'</span>',
				'after'    => '</div>',
				'pagelink' => '<span>%</span>'
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php carry_post_meta(); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
