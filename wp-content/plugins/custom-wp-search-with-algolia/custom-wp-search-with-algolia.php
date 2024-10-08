<?php
/**
 * Plugin Name:       Customized WP Search With Algolia
 * Plugin URI:        
 * Description:       Customized WP Search With Algolia Plugin
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            GoldenChicken
 * Author URI:        https://my-portfolio-puce-eta.vercel.app/wordpress
 * Text Domain:       customized-wp-search-with-algolia
 *
 * @since   1.0.0
 * @package customized-wp-search-with-algolia
 */
define( 'ALGOLIA_CUSTOMIZED_JS_VERSION', '1.0.1' );
define( 'ALGOLIA_CUSTOMIZED_CSS_VERSION', '1.0.1' );
define( 'ALGOLIA_CUSTOMIZED_FILE', __FILE__ );

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script( 'custom-js', plugin_dir_url( ALGOLIA_CUSTOMIZED_FILE ) . 'custom.js', array( 'jquery' ), ALGOLIA_CUSTOMIZED_JS_VERSION, true );
    wp_enqueue_style( 'custom-css', plugin_dir_url( ALGOLIA_CUSTOMIZED_FILE ) . 'custom.css', array(), ALGOLIA_CUSTOMIZED_CSS_VERSION, true );
} );

/**
  * set search params
  * reference: wp-search-with-algolia/includes/class-algolia-search.php -> function pre_get_posts() //line: 148
  */
 function add_search_params_for_advanced_search( $args ) {
    if ( is_search() && isset( $_GET['sel_search_cat'] ) ) {
        $termIDs = $_GET['sel_search_cat'];
        $facetFilters = [];

        foreach ($termIDs as $termID) {
            $term = get_term($termID);

            if (!is_wp_error($term)) {
                $filter = "taxonomies.ht_kb_category:" . $term->name;
                $facetFilters[] = $filter;
            } 
        }

        if ( ! empty( $facetFilters ) ) {
            $args['facetFilters'] = [$facetFilters];
        }      
    }

    $args['advancedSyntax'] = true;
    $args['typoTolerance'] = 'false';

    return $args;
}
add_filter( 'algolia_search_params', 'add_search_params_for_advanced_search' );

/**
 * set attribute for sorting
 * reference: wp-search-with-algolia/includes/class-algolia-search.php -> function pre_get_posts() //line: 148
 */
function modify_algolia_search_order_by( $order_by ) {
    if ( is_search() && isset( $_GET['sel_search_order'] ) && $_GET['sel_search_order'] !== "" ) {
        $order_by = 'post_date';
    }
    return $order_by;
}
add_filter( 'algolia_search_order_by', 'modify_algolia_search_order_by' );

/**
 * set order for sorting by asc or desc
 * reference: wp-search-with-algolia/includes/class-algolia-search.php -> function pre_get_posts() //line: 148
 */
function modify_algolia_search_order( $order ) {
    if ( is_search() && isset( $_GET['sel_search_order'] ) && $_GET['sel_search_order'] !== "" ) {
        $order = $_GET['sel_search_order'];//asc or desc
    }
    return $order;
}
add_filter( 'algolia_search_order', 'modify_algolia_search_order' );

if (!class_exists('WebDevStudios\WPSWA\Algolia_Index_Replica')) {
    require_once WP_PLUGIN_DIR . '/wp-search-with-algolia/includes/indices/class-algolia-index-replica.php';
}

/**
 * set replica index for sorting
 * reference: wp-search-with-algolia/includes/indicies/class-algolia-index.php -> function get_replicas() //line: 780
 * reference: wp-search-with-algolia/includes/indicies/class-algolia-index-replica.php
 */
function set_algolia_index_replica( $replica_indexes, $index ) {
    if (class_exists('Algolia_Index_Replica')) {
        $replica_asc = new Algolia_Index_Replica('post_date', 'asc');//sort attribute (order_by): post_date, order: asc
        $replica_indexes[] = $replica_asc;

        $replica_desc = new Algolia_Index_Replica('post_date', 'desc');//sort attribute (order_by): post_date, order: desc
        $replica_indexes[] = $replica_desc;
    } else {
        error_log('Algolia_Index_Replica class not found');
    }
    return $replica_indexes;
}
add_filter( 'algolia_index_replicas', 'set_algolia_index_replica', 10, 2 );




