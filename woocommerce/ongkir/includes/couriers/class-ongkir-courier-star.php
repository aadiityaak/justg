<?php
/**
 * The file that defines the ongkir_Courier_STAR class
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
 * The ongkir_Courier_STAR class.
 *
 * @since      1.2.12
 * @package    justg
 * @subpackage justg/includes
 * @author     Sofyan Sitorus <sofyansitorus@gmail.com>
 */
class ongkir_Courier_STAR extends ongkir_Courier {

	/**
	 * Courier Code
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $code = 'star';

	/**
	 * Courier Label
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $label = 'Star Cargo';

	/**
	 * Courier Website
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $website = 'http://www.starcargo.co.id';

	/**
	 * Get courier services for domestic shipping
	 *
	 * @since 1.2.12
	 *
	 * @return array
	 */
	public function get_services_domestic_default() {
		return array(
			'Express'            => 'Express',
			'Reguler'            => 'Reguler',
			'Dokumen'            => 'Dokumen',
			'MOTOR'              => 'MOTOR',
			'MOTOR 150 - 250 CC' => 'MOTOR 150 - 250 CC',
		);
	}

	/**
	 * Get courier account for domestic shipping
	 *
	 * @since 1.2.12
	 *
	 * @return array
	 */
	public function get_account_domestic() {
		return array(
			'pro',
		);
	}
}
