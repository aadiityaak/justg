<?php
/**
 * The file that defines the justg_Courier_EXPEDITO class
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
 * The justg_Courier_EXPEDITO class.
 *
 * @since      1.2.12
 * @package    justg
 * @subpackage justg/includes
 * @author     Sofyan Sitorus <sofyansitorus@gmail.com>
 */
class justg_Courier_EXPEDITO extends justg_Courier {

	/**
	 * Courier Code
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $code = 'expedito';

	/**
	 * Courier Label
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $label = 'Expedito';

	/**
	 * Courier Website
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $website = 'http://www.expedito.co.id';

	/**
	 * Get courier services for international shipping
	 *
	 * @since 1.2.12
	 *
	 * @return array
	 */
	public function get_services_international_default() {
		return array(
			'CityLink'         => 'CityLink',
			'DPEX'             => 'DPEX',
			'ARAMEX Indonesia' => 'ARAMEX Indonesia',
			'DHL  JKT'         => 'DHL  JKT',
			'DHL Singapore'    => 'DHL Singapore',
			'SF EXPRESS'       => 'SF EXPRESS',
			'SkyNet Worldwide' => 'SkyNet Worldwide',
			'TNT | Fedex'      => 'TNT | Fedex',
		);
	}

	/**
	 * Get courier account for international shipping
	 *
	 * @since 1.2.12
	 *
	 * @return array
	 */
	public function get_account_international() {
		return array(
			'pro',
		);
	}
}
