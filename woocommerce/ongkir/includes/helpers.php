<?php
/**
 * Helper methods.
 *
 * @package justg
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'justg_autoload' ) ) :
	/**
	 * Class autoload
	 *
	 * @since 1.2.12
	 *
	 * @param string $class Class name.
	 *
	 * @return void
	 */
	function justg_autoload( $class ) {
		$class = strtolower( $class );
		echo '<pre>';
print_r($class);
echo '</pre>';
		if ( strpos( $class, 'ongkir' ) !== 0 ) {
			return;
		}

		if ( strpos( $class, 'ongkir_account_' ) === 0 ) {
			require_once get_template_directory() . '/woocommerce/ongkir/includes/accounts/class-' . str_replace( '_', '-', $class ) . '.php';
		} elseif ( strpos( $class, 'ongkir_courier_' ) === 0 ) {
			require_once get_template_directory() . '/woocommerce/ongkir/includes/couriers/class-' . str_replace( '_', '-', $class ) . '.php';
		} else {
			require_once get_template_directory() . '/woocommerce/ongkir/includes/classes/class-' . str_replace( '_', '-', $class ) . '.php';
		}
	}
endif;

if ( ! function_exists( 'justg_get_json_data' ) ) :
	/**
	 * Get json file data.
	 *
	 * @since 1.0.0
	 * @param array $file_name File name for the json data.
	 * @param array $search Search keyword data.
	 * @throws  Exception If WordPress Filesystem Abstraction classes is not available.
	 * @return array
	 */
	function justg_get_json_data( $file_name, $search = array() ) {
		global $wp_filesystem;

		$file_url  = get_template_directory_uri() .'/inc/data/' . $file_name . '.json';
		$file_path = get_template_directory_uri() . '/inc/data/' . $file_name . '.json';

		try {
			require_once ABSPATH . 'wp-admin/includes/file.php';

			if ( is_null( $wp_filesystem ) ) {
				WP_Filesystem();
			}

			if ( ! $wp_filesystem instanceof WP_Filesystem_Base || ( is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) ) {
				throw new Exception( 'WordPress Filesystem Abstraction classes is not available', 1 );
			}

			if ( ! $wp_filesystem->exists( $file_path ) ) {
				throw new Exception( 'JSON file is not exists or unreadable', 1 );
			}

			$json = $wp_filesystem->get_contents( $file_path );
		} catch ( Exception $e ) {
			// Get JSON data by HTTP if the WP_Filesystem API procedure failed.
			$json = wp_remote_retrieve_body( wp_remote_get( esc_url_raw( $file_url ) ) );
		}

		if ( ! $json ) {
			return false;
		}

		$json_data  = json_decode( $json, true );
		$json_error = json_last_error_msg();

		if ( ! $json_data || ( $json_error && 'no error' !== strtolower( $json_error ) ) ) {
			return false;
		}

		// Search JSON data by associative array. Return the match row or false if not found.
		if ( $search ) {
			foreach ( $json_data as $row ) {
				if ( array_intersect_assoc( $search, $row ) === $search ) {
					return $row;
				}
			}

			return false;
		}

		return $json_data;
	}
endif;

if ( ! function_exists( 'justg_scripts_params' ) ) :
	/**
	 * Get localized scripts parameters.
	 *
	 * @since 1.2.11
	 *
	 * @param array $params Custom localized scripts parameters.
	 *
	 * @return array
	 */
	function justg_scripts_params( $params = array() ) {
		return wp_parse_args(
			$params,
			array(
				'ajax_url'      => admin_url( 'ajax.php' ),
				'json'          => array(
					'country_url'     => add_query_arg( array( 't' => time() ), get_template_directory_uri() .'/inc/data/country.json' ),
					'country_key'     => 'justg_country_data',
					'province_url'    => add_query_arg( array( 't' => time() ), get_template_directory_uri() .'/inc/data/province.json' ),
					'province_key'    => 'justg_province_data',
					'city_url'        => add_query_arg( array( 't' => time() ), get_template_directory_uri() .'/inc/data/city.json' ),
					'city_key'        => 'justg_city_data',
					'subdistrict_url' => add_query_arg( array( 't' => time() ), get_template_directory_uri() .'/inc/data/subdistrict.json' ),
					'subdistrict_key' => 'justg_subdistrict_data',
				),
				'text'          => array(
					'placeholder' => array(
						'state'     => __( 'Province', 'justg' ),
						'city'      => __( 'Town / City', 'justg' ),
						'address_2' => __( 'Subdistrict', 'justg' ),
					),
					'label'       => array(
						'state'     => __( 'Province', 'justg' ),
						'city'      => __( 'Town / City', 'justg' ),
						'address_2' => __( 'Subdistrict', 'justg' ),
					),
				),
				'debug'         => ( 'yes' === get_option( 'woocommerce_shipping_debug_mode', 'no' ) ),
				'show_settings' => isset( $_GET['justg_settings'] ) && is_admin(), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			'method_id'         => 'ongkir',
			'method_title'      => 'Ongkir ID',
			)
		);
	}
endif;

if ( ! function_exists( 'justg_sort_by_priority' ) ) :
	/**
	 * Sort data by priority
	 *
	 * @param array $a Item to compare.
	 * @param array $b Item to compare.
	 *
	 * @return int
	 */
	function justg_sort_by_priority( $a, $b ) {
		$a_priority = 0;

		if ( is_object( $a ) && is_callable( array( $a, 'get_priority' ) ) ) {
			$a_priority = $a->get_priority();
		} elseif ( isset( $a['priority'] ) ) {
			$a_priority = $a['priority'];
		}

		$b_priority = 0;

		if ( is_object( $b ) && is_callable( array( $b, 'get_priority' ) ) ) {
			$b_priority = $b->get_priority();
		} elseif ( isset( $b['priority'] ) ) {
			$b_priority = $b['priority'];
		}

		return strcasecmp( $a_priority, $b_priority );
	}
endif;

if ( ! function_exists( 'justg_instances' ) ) :
	/**
	 * Get shipping method instances
	 *
	 * @since 1.3.0
	 *
	 * @param bool $enabled_only Filter to includes only enabled instances.
	 * @return array
	 */
	function justg_instances( $enabled_only = true ) {
		$instances = array();

		$zone_data_store = new WC_Shipping_Zone_Data_Store();

		$shipping_methods = $zone_data_store->get_methods( '0', $enabled_only );

		if ( $shipping_methods ) {
			foreach ( $shipping_methods as $shipping_method ) {
				if ( 'ongkir' !== $shipping_method->method_id ) {
					continue;
				}

				$instances[] = array(
					'zone_id'     => 0,
					'method_id'   => $shipping_method->method_id,
					'instance_id' => $shipping_method->instance_id,
				);
			}
		}

		$zones = WC_Shipping_Zones::get_zones();

		if ( ! empty( $zones ) ) {
			foreach ( $zones as $zone ) {
				$shipping_methods = $zone_data_store->get_methods( $zone['id'], $enabled_only );
				if ( $shipping_methods ) {
					foreach ( $shipping_methods as $shipping_method ) {
						
						if ( 'ongkir' !== $shipping_method->method_id ) {
							continue;
						}

						$instances[] = array(
							'zone_id'     => 0,
							'method_id'   => $shipping_method->method_id,
							'instance_id' => $shipping_method->instance_id,
						);
					}
				}
			}
		}

		return apply_filters( 'justg_instances', $instances );
	}
endif;
