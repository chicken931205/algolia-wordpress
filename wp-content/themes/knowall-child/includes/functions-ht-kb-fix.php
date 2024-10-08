<?php
/**
 * @package   HelpGuru Child/HT KB Fix
 * @author    Julien Liabeuf <julien@liabeuf.fr>
 * @license   GPL-2.0+
 * @link      http://julienliabeuf.com
 * @copyright 2014 Julien Liabeuf
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Fix issue with Relevanssi and HT Knowledgebase
 *
 * This filter seems to be the one breaking the search results page.
 * Let's just deactivate it for now so that the rest can work properly
 * with the latest version of both plugins.
 *
 * This should be removed if the author of the knowledgebase plugin
 * released a new version that fixes the compatibility problem with Relevanssi.
 *
 * @since 1.1.0
 */
if ( isset( $_GET['s'] ) ) {
	remove_filter( 'the_content', array( $ht_knowledge_base_init, 'ht_knowledge_base_custom_content' ) );
}
