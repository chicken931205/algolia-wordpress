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

add_filter( 'query_vars', 'sel_kb_search_query_var' );
/**
 * Register the KB advanced search query var
 *
 * @param array $qv WordPress whitelisted query vars
 *
 * @return array
 */
function sel_kb_search_query_var( $qv ) {
	$qv[] = 'sel_search_cat';
	$qv[] = 'sel_search_order';

	return $qv;
}

add_action( 'pre_get_posts', 'sel_search_order', 10, 1 );
/**
 * Order the search results
 *
 * @param WP_Query $query
 *
 * @return WP_Query
 */
function sel_search_order( $query ) {

	if ( ! $query->is_main_query() ) {
		return $query;
	}

	// Make sure a search term is given
	if ( ! isset( $query->query_vars['s'] ) || empty( $query->query_vars['s'] ) ) {
		return $query;
	}

	$order = isset( $query->query_vars['sel_search_order'] ) ? $query->query_vars['sel_search_order'] : '';

	// Try to get the search terms from session if the search is done in Ajax
	if ( empty( $order ) && isset( $_GET['ajax'] ) && '1' === $_GET['ajax'] ) {
		if ( isset( $_SESSION['sel_search_order'] ) && ! empty( $_SESSION['sel_search_order'] ) ) {
			$order = $_SESSION['sel_search_order'];
		}
	}

	$order = strtoupper( $order );

	if ( in_array( $order, array( 'ASC', 'DESC' ) ) ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', $order );
	}

	return $query;

}

add_action( 'pre_get_posts', 'sel_search_categories', 10, 1 );
/**
 * Filter the search query
 *
 * @param WP_Query $query
 *
 * @return WP_Query
 */
function sel_search_categories( $query ) {

	if ( ! $query->is_main_query() ) {
		return $query;
	}

	// Make sure a search term is given
	if ( ! isset( $query->query_vars['s'] ) || empty( $query->query_vars['s'] ) ) {
		return $query;
	}

	$tax_query = array();
	$terms     = isset( $query->query_vars['sel_search_cat'] ) ? $query->query_vars['sel_search_cat'] : array();

	// Try to get the search terms from session if the search is done in Ajax
	if ( empty( $terms ) && isset( $_GET['ajax' ] ) && '1' === $_GET['ajax' ] ) {
		if ( isset( $_SESSION['sel_search_cats'] ) && ! empty( $_SESSION['sel_search_cats'] ) ) {
			$terms = $_SESSION['sel_search_cats'];
		}
	}

	$tax_query[] = array(
		'taxonomy' => 'ht_kb_category',
		'field'    => 'term_id',
		'terms'    => $terms,
		'operator' => 'IN',
	);

	if ( ! empty( $tax_query ) ) {
		$query->set( 'tax_query', $tax_query );
	}

	return $query;

}

add_action( 'wp_ajax_sel_update_search_cats', 'sel_update_search_advanced_parameters' );
add_action( 'wp_ajax_nopriv_sel_update_search_cats', 'sel_update_search_advanced_parameters' );
/**
 * Update the search parameters session
 *
 * Because there is no way to pass variables to the KB plugin (bad coding practices, not using WP Ajax, hardcoded Ajax URL),
 * the only solution for accessing the categories server-side without editing the KB plugin's code is to use PHP sessions
 * and update them with Ajax.
 *
 * @return void
 */
function sel_update_search_advanced_parameters() {

	if ( ! isset( $_SESSION['sel_search_cats'] ) ) {
		$_SESSION['sel_search_cats'] = array();
	}

	if ( ! isset( $_SESSION['sel_search_order'] ) ) {
		$_SESSION['sel_search_order'] = array();
	}

	if ( isset( $_POST['sel_cats'] ) ) {
		$_SESSION['sel_search_cats'] = json_decode( stripslashes( $_POST['sel_cats'] ) );
	}

	if ( isset( $_POST['sel_order'] ) ) {
		$_SESSION['sel_search_order'] = $_POST['sel_order'];
	}

	echo json_encode( $_SESSION['sel_search_cats'] );
	die();
}
