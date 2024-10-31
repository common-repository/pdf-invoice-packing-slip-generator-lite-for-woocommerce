<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.redefiningtheweb.com
 * @since             1.0.0
 * @package           rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 *
 * @wordpress-plugin
 * Plugin Name:       PDF Invoice & Packing Slip Generator Lite For WooCommerce
 * Plugin URI:        www.redefiningtheweb.com/woocommerce-wordpress-plugins
 * Description:       This plugin is lite version of our WooCommerce PDF Invoice & Packing Slip Generator.
 * Version:           1.3.0
 * Author:            RedefiningTheWeb
 * Author URI:        www.redefiningtheweb.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 * Tested Up To:      6.6.2
 * WC tested up to:   9.3.3
 * WC requires at least: 2.6.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'rtwcpiglw_WOOCOMMERCE_PDF_INVOICE_GENERATOR_VERSION', '1.3.0' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/rtwcpiglw-class-woocommerce-pdf-invoice-generateor-activator.php
 */

/**
* The core plugin class that is used to define internationalization,
* admin-specific hooks, and public-facing site hooks.
*/
require plugin_dir_path( __FILE__ ) . 'includes/rtwcpiglw-class-woocommerce-pdf-invoice-generator.php';

/**
 * This function is used to check woocommerce is activated or not.
 *
 * @since    1.0.0
 * @access   public
 */
function rtwcpiglw_check_run_allows() 
{
	add_action('before_woocommerce_init', function(){

		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	
		}
	
	});
	$rtwcpiglw_status = true;
	if( function_exists('is_multisite') && is_multisite() )
	{
		include_once(ABSPATH. 'wp-admin/includes/plugin.php');
		if( !is_plugin_active('woocommerce/woocommerce.php') )
		{
			$rtwcpiglw_status = false;
		}
	}
	else
	{
		if( !in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins') ) ) )
		{
			$rtwcpiglw_status = false;
		}
	}
	return $rtwcpiglw_status;
}

if( rtwcpiglw_check_run_allows() )
{
	if( function_exists('is_multisite') && is_multisite() )
	{
		include_once(ABSPATH. 'wp-admin/includes/plugin.php');
		if( is_plugin_active('rtwwcpig-woocommerce-pdf-invoice-generator/rtwwcpig-woocommerce-pdf-invoice-generator.php') )
		{
			return;
		}
	}
	else{
		if( in_array('rtwwcpig-woocommerce-pdf-invoice-generator/rtwwcpig-woocommerce-pdf-invoice-generator.php', apply_filters('active_plugins', get_option('active_plugins'), array() ) ) )
		{
			return;
		}
	}
	//Plugin Constant
	if ( !defined( 'RTWCPIGLW_DIR' ) ) {
		define('RTWCPIGLW_DIR', plugin_dir_path( __FILE__ ) );
	}
	if ( !defined( 'RTWCPIGLW_URL' ) ) {
		define('RTWCPIGLW_URL', plugin_dir_url( __FILE__ ) );
	}
	if ( !defined( 'RTWCPIGLW_HOME' ) ) {
		define('RTWCPIGLW_HOME', home_url() );
	}
	if( !defined('RTWCPIGLW_PDF_DIR') ){
		define ('RTWCPIGLW_PDF_DIR', WP_CONTENT_DIR .'/uploads/rtwcpiglw_pdf/');
	}
	if( !defined('RTWCPIGLW_PDF_URL') ){
		define('RTWCPIGLW_PDF_URL', WP_CONTENT_URL .'/uploads/rtwcpiglw_pdf/');	
	}
	if( !defined('RTWCPIGLW_PDF_PCKNGSLP_DIR') ){
		define ('RTWCPIGLW_PDF_PCKNGSLP_DIR', WP_CONTENT_DIR .'/uploads/rtwcpiglw_pdf/rtwcpiglw_pckng_slip/');
	}
	if( !defined('RTWCPIGLW_PDF_PCKNGSLP_URL') ){
		define('RTWCPIGLW_PDF_PCKNGSLP_URL', WP_CONTENT_URL .'/uploads/rtwcpiglw_pdf/rtwcpiglw_pckng_slip/');	
	}
	if( !defined('RTWCPIGLW_PDF_SHPNGLBL_DIR') ){
		define ('RTWCPIGLW_PDF_SHPNGLBL_DIR', WP_CONTENT_DIR .'/uploads/rtwcpiglw_pdf/rtwcpiglw_shipping_label/assets/');
	}
	if( !defined('RTWCPIGLW_PDF_SHPNGLBL_URL') ){
		define('RTWCPIGLW_PDF_SHPNGLBL_URL', WP_CONTENT_URL .'/uploads/rtwcpiglw_pdf/rtwcpiglw_shipping_label/assets/');	
	}
	if( !defined('RTWCPIGLW_CREDITNOTE_DIR') ){
		define ('RTWCPIGLW_CREDITNOTE_DIR', WP_CONTENT_DIR .'/uploads/rtwcpiglw_pdf/credit_notes/');
	}
	if( !defined('RTWCPIGLW_CREDITNOTE_URL') ){
		define('RTWCPIGLW_CREDITNOTE_URL', WP_CONTENT_URL .'/uploads/rtwcpiglw_pdf/credit_notes/');	
	}

	if( !defined('RTWCPIGLW_BASEFILE_NAME') ){
		define('RTWCPIGLW_BASEFILE_NAME', plugin_basename(__FILE__) );
	}

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_run_woocommerce_pdf_invoice_generator() {

		$plugin = new rtwcpiglw_Woocommerce_Pdf_Invoice_Generator();
		$plugin->rtwcpiglw_run();

	}

	rtwcpiglw_run_woocommerce_pdf_invoice_generator();
}
else
{
	/**
	* Show plugin error notice.
	*
	* @since 1.0.0
	*/
	function rtwcpiglw_error_notice()
	{
		?>
		<div class="error notice is-dismissible">
			<p><?php esc_html_e( 'WooCommerce is not activated, Please activate WooCommerce plugin first to install WooCommerce PDF Invoice & Packing Slip Generator.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?></p>
		</div>
		<?php
	}

	/**
	* Deactivate Plugin if WooCommerce is not active
	* @since 1.0.0
	*/
	function rtwcpiglw_deactivate_woocommere_pdf_invoice_and_pkng_slp_generater()
	{
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins( plugin_basename( __FILE__ ) );

		add_action('admin_notices', 'rtwcpiglw_error_notice');
	}
	add_action( 'admin_init', 'rtwcpiglw_deactivate_woocommere_pdf_invoice_and_pkng_slp_generater' );
}