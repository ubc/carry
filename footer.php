<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package carry
 * @since carry 1.0
 */
?>		</div> <!-- .main-column-->
	</div><!-- #main .main-column-wrap -->
</div><!-- .shell .hfeed .site -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class=" shell">
		<div class="site-info">
			<?php do_action( 'carry_credits' ); ?>
			Proudly powered by <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'carry' ); ?>" rel="generator"><?php printf( 'WordPress', 'carry' ); ?></a>
			<span class="sep"> and </span>
			<?php printf( __( '%1$s by %2$s.', 'carry' ), '<a href="https://github.com/ubc/carry" rel="theme">Carry</a>', '<a href="http://ctlt.ubc.ca/" rel="designer">CTLT</a>' ); ?>
		</div>
	</div><!-- .site-info -->
</footer><!-- .site-footer .site-footer -->
<?php wp_footer(); ?>

</body>
</html>