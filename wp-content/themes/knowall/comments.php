<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) :
	return;
endif; ?>

<div id="comments" class="ht-commentslist">

	<?php if ( have_comments() ) : ?>
		<h2 class="ht-commentslist__title">
			<?php esc_html_e( 'Comments', 'knowall' ); ?>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
						'callback'   => 'ht_comment',
						'style'      => 'ol',
						'short_ping' => true,
					)
				);
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'knowall' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'knowall' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'knowall' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'knowall' ); ?></p>
	<?php endif; ?>

	<?php
	$ht_post_id        = get_the_ID();
	$req               = get_option( 'require_name_email' );
	$aria_req          = ( $req ? " aria-required='true'" : '' );
	$html_req          = ( $req ? " required='required'" : '' );
	$required_span     = '<span class="required" title="' . __( 'required', 'knowall' ) . '">*</span>';
	$comment_form_args = array(
		'fields'               => array(
			'author' => '<p class="ht-commentform__author">' . '<label for="author">' . __( 'Name', 'knowall' ) . '</label> ' .
																'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>',
			'email'  => '<p class="ht-commentform__email"><label for="email">' . __( 'Email', 'knowall' ) . '</label> ' . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req . ' /></p>',
			'url'    => '',
		),
		'comment_field'        => '<p class="ht-commentform__comment"><label for="comment">' . _x( 'Comment', 'noun', 'knowall' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8"  aria-required="true" required="required"></textarea></p>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'knowall' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $ht_post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'knowall' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $ht_post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'id_form'              => 'ht-commentform',
		'id_submit'            => 'submit',
		'class_submit'         => 'submit',
		'name_submit'          => 'submit',
		'title_reply'          => __( 'Leave a Comment', 'knowall' ),
		'title_reply_to'       => __( 'Reply to %s', 'knowall' ),
		'cancel_reply_link'    => __( 'Cancel', 'knowall' ),
		'label_submit'         => __( 'Post Comment', 'knowall' ),
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field'         => '<p class="ht-commentform__submit">%1$s %2$s</p>',
		'format'               => 'xhtml',
	);
	
	//augment comment form args with knowall_comment_form_args filter 
	$comment_form_args = apply_filters( 'knowall_comment_form_args', $comment_form_args );

	?>

	<?php
	// Modify default WP classes
	ob_start();
	comment_form( $args = $comment_form_args );

	$form_ob_get_clean = ob_get_clean();

	$form_ob_get_clean = str_replace( 'class="comment-respond"', 'class="ht-commentform"', $form_ob_get_clean );
	$form_ob_get_clean = str_replace( 'class="comment-reply-title"', 'class="ht-commentform__title"', $form_ob_get_clean );

	echo $form_ob_get_clean;
	?>

</div><!-- #comments -->
