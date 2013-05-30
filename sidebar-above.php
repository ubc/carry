<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package carry
 * @since carry 1.0
 */
?>
<div id="above-content" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-above' ) ) : ?>
		<!-- Nothing -->
	<?php endif; // end sidebar widget area ?>
</div><!-- #above-content .widget-area -->
