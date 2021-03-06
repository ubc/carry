<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package carry
 * @since carry 1.0
 */

if ( ! function_exists( 'carry_content_nav' ) ):
	/**
	 * Display navigation to next/previous pages when applicable
	 *
	 * @since carry 1.0
	 */
	function carry_content_nav( $nav_id ) {
		global $wp_query;
		
		if ( is_single() ):
			$nav_class = 'site-navigation post-navigation';
		else:
			$nav_class = 'site-navigation paging-navigation';
		endif;
		
		?>
		<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
			<h1 class="assistive-text"><?php _e( 'Post navigation', 'carry' ); ?></h1>
			
			<?php
				if ( is_single() ): // navigation links for single posts
					previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav"><i class="icon-chevron-left"></i>' . __( 'Previous post link', 'carry' ) . '</span> %title' );
					next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . __( 'Next post link', 'carry' ) . '<i class="icon-chevron-right"></i></span>' );
				elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ): // navigation links for home, archive, and search pages
					if ( get_next_posts_link() ):
						?>
						<div class="nav-previous"><?php next_posts_link( '<i class="icon-chevron-left"></i>'.__( 'Older posts', 'carry' ) ); ?></div>
						<?php
					endif;
					
					if ( get_previous_posts_link() ):
						?>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'carry' ). '<i class="icon-chevron-right"></i>' ); ?></div>
						<?php
					endif;
				endif;
			?>
		</nav><!-- #<?php echo $nav_id; ?> -->
		<?php
	}
endif; // carry_content_nav

if ( ! function_exists( 'carry_comment' ) ):
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since carry 1.0
	 */
	function carry_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		
		switch ( $comment->comment_type ):
			case 'pingback':
			case 'trackback':
				?>
				<li class="post pingback">
					<p><?php _e( 'Pingback:', 'carry' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'carry' ), ' ' ); ?></p>
				<?php
				break;
			default :
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment-shell">
						<footer>
							<div class="comment-author vcard">
								<?php echo get_avatar( $comment, 30 ); ?>
								<?php printf( __( '%s', 'carry' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
							</div><!-- .comment-author .vcard -->
							<?php if ( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'carry' ); ?></em>
								<br />
							<?php endif; ?>
							
							<div class="comment-meta commentmetadata">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
									<i class="icon-time"></i>
									<time pubdate datetime="<?php comment_time( 'c' ); ?>">
										<?php printf( __( '%1$s', 'carry' ), get_comment_date('M j - g:ia') ); ?>
									</time>
								</a>
								<?php edit_comment_link( __( '(Edit)', 'carry' ), ' ' );
								?>
							</div><!-- .comment-meta .commentmetadata -->
						</footer>
						<div class="comment-content"><?php comment_text(); ?></div>
						<div class="reply">
							<?php
								comment_reply_link( array_merge( $args, array(
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
								) ) );
							?>
						</div><!-- .reply -->
					</article><!-- #comment-## -->
				<?php
				break;
		endswitch;
	}
endif; // ends check for carry_comment()

if ( ! function_exists( 'carry_posted_on' ) ):
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since carry 1.0
	 */
	function carry_posted_on() {
		printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'carry' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'carry' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since carry 1.0
 */
function carry_categorized_blog() {
	$cat_count = get_transient( 'all_the_cool_cats' );
	if ( false === $cat_count ):
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );
		
		// Count the number of categories that are attached to the posts
		$cat_count = count( $all_the_cool_cats );
		set_transient( 'all_the_cool_cats', $cat_count );
	endif;

	if ( '1' != $cat_count ):
		// This blog has more than 1 category so carry_categorized_blog should return true
		return true;
	else:
		// This blog has only 1 category so carry_categorized_blog should return false
		return false;
	endif;
}

if ( ! function_exists( 'carry_post_meta' ) ):
	/**
	 * carry_post_meta function.
	 * 
	 * @access public
	 * @return void
	 */
	function carry_post_meta() {
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'carry' ) );
		
		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', ', ' );
		
		if ( ! carry_categorized_blog() ):
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ):
				$meta_text = __( '<i class="icon-tags"></i> <span class="meta-shell">%2$s</span> Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'carry' );
			else:
				$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'carry' );
			endif;
		else:
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ):
				$meta_text = __( '<i class="icon-folder-open"></i> <span class="meta-shell">%1$s</span>  <i class="icon-tags"></i> <span class="meta-shell">%2$s</span>  <i class="icon-globe"></i> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'carry' );
			else:
				$meta_text = __( '<i class="icon-folder-open"></i> <span class="meta-shell">%1$s</span> <i class="icon-globe"></i> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'carry' );
			endif;
		endif; // end check for categories on this blog
		
		printf( $meta_text, $category_list, $tag_list, get_permalink(), the_title_attribute( 'echo=0' ) );
	}
endif;

if ( ! function_exists( 'carry_single_header' ) ):
	/**
	 * carry_single_header function.
	 * 
	 * @access public
	 * @return void
	 */
	function carry_single_header() {
		global $post;
		$thumb = '';
		$has_thumbnail = '';
		
		if ( has_post_thumbnail() ):
			$has_thumbnail = 'has-feature-image';
			$thumb = get_the_post_thumbnail( $post->ID, 'featured-single-image' );
		endif;
		?>
		<header class="entry-header <?php echo $has_thumbnail; ?>">
			<?php echo $thumb; ?>
			<div class="enter-header-thumb">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php if ( ! is_page() ): ?>
					<div class="entry-meta">
						<?php carry_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</div>
		</header><!-- .entry-header -->
		<?php 
	}
endif;

/**
 * Flush out the transients used in carry_categorized_blog
 *
 * @since carry 1.0
 */
function carry_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}

add_action( 'edit_category', 'carry_category_transient_flusher' );
add_action( 'save_post', 'carry_category_transient_flusher' );