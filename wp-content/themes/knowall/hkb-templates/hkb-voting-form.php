<?php
/**
* Theme template for display the voting feedback form
*/
global $post_id, $voting_nonce, $feedback_nonce;

$new_vote = ht_kb_voting_get_new_vote();

$votes = ht_voting_get_post_votes( $post_id );

$allow_anon = ht_kb_voting_enable_anonymous();

$vote_enabled_class = ( ! $allow_anon && ! is_user_logged_in() ) ? 'disabled' : 'enabled';

$user_vote_direction = ht_kb_voting_get_users_post_vote_direction( $post_id );

?>

<?php if ( ! $allow_anon && ! is_user_logged_in() ) : ?>	
	<div class="voting-login-required" data-ht-voting-must-log-in-msg="<?php esc_html_e( 'You must log in to vote', 'knowall' ); ?>">
		<?php esc_html_e( 'You must log in to vote', 'knowall' ); ?>
	</div>
<?php endif; ?>
<div class="ht-voting-links ht-voting-<?php echo esc_attr( $user_vote_direction ); ?>">
	<a class="ht-voting-upvote <?php echo esc_attr( $vote_enabled_class ); ?>" rel="nofollow" role="button" data-direction="up" data-type="post" data-nonce="<?php echo esc_attr( $voting_nonce ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>" data-allow="<?php echo esc_attr( $allow_anon ); ?>" data-display="standard" href="<?php echo '#'; // $this->vote_post_link('up', $post_id, $allow); ?>">
		<i class="hkb-upvote-icon"></i>
		<span><?php esc_html_e( 'Yes', 'knowall' ); ?></span>
	</a>
	<a class="ht-voting-downvote <?php echo esc_attr( $vote_enabled_class ); ?>" rel="nofollow" role="button" data-direction="down" data-type="post" data-nonce="<?php echo esc_attr( $voting_nonce ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>" data-allow="<?php echo esc_attr( $allow_anon ); ?>" data-display="standard" href="<?php echo '#'; // $this->vote_post_link('down', $post_id, $allow); ?>">
		<i class="hkb-upvote-icon"></i>
		<span><?php esc_html_e( 'No', 'knowall' ); ?></span>
	</a>
</div>
<?php if ( empty( $new_vote ) ) : ?>
	<!-- no new vote -->
<?php elseif ( ht_kb_voting_show_feedback_form() ) : ?>
	<div class="ht-voting-comment <?php echo esc_attr( $vote_enabled_class ); ?>" data-nonce="<?php echo esc_attr( $feedback_nonce ); ?>"  data-vote-key="<?php echo esc_attr( $new_vote->key ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>">
		<textarea class="ht-voting-comment__textarea" rows="4" cols="50" placeholder="<?php esc_html_e( 'Thanks for your feedback, add a comment here to help improve the article', 'knowall' ); ?>"><?php if ( isset( $new_vote->comments ) ) $new_vote->comments; ?></textarea>
		<button class="ht-voting-comment__submit" type="button" role="button"><?php esc_html_e( 'Send Feedback', 'knowall' ); ?></button>
	</div>
<?php else : ?>
			<div class="ht-voting-thanks"><?php esc_html_e( 'Thanks for your feedback', 'knowall' ); ?></div>
<?php endif; //vote_key ?>
