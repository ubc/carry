<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package carry
 * @since carry 1.0
 */
?>
<div id="full-content" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-full' ) ) : ?>
		<!-- Nothing -->
	<?php endif; // end sidebar widget area ?>
</div> <!-- #full-content .widget-area -->
