<?php
/**
 * Template Hook
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Header Open
 *
 * @see justg_header_open()
 */
add_action( 'justg_header_open', 'justg_header_open', 20 );

/**
 * Header Before
 *
 * @see justg_header_logo()
 */
add_action( 'justg_header_before', 'justg_header_logo' );

/**
 * Header
 *
 * @see justg_header_menu()
 */
add_action( 'justg_header', 'justg_header_menu' );

/**
 * Header After
 *
 * @see justg_header_profile()
 * @see justg_header_wishlist()
 * @see justg_header_cart()
 */
add_action( 'justg_header_after', 'justg_header_profile' );
add_action( 'justg_header_after', 'justg_header_wishlist' );
add_action( 'justg_header_after', 'justg_header_cart' );

/**
 * Header Close
 *
 * @see justg_header_close()
 */
add_action( 'justg_header_close', 'justg_header_close' );

/**
 * Cart Fragment
 * 
 * @see justg_cart_link_fragment()
 * @see justg_widget_shopping_cart_button_view_cart()
 * @see justg_widget_shopping_cart_proceed_to_checkout()
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'justg_cart_link_fragment' );

// Remove default function
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

// replace with new function
add_action( 'woocommerce_widget_shopping_cart_buttons', 'justg_widget_shopping_cart_button_view_cart', 10 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'justg_widget_shopping_cart_proceed_to_checkout', 20 );

/**
 * Product Title
 * 
 * @see justg_loop_product_title()
 */
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
add_action('woocommerce_shop_loop_item_title', 'justg_loop_product_title', 10 );

/**
 * Before Title
 *
 * @see justg_breadcrumb()
 */
$breadcrumb_position = get_theme_mod('breadcrumb_position', 'justg_after_title');
add_action( $breadcrumb_position , 'justg_breadcrumb' );


/**
 * Before Content
 *
 * @see justg_left_sidebar_check()
 */
add_action( 'justg_before_content', 'justg_left_sidebar_check' );

/**
 * After Content
 *
 * @see justg_left_sidebar_check()
 */
add_action( 'justg_after_content', 'justg_right_sidebar_check' );

/**
 * Footer
 *
 * @see justg_the_footer_open()
 * @see justg_the_footer_content()
 * @see justg_the_footer_close()
 */
add_action( 'justg_do_footer', 'justg_the_footer_open' );
add_action( 'justg_do_footer', 'justg_the_footer_content' );
add_action( 'justg_do_footer', 'justg_the_footer_close' );

/**
 * WP Footer
 *
 * @see justg_widget_float()
 */
add_action( 'wp_footer', 'justg_widget_float' );

/**
 * Footer Float
 *
 * @see justg_do_float_footer()
 */
add_action( 'justg_do_float_footer', 'justg_whatsapp_float',10 );
add_action( 'justg_do_float_footer', 'justg_totop_float',10 );

/**
 * WP Footer
 *
 * @see justg_share()
 */
add_action('woocommerce_share','justg_share');