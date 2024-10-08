<?php
/**
* Theme template for voting
*/
?>

<div class="hkb-feedback">
	<h3 class="hkb-feedback__title"><?php esc_attr_e( 'Was this article helpful?', 'knowall' ); ?></h3>
	<?php do_action( 'ht_voting_post' ); ?>
</div>
