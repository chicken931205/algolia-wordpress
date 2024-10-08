<?php
/**
* WooCommerce compatibility layer
*/

if( !class_exists( 'HT_KnowAll_WooCommerce_Compat' ) ) {
	class HT_KnowAll_WooCommerce_Compat {

		function __construct() {
			// Remove default wrappers.
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

			// Add custom wrappers.
			add_action( 'woocommerce_before_main_content', array( $this, 'output_content_wrapper' ) );
			add_action( 'woocommerce_after_main_content', array( $this, 'output_content_wrapper_end' ) );

			// Declare theme support for features.
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
			add_theme_support(
				'woocommerce',
				array(
					'thumbnail_image_width' => 200,
					'single_image_width'    => 300,
				)
			);
		}

		/**
		 * Open wrappers.
		 */
		public static function output_content_wrapper() {
			?>
				<div class="ht-page <?php ht_sidebarpostion_page(); ?>">
				<div class="ht-container">
				<?php ht_get_sidebar_page( 'left' ); ?>
				<div class="ht-page__content">
			<?php
		}

		/**
		 * Close wrappers.
		 */
		public static function output_content_wrapper_end(){
			?>
				</div>
				<?php ht_get_sidebar_page( 'right' ); ?>
				</div>
				</div>
			<?php
		}

	}
}

if( class_exists( 'HT_KnowAll_WooCommerce_Compat' ) ) {
	$ht_knowall_updater_init = new HT_KnowAll_WooCommerce_Compat();
}