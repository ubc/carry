<?php
/**
 * carry functions and definitions
 *
 * @package carry
 * @since carry 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since carry 1.0
 */
if ( ! isset( $content_width ) ):
	$content_width = 640; /* pixels */
endif;

if ( ! function_exists( 'carry_setup' ) ):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * @since carry 1.0
	 */
	function carry_setup() {
		// Custom template tags for this theme.
		require( get_template_directory().'/inc/template-tags.php' );
		
		// Custom functions that act independently of the theme templates
		require( get_template_directory().'/inc/tweaks.php' );
		
		// Custom Theme Options
		// require( get_template_directory() . '/inc/theme-options/theme-options.php' );
			
		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on carry, use a find and replace
		 * to change 'carry' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'carry', get_template_directory() . '/languages' );
		
		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );
		
		/**
		 * Enable support for Post Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		
		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'carry' ),
		) );
		
		/**
		 * Add support for the Aside Post Formats
		 */
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'chat', 'quote', 'link', 'image' ) );
	}
endif; // carry_setup
add_action( 'after_setup_theme', 'carry_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since carry 1.0
 */
function carry_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Right Side', 'carry' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Left Side', 'carry' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'carry_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function carry_scripts() {
	global $post;
	
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_script( 'small-menu', get_template_directory_uri().'/js/small-menu.js', array( 'jquery' ), '20120206', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ):
		wp_enqueue_script( 'comment-reply' );
	endif;

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ):
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri().'/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	endif;
}
add_action( 'wp_enqueue_scripts', 'carry_scripts' );

/**
 * This function filters the post content when viewing a post with the "chat" post format.  It formats the 
 * content with structured HTML markup to make it easy for theme developers to style chat posts.  The 
 * advantage of this solution is that it allows for more than two speakers (like most solutions).  You can 
 * have 100s of speakers in your chat post, each with their own, unique classes for styling.
 *
 * @author David Chandra
 * @link http://www.turtlepod.org
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @copyright Copyright (c) 2012
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link http://justintadlock.com/archives/2012/08/21/post-formats-chat
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param string $content The content of the post.
 * @return string $chat_output The formatted content of the post.
 */
function carry_format_chat_content( $content ) {
	global $_post_format_chat_ids;
	
	// If this is not a 'chat' post, return the content.
	if ( ! has_post_format( 'chat' ) ):
		return $content;
	endif;
	
	ob_start();
	
	// Set the global variable of speaker IDs to a new, empty array for this chat.
	$_post_format_chat_ids = array();

	// Allow the separator (separator for speaker/text) to be filtered.
	$separator = apply_filters( 'carry_post_format_chat_separator', ':' );

	// Open the chat transcript div and give it a unique ID based on the post ID.
	?>
	<div id="chat-transcript-<?php echo esc_attr( get_the_ID() ); ?>" class="chat-transcript">
	<?php

	// Split the content to get individual chat rows.
	$chat_rows = preg_split( "/(\r?\n)+|(<br\s*\/?>\s*)+/", $content );

	// Loop through each row and format the output.
	foreach ( $chat_rows as $chat_row ):
		// If a speaker is found, create a new chat row with speaker and text.
		if ( strpos( $chat_row, $separator ) ):
			// Split the chat row into author/text.
			$chat_row_split = explode( $separator, trim( $chat_row ), 2 );
			
			// Get the chat author and strip tags.
			$chat_author = strip_tags( trim( $chat_row_split[0] ) );
			
			// Get the chat text.
			$chat_text = trim( $chat_row_split[1] );
			
			// Get the chat row ID (based on chat author) to give a specific class to each row for styling.
			$speaker_id = carry_format_chat_row_id( $chat_author );
			?>
			<div class="chat-row <?php echo sanitize_html_class( "chat-speaker-{$speaker_id}" ); ?>">
				<div class="chat-author <?php echo sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ); ?> vcard">
					<cite class="fn">
						<?php echo apply_filters( 'my_post_format_chat_author', $chat_author, $speaker_id ); ?>
					</cite>
					<?php echo $separator; ?>
				</div>
				<div class="chat-text">
					<div class="chat-text-inner">
						<?php echo str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'my_post_format_chat_text', $chat_text, $chat_author, $speaker_id ) ); ?>
					</div>
				</div>
			</div><!-- .chat-row -->
			<?php
		else:
			/**
			* If no author is found, assume this is a separate paragraph of text that belongs to the
			* previous speaker and label it as such, but let's still create a new row.
			*/
			
			// Make sure we have text.
			if ( ! empty( $chat_row ) ):
				?>
				<div class="chat-row <?php echo sanitize_html_class( "chat-speaker-{$speaker_id}" ); ?>">
					<div class="chat-text">
						<?php echo str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'my_post_format_chat_text', $chat_row, $chat_author, $speaker_id ) ); ?>
					</div>
				</div><!-- .chat-row -->
				<?php
			endif;
		endif;
	endforeach;

	// Close the chat transcript div.
	?>
	</div><!-- .chat-transcript -->
	<?php

	// Return the chat content and apply filters for developers.
	return apply_filters( 'carry_post_format_chat_content', ob_get_clean() );
}

/* Filter the content of chat posts. */
add_filter( 'the_content', 'carry_format_chat_content' );

/* Auto-add paragraphs to the chat text. */
add_filter( 'carry_post_format_chat_text', 'wpautop' );

/**
 * This function returns an ID based on the provided chat author name.  It keeps these IDs in a global 
 * array and makes sure we have a unique set of IDs.  The purpose of this function is to provide an "ID"
 * that will be used in an HTML class for individual chat rows so they can be styled.  So, speaker "John" 
 * will always have the same class each time he speaks.  And, speaker "Mary" will have a different class 
 * from "John" but will have the same class each time she speaks.
 *
 * @author David Chandra
 * @link http://www.turtlepod.org
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @copyright Copyright (c) 2012
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @link http://justintadlock.com/archives/2012/08/21/post-formats-chat
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param string $chat_author Author of the current chat row.
 * @return int The ID for the chat row based on the author.
 */
function carry_format_chat_row_id( $chat_author ) {
	global $_post_format_chat_ids;
	
	// Let's sanitize the chat author to avoid craziness and differences like "John" and "john".
	$chat_author = strtolower( strip_tags( $chat_author ) );
	
	// Add the chat author to the array.
	$_post_format_chat_ids[] = $chat_author;
	
	// Make sure the array only holds unique values.
	$_post_format_chat_ids = array_unique( $_post_format_chat_ids );
	
	// Return the array key for the chat author and add "1" to avoid an ID of "0".
	return absint( array_search( $chat_author, $_post_format_chat_ids ) ) + 1;
}

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory().'/inc/custom-header.php' );
