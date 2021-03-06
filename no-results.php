<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package carry
 * @since carry 1.0
 */
?>
<article id="post-0" class="hentry no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Nothing Found', 'carry' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_home() ): ?>
			<p>
				<?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'carry' ), admin_url( 'post-new.php' ) ); ?>
			</p>
		<?php elseif ( is_search() ): ?>
			<p>
				<?php _e( 'Sorry, but nothing matched your search terms: ', 'carry' ); ?>
				<em><?php echo the_search_query(); ?></em>
			</p>
			<p>
				<?php _e( 'Please try again with some different keywords.', 'carry' ); ?>
			</p>
			<?php get_search_form(); ?>
		<?php else: ?>
			<p>
				<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'carry' ); ?>
			</p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div><!-- .entry-content -->
</article><!-- #post-0 -->
