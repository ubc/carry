<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package carry
 * @since carry 1.0
 */
?>
<div id="tertiary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>
		<aside id="search" class="widget widget_search">
			<?php get_search_form(); ?>
		</aside>
		
		<aside id="archives" class="widget">
			<h1 class="widget-title"><?php _e( 'Archives', 'carry' ); ?></h1>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>
		
		<aside id="meta" class="widget">
			<h1 class="widget-title"><?php _e( 'Meta', 'carry' ); ?></h1>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>
	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->