<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package carry
 * @since carry 1.0
 */
?>
<div id="below-content" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-below' ) ) : ?>
		<!-- Nothing -->
	<?php endif; // end sidebar widget area ?>
</div><!-- #below-content .widget-area -->
