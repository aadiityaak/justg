<?php
/**
 * The file that defines the ongkir_Account_Pro class
 *
 * @link       https://github.com/sofyansitorus
 * @since      1.2.12
 *
 * @package    justg
 * @subpackage justg/includes
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The ongkir_Account_Pro class.
 *
 * @since      1.2.12
 * @package    justg
 * @subpackage justg/includes
 * @author     Sofyan Sitorus <sofyansitorus@gmail.com>
 */
class ongkir_Account_Pro extends ongkir_Account {

	/**
	 * Account priority
	 *
	 * @since 1.2.12
	 *
	 * @var int
	 */
	public $priority = 3;

	/**
	 * Account type
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $type = 'pro';

	/**
	 * Account label
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $label = 'Pro';

	/**
	 * Account API URL
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */

	// public $api_url = 'https://websweet.xyz/ongkir.php';
	public $api_url = 'https://pro.rajaongkir.com/api/';

	/**
	 * Account features
	 *
	 * @since 1.2.12
	 *
	 * @var array
	 */
	public $features = array(
		'subdistrict'       => true,
		'multiple_couriers' => true,
		'volumetric'        => true,
		'weight_over_30kg'  => true,
		'dedicated_server'  => true,
	);

	/**
	 * Parse API request parameters.
	 *
	 * @since 1.2.12
	 *
	 * @param array  $params   API request parameters to parse.
	 * @param string $endpoint API request endpoint.
	 *
	 * @return (array|WP_Error)
	 */
	public function api_request_parser( $params = array(), $endpoint = '' ) {
		if ( '/cost' === $endpoint ) {
			$this->api_request_params_required = array(
				'origin',
				'originType',
				'destination',
				'destinationType',
				'weight',
				'courier',
			);

			$this->api_request_params_optional = array(
				'length',
				'width',
				'height',
				'diameter',
			);
		} elseif ( '/v2/internationalCost' === $endpoint ) {
			$this->api_request_params_required = array(
				'origin',
				'destination',
				'weight',
				'courier',
			);

			$this->api_request_params_optional = array(
				'length',
				'width',
				'height',
			);
		}

		return parent::api_request_parser( $params );
	}
}
