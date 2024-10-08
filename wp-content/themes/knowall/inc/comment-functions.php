<?php
/**
 * Functions for handling how comments are displayed and used on the site. This allows more precise control over their display.
 */


if ( ! function_exists( 'ht_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own st_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 */
	function ht_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				// Display trackbacks differently than normal comments.?>

		<li class="post pingback">
			<p>
				<?php esc_html_e( 'Pingback:', 'knowall' ); ?>
				<?php comment_author_link(); ?>
				<?php edit_comment_link( __( '(Edit)', 'knowall' ), ' ' ); ?>
			</p>
				<?php
			break;
			default : ?>

		<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'has-children' ) ?>>
			<article id="comment-<?php comment_ID(); ?>" class="ht-comment" itemscope itemtype="https://schema.org/Comment">  

				<!-- .ht-comment__header -->
				<header class="ht-comment__header">

					<div class="ht-comment__author" itemprop="author" itemscope itemtype="https://schema.org/Person">
						<?php echo get_avatar( $comment, 60, $default = '', $alt = '', $args = array( 'class' => 'ht-comment__authoravatar' ) ); ?>
						<span class="ht-comment__authorname" itemprop="name"><?php printf( _x( '%s', 'get_comment_author_link', 'knowall' ), sprintf( '%s', get_comment_author_link() ) ); ?></span>
					</div>

					<time class="ht-comment__time" datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
						<a itemprop="url" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) . __( ' ago', 'knowall' ); ?></a>
					</time>

				</header>
				<!-- /.ht-comment__header -->
				
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="ht-comment__moderation">
					<?php esc_html_e( 'Your comment is awaiting moderation.', 'knowall' ); ?>
				</p>
				<?php endif; ?>
				
				<div class="ht-comment__content" itemprop="text">
					<?php comment_text(); ?>
				</div >
				
				<footer class="ht-comment__footer">
				<!-- .ht-comment__actions -->
					<div class="ht-comment__actions">
						<?php edit_comment_link( __( 'Edit', 'knowall' ), '', '' ); ?>
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'knowall' ), 'depth' => $depth, 'max_depth' => get_option( 'thread_comments_depth' )  ) ) ); ?>
					</div>
				<!-- /.ht-comment__actions -->
				</footer>
				
				
			 
			</article>
			<!-- #comment-## -->
			<?php
				break;
			endswitch; // end comment_type check
	}
endif;
