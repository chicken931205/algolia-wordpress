<?php
/**
 * @package   HelpGuru Child/Search
 * @author    Julien Liabeuf <julien@liabeuf.fr>
 * @license   GPL-2.0+
 * @link      http://julienliabeuf.com
 * @copyright 2014 Julien Liabeuf
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => true,
);

$terms = get_terms( 'ht_kb_category', $args );
$wrapper = '<div class="sel-search-advanced" style="display:none;">%s</div><p class="sel-search-advanced-control" style="font-size:18px;"><a href="#" class="sel-search-advanced-show">%s</a></p>';

if ( ! empty( $terms ) ) {

	$options = array();
	$checked = '';

	// Add the order by date option
	if ( ! isset( $_GET['sel_search_order'] ) || 'desc' === $_GET['sel_search_order'] ) {
		$checked = 'checked="checked"';
	}

	$options[] = sprintf( '<label for="sel_kb_order"><input type="hidden" name="sel_search_order" value=""><input type="checkbox" id="sel_kb_order" name="sel_search_order" value="desc" %s> %s</label>', $checked, esc_html__( 'Order Results by Date', 'ht-theme' ) );


	foreach ( $terms as $term ) {

		$term    = sanitize_term( $term, 'ht_kb_category' );
		$checked = '';

		if ( ! isset( $_GET['sel_search_cat'] ) || ( ( is_array( $_GET['sel_search_cat'] ) && in_array( $term->term_id, $_GET['sel_search_cat'] ) ) ) ) {
			$checked = 'checked="checked"';
		}

		$options[] = sprintf( '<label for="sel_kb_cat_%1$s"><input type="hidden" name="sel_search_cat[]" value=""><input type="checkbox" id="sel_kb_cat_%1$s" name="sel_search_cat[]" value="%2$d" %4$s> %3$s</label>', $term->slug, (int) $term->term_id, $term->name, $checked );

	}

	printf( $wrapper, implode( '<br>', $options ), esc_html__( 'Advanced Search +', 'ht-theme' ) );

}