<?php
/*
*
* The template used for displaying the search box
*
*/
?>

<?php /* important - load live search scripts */ /* dep- ht_knowledge_base_activate_live_search(); */ do_action('ht_knowledge_base_activate_live_search');  ?>
<form class="hkb-site-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="hkb-screen-reader-text" for="hkb-search"><?php esc_html_e( 'Search For', 'knowall' ); ?></label>
		<input id="hkb-search" class="hkb-site-search__field" type="text" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr( apply_filters( 'hkb_search_placeholder', __( 'Search the knowledge base...', 'knowall' ) ) ); ?>" name="s" autocomplete="off">
		<img class="hkb-site-search__loader" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/loading.svg" alt="<?php esc_html_e( 'Searching...', 'knowall' ); ?>" />
		<input type="hidden" name="ht-kb-search" value="1" />
    	<input type="hidden" name="lang" value="<?php if( defined( 'ICL_LANGUAGE_CODE' ) ) echo( ICL_LANGUAGE_CODE ); ?>"/>
		<button class="hkb-site-search__button" type="submit"><span><?php esc_html_e( 'Search', 'knowall' ); ?></span></button>
</form>
