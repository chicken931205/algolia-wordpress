<?php
/*
*
* The template used for displaying the tags
*
*/

if( !taxonomy_exists( 'ht_kb_tag' ) ){
	return;
}

?>

<div class="hkb-article-tags">
	<?php echo get_the_term_list( $post->ID, 'ht_kb_tag', __( 'Tagged: ', 'knowall' ), '', '' ); ?>
</div>
