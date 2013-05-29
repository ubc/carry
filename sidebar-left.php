<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package carry
 * @since carry 1.0
 */
?>

<a href="#" id="mobile-view">Menu</a>

<div id="secondary" class="widget-area" role="navigation">
	
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
		<aside class="widget widget_nav_menu">
			<div class="access">
			  <ul class="menu"><?php wp_nav_menu(); ?></ul>
			</div>
		</aside>
	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->