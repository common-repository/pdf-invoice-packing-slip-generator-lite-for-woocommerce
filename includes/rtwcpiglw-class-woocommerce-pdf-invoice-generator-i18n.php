<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/includes
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
class rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_load_plugin_textdomain() {

		load_plugin_textdomain(
			'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
