<?php
/**
 * Add WooCommerce support
 *
 * @package justg
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'justg_woocommerce_support' );
if ( ! function_exists( 'justg_woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function justg_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		// Add Product Gallery support.
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Add Bootstrap classes to form fields.
		add_filter( 'woocommerce_form_field_args', 'justg_wc_form_field_args', 10, 3 );

		// Remove woocomerce breadcrumb 
		remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
	}
}

if ( ! function_exists( 'justg_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function justg_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

//Load Ongkir Function
if ( justg_is_woocommerce_activated() ) {
	require_once get_template_directory() . '/woocommerce/wishlist.php';
	require_once get_template_directory() . '/woocommerce/ongkir/ongkir.php';
}

// First unhook the WooCommerce content wrappers.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Then hook in your own functions to display the wrappers your theme requires.
add_action( 'woocommerce_before_main_content', 'justg_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'justg_woocommerce_wrapper_end', 10 );

if ( ! function_exists( 'justg_woocommerce_wrapper_start' ) ) {
	/**
	 * Display the theme specific start of the page wrapper.
	 */
	function justg_woocommerce_wrapper_start() {
		$container = get_theme_mod( 'justg_container_type' );
		echo '<div class="wrapper" id="woocommerce-wrapper">';
		echo '<div class="' . esc_attr( $container ) . '" id="content" tabindex="-1">';
		echo '<div class="row">';
		// Do the left sidebar check
		do_action('justg_before_content');
		echo '<main class="site-main col order-2" id="main">';
	}
}

if ( ! function_exists( 'justg_woocommerce_wrapper_end' ) ) {
	/**
	 * Display the theme specific end of the page wrapper.
	 */
	function justg_woocommerce_wrapper_end() {
		echo '</main><!-- #main -->';
		// Do the right sidebar check.
		do_action('justg_after_content');
		echo '</div><!-- Row end -->';
		echo '</div><!-- Container end -->';
		echo '</div><!-- Wrapper end -->';
	}
}

if ( ! function_exists( 'justg_wc_form_field_args' ) ) {
	/**
	 * Filter hook function monkey patching form classes
	 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
	 *
	 * @param string $args Form attributes.
	 * @param string $key Not in use.
	 * @param null   $value Not in use.
	 *
	 * @return mixed
	 */
	function justg_wc_form_field_args( $args, $key, $value = null ) {
		// Start field type switch case.
		switch ( $args['type'] ) {
			// Targets all select input type elements, except the country and state select input types.
			case 'select':
				/*
				 * Add a class to the field's html element wrapper - woocommerce
				 * input types (fields) are often wrapped within a <p></p> tag.
				 */
				$args['class'][] = 'form-group';
				// Add a class to the form input itself.
				$args['input_class'] = array( 'form-control' );
				// Add custom data attributes to the form input itself.
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;
			/*
			 * By default WooCommerce will populate a select with the country names - $args
			 * defined for this specific input type targets only the country select element.
			 */
			case 'country':
				$args['class'][] = 'form-group single-country';
				break;
			/*
			 * By default WooCommerce will populate a select with state names - $args defined
			 * for this specific input type targets only the country select element.
			 */
			case 'state':
				$args['class'][] = 'form-group';
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;
			case 'password':
			case 'text':
			case 'email':
			case 'tel':
			case 'number':
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control' );
				break;
			case 'textarea':
				$args['input_class'] = array( 'form-control' );
				break;
			case 'checkbox':
				// Add a class to the form input's <label> tag.
				$args['label_class'] = array( 'custom-control custom-checkbox' );
				$args['input_class'] = array( 'custom-control-input' );
				break;
			case 'radio':
				$args['label_class'] = array( 'custom-control custom-radio' );
				$args['input_class'] = array( 'custom-control-input' );
				break;
			default:
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control' );
				break;
		} // End of switch ( $args ).
		return $args;
	}
}

if ( ! is_admin() && ! function_exists( 'wc_review_ratings_enabled' ) ) {
	/**
	 * Check if reviews are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_reviews_enabled() {
		return 'yes' === get_option( 'woocommerce_enable_reviews' );
	}

	/**
	 * Check if reviews ratings are enabled.
	 *
	 * Function introduced in WooCommerce 3.6.0., include it for backward compatibility.
	 *
	 * @return bool
	 */
	function wc_review_ratings_enabled() {
		return wc_reviews_enabled() && 'yes' === get_option( 'woocommerce_enable_review_rating' );
	}
}

if ( ! function_exists( 'justg_override_checkout_fields' ) && class_exists( 'WooCommerce' ) ) {
	//Unset checkout fields
	add_filter( 'woocommerce_checkout_fields' , 'justg_override_checkout_fields' );
	function justg_override_checkout_fields( $fields ) {
		unset($fields['billing']['billing_company']);
		return $fields;
	}
}

if ( ! function_exists( 'justg_handheld_footer_bar_cart_link' ) ) {
	/**
	 * The cart callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function justg_handheld_footer_bar_cart_link() {
		if ( ! justg_woo_cart_available() ) {
			return;
		}
		?>
			<a class="footer-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'justg' ); ?>">
				<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'justg_woo_cart_available' ) ) {
	/**
	 * Validates whether the Woo Cart instance is available in the request
	 *
	 * @since 2.6.0
	 * @return bool
	 */
	function justg_woo_cart_available() {
		$woo = WC();
		return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
	}
}

/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter ( 'woocommerce_account_menu_items', 'justg_add_link', 40 );
function justg_add_link( $menu_links ){
 
	$menu_links = array_slice( $menu_links, 0, 5, true ) 
	+ array( 'wishlist' => 'Wishlist' )
	+ array_slice( $menu_links, 5, NULL, true );
 
	return $menu_links;
 
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'justg_add_endpoint' );
function justg_add_endpoint() {
 
	// WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
	add_rewrite_endpoint( 'wishlist', EP_PAGES );
 
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_wishlist_endpoint', 'justg_my_account_endpoint_content' );
function justg_my_account_endpoint_content() {
 	echo wishlist();
 
}
