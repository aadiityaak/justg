<?php
/**
 * Shipping Function
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Define plugin constants.
define( 'JUSTG_FILE', __FILE__ );

// Load the helpers.
require_once get_template_directory() . '/woocommerce/ongkir/includes/helpers.php';

// Register the class auto loader.
if ( function_exists( 'justg_autoload' ) ) {
	spl_autoload_register( 'justg_autoload' );
}

/**
 * Boot the plugin
 */
if ( justg_is_woocommerce_activated() && class_exists( 'justg' ) ) {
	// Initialize the justg class.
	justg::get_instance();
}
