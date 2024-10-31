<?php
use Automattic\WooCommerce\Utilities\OrderUtil;
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/includes
 */
// use Automattic\WooCommerce\Utilities\OrderUtil;
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/includes
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */

 
class rtwcpiglw_Woocommerce_Pdf_Invoice_Generator {
	
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Loader    $rtwcpiglw_loader    Maintains and registers all hooks for the plugin.
	 */
	protected $rtwcpiglw_loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $rtwcpiglw_plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $rtwcpiglw_plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $rtwcpiglw_version    The current version of the plugin.
	 */
	protected $rtwcpiglw_version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'rtwcpiglw_WOOCOMMERCE_PDF_INVOICE_GENERATOR_VERSION' ) ) {
			$this->rtwcpiglw_version = rtwcpiglw_WOOCOMMERCE_PDF_INVOICE_GENERATOR_VERSION;
		} else {
			$this->rtwcpiglw_version = '1.0.0';
		}
		$this->rtwcpiglw_plugin_name = 'woocommerce-pdf-invoice-generator';

		$this->rtwcpiglw_load_dependencies();
		$this->rtwcpiglw_set_locale();
		$this->rtwcpiglw_define_admin_hooks();
		$this->rtwcpiglw_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Loader. Orchestrates the hooks of the plugin.
	 * - rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_i18n. Defines internationalization functionality.
	 * - rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Admin. Defines all hooks for the admin area.
	 * - rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rtwcpiglw_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/rtwcpiglw-class-woocommerce-pdf-invoice-generator-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/rtwcpiglw-class-woocommerce-pdf-invoice-generator-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rtwcpiglw-class-woocommerce-pdf-invoice-generator-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/rtwcpiglw-class-woocommerce-pdf-invoice-generator-public.php';

		/**
		 * The class responsible for defining general function
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/rtwcpiglw_general_function.php';

		$this->rtwcpiglw_loader = new rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rtwcpiglw_set_locale() {

		$rtwcpiglw_plugin_i18n = new rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_i18n();

		$this->rtwcpiglw_loader->rtwcpiglw_add_action( 'plugins_loaded', $rtwcpiglw_plugin_i18n, 'rtwcpiglw_load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	// use Automattic\WooCommerce\Utilities\OrderUtil;
	private function rtwcpiglw_define_admin_hooks() 
	{

		$rtwcpiglw_plugin_admin = new rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Admin( $this->rtwcpiglw_get_plugin_name(), $this->rtwcpiglw_get_version() ); 
		
		$this->rtwcpiglw_loader->rtwcpiglw_add_action( 'admin_enqueue_scripts', $rtwcpiglw_plugin_admin, 'rtwcpiglw_enqueue_styles' );
		$this->rtwcpiglw_loader->rtwcpiglw_add_action( 'admin_enqueue_scripts', $rtwcpiglw_plugin_admin, 'rtwcpiglw_enqueue_scripts' );
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('admin_menu', $rtwcpiglw_plugin_admin, 'rtwcpiglw_add_menu_page');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('admin_init', $rtwcpiglw_plugin_admin, 'rtwcpiglw_save_admin_setting');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_regnrate_invoice', $rtwcpiglw_plugin_admin, 'rtwcpiglw_regnrate_invoice');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_regnrate_shipping_lbl', $rtwcpiglw_plugin_admin, 'rtwcpiglw_regnrate_shipping_lbl');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_delete_shiping_lbl', $rtwcpiglw_plugin_admin, 'rtwcpiglw_delete_shiping_lbl');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_delete_packng_slp', $rtwcpiglw_plugin_admin, 'rtwcpiglw_delete_packng_slp');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_regnrate_packng_slp', $rtwcpiglw_plugin_admin, 'rtwcpiglw_regnrate_packng_slp');
		$this->rtwcpiglw_loader->rtwcpiglw_add_filter( 'plugin_action_links_' . RTWCPIGLW_BASEFILE_NAME, $rtwcpiglw_plugin_admin, 'rtwcpiglw_add_setting_links' );

		$this->rtwcpiglw_loader->rtwcpiglw_add_action('init', $rtwcpiglw_plugin_admin, 'rtwcpiglw_invoice_regenerate_callback');
		$rtwcpiglw_get_setting_nrml = get_option('rtwcpiglw_normal_inv_setting_opt');
		if($rtwcpiglw_get_setting_nrml && isset($rtwcpiglw_get_setting_nrml['rtwcpiglw_normal_invoice']) == 'yes' || get_option('rtwcpiglw_proforma_invoice') == 'yes')
		{ 
			$rtwcpiglw_order_status = array_unique(apply_filters('woocommerce_order_is_paid_statuses', array('processing', 'completed', 'on-hold')));

			if (!in_array('completed', $rtwcpiglw_order_status)) {
				$rtwcpiglw_order_status[] = 'completed';
			}

			foreach ($rtwcpiglw_order_status as $rtwcpiglw_ordr_istatus) 
			{
				$this->rtwcpiglw_loader->rtwcpiglw_add_action( 'woocommerce_order_status_'. $rtwcpiglw_ordr_istatus, $rtwcpiglw_plugin_admin, 'rtwcpiglw_make_invoice_on_order_status_change', '' , 2);
			}
		}
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('add_meta_boxes', $rtwcpiglw_plugin_admin, 'rtwcpiglw_add_meta_box','',2);
			
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('woocommerce_email_attachments', $rtwcpiglw_plugin_admin, 'rtwcpiglw_send_invoice_on_mail', 10 , 3);

		$this->rtwcpiglw_loader->rtwcpiglw_add_action('woocommerce_admin_order_actions', $rtwcpiglw_plugin_admin, 'rtwcpiglw_admin_pckng_slip_link', '', 2);
		// for HPOS
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('bulk_actions-woocommerce_page_wc-orders', $rtwcpiglw_plugin_admin, 'rtwcpiglw_add_bulk_action_in_orderlist_hp', 20, 1);
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_bulk_action_do', $rtwcpiglw_plugin_admin, 'rtwcpiglw_handle_bulk_hp_action');
		// without OR
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('bulk_actions-edit-shop_order', $rtwcpiglw_plugin_admin, 'rtwcpiglw_add_bulk_action_in_orderlist', 20, 1);
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('handle_bulk_actions-edit-shop_order', $rtwcpiglw_plugin_admin, 'rtwcpiglw_handle_bulk_action', '', 3);
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function rtwcpiglw_define_public_hooks() {

		$rtwcpiglw_plugin_public = new rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Public( $this->rtwcpiglw_get_plugin_name(), $this->rtwcpiglw_get_version() );

		$this->rtwcpiglw_loader->rtwcpiglw_add_action( 'wp_enqueue_scripts', $rtwcpiglw_plugin_public, 'rtwcpiglw_enqueue_styles' );
		$rtwcpiglw_get_setting_nrml = get_option('rtwcpiglw_normal_inv_setting_opt');
		if($rtwcpiglw_get_setting_nrml && isset($rtwcpiglw_get_setting_nrml['rtwcpiglw_normal_invoice']) || get_option('rtwcpiglw_proforma_invoice') == 'yes'){
			$this->rtwcpiglw_loader->rtwcpiglw_add_action('woocommerce_checkout_order_processed', $rtwcpiglw_plugin_public, 'rtwcpiglw_generate_invoice', 9 , 3);
			$this->rtwcpiglw_loader->rtwcpiglw_add_action('woocommerce_order_details_after_order_table', $rtwcpiglw_plugin_public, 'rtwcpiglw_user_invoice_link');
		}
		$rtwcpiglw_get_setting_pckng = get_option('rtwcpiglw_pkngslp_basic_stng_opt');
		if ( $rtwcpiglw_get_setting_pckng && isset($rtwcpiglw_get_setting_pckng['rtwcpiglw_enable_pkng_slp'])) {
			$this->rtwcpiglw_loader->rtwcpiglw_add_action('woocommerce_checkout_order_processed', $rtwcpiglw_plugin_public, 'rtwcpiglw_create_packng_slip', 11 , 3);
		}
		$this->rtwcpiglw_loader->rtwcpiglw_add_filter( 'rtwmer_invoice_and_packaging_slip', $rtwcpiglw_plugin_public, 'render_btn_for_mltivndr', '', 2 );
		$this->rtwcpiglw_loader->rtwcpiglw_add_filter( 'rtwmer_include_js', $rtwcpiglw_plugin_public, 'rtwcpiglw_mercado_js', 9999, 1 );
	    $this->rtwcpiglw_loader->rtwcpiglw_add_action('woocommerce_my_account_my_orders_actions', $rtwcpiglw_plugin_public, 'rtwcpiglw_orders_actions', '' , 2);   
	    $this->rtwcpiglw_loader->rtwcpiglw_add_action('init', $rtwcpiglw_plugin_public, 'rtwcpiglw_invoice_download_callback');
	    $this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_create_invoice', $rtwcpiglw_plugin_public, 'rtwcpiglw_create_invoice_cb');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_nopriv_rtwcpiglw_create_invoice', $rtwcpiglw_plugin_public, 'rtwcpiglw_create_invoice_cb');

		
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_rtwcpiglw_create_packaging', $rtwcpiglw_plugin_public, 'rtwcpiglw_create_packaging_cb');
		$this->rtwcpiglw_loader->rtwcpiglw_add_action('wp_ajax_nopriv_rtwcpiglw_create_packaging', $rtwcpiglw_plugin_public, 'rtwcpiglw_create_packaging_cb');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_run() {
		$this->rtwcpiglw_loader->rtwcpiglw_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function rtwcpiglw_get_plugin_name() {
		return $this->rtwcpiglw_plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_Pdf_Invoice_Generator_Loader    Orchestrates the hooks of the plugin.
	 */
	public function rtwcpiglw_get_loader() {
		return $this->rtwcpiglw_loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function rtwcpiglw_get_version() {
		return $this->rtwcpiglw_version;
	}



}
