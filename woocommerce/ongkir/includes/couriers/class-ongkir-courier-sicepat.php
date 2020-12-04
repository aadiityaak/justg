<?php
/**
 * The file that defines the ongkir_Courier_SICEPAT class
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
 * The ongkir_Courier_SICEPAT class.
 *
 * @since      1.2.12
 * @package    justg
 * @subpackage justg/includes
 * @author     Sofyan Sitorus <sofyansitorus@gmail.com>
 */
class ongkir_Courier_SICEPAT extends ongkir_Courier {

	/**
	 * Courier Code
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $code = 'sicepat';

	/**
	 * Courier Label
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $label = 'SiCepat Express';

	/**
	 * Courier Website
	 *
	 * @since 1.2.12
	 *
	 * @var string
	 */
	public $website = 'http://www.sicepat.com';

	/**
	 * Get courier services for domestic shipping
	 *
	 * @since 1.2.12
	 *
	 * @return array
	 */
	public function get_services_domestic_default() {
		return array(
			'REG'   => 'Layanan Reguler',
			'BEST'  => 'Besok Sampai Tujuan',
			'Cargo' => 'Cargo',
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
