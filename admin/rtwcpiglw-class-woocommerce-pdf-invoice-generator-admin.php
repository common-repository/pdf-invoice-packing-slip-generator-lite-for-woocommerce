<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    rtwcpiglw_Woocommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_Woocommerce_Pdf_Invoice_Generator/admin
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
use Automattic\WooCommerce\Utilities\OrderUtil;
class rtwcpiglw_Woocommerce_Pdf_Invoice_Generator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $rtwcpiglw_plugin_name    The ID of this plugin.
	 */
	private $rtwcpiglw_plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $rtwcpiglw_version    The current version of this plugin.
	 */
	private $rtwcpiglw_version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $rtwcpiglw_plugin_name       The name of this plugin.
	 * @param      string    $rtwcpiglw_version    The version of this plugin.
	 */
	public function __construct( $rtwcpiglw_plugin_name, $rtwcpiglw_version ) {

		$this->rtwcpiglw_plugin_name = $rtwcpiglw_plugin_name;
		$this->rtwcpiglw_version = $rtwcpiglw_version;
		
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the rtwcpiglw_run() function
		 * defined in Woocommerce_Pdf_Invoice_Generator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Pdf_Invoice_Generator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */ 

		$rtwcpiglw_screen 			= get_current_screen();
		$rtwcpiglw_screen_id 		= $rtwcpiglw_screen->id;
		$rtwcpiglw_allowed_screens 	= array(
										'woocommerce_page_rtwcpiglw-pdf-invoice-settings',
										'woocommerce_page_rtwcpiglw-pdf-packing-slip-settings',
										'woocommerce_page_rtwcpiglw-pdf-shipping-label-settings',
										'shop_order',
										'woocommerce_page_wc-orders',
										'edit-shop_order',
										'woocommerce_page_rtwcpiglw-pdf-credit-note-settings'
									);
		
		if( in_array( $rtwcpiglw_screen_id, $rtwcpiglw_allowed_screens ) )
		{
			wp_enqueue_style( $this->rtwcpiglw_plugin_name, plugin_dir_url( __FILE__ ) . 'css/rtwcpiglw-woocommerce-pdf-invoice-generator-admin.css', array(), $this->rtwcpiglw_version, 'all' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'woo-admin-css', plugins_url( 'woocommerce/assets/css/admin.css' ), array(), $this->rtwcpiglw_version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the rtwcpiglw_run() function
		 * defined in Woocommerce_Pdf_Invoice_Generator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Pdf_Invoice_Generator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$rtwcpiglw_screen = get_current_screen();
		if(isset(($_GET['page'])) && (sanitize_text_field($_GET['page']) == 'rtwcpiglw-pdf-invoice-settings' || sanitize_text_field($_GET['page']) == 'rtwcpiglw-pdf-packing-slip-settings') || $rtwcpiglw_screen->id == 'shop_order' ||$rtwcpiglw_screen->id == 'woocommerce_page_wc-orders' || $rtwcpiglw_screen->id == 'edit-shop_order' || $rtwcpiglw_screen->id == 'woocommerce_page_rtwcpiglw-pdf-shipping-label-settings' || $rtwcpiglw_screen->id == 'woocommerce_page_rtwcpiglw-pdf-credit-note-settings')
		{
			wp_enqueue_script( 'wp-color-picker');

			wp_register_script( $this->rtwcpiglw_plugin_name, plugin_dir_url( __FILE__ ) . 'js/rtwcpiglw-woocommerce-pdf-invoice-generator-admin.js', array( 'jquery', 'wp-color-picker' ), $this->rtwcpiglw_version, false );
			$rtwcpiglw_ajax_nonce = wp_create_nonce( "rtwcpiglw-ajax-security-string" );
			$rtwcpiglw_translation_array 	= array(
										'rtwcpiglw_ajaxurl' 	=> esc_url( admin_url( 'admin-ajax.php' ) ),
										'rtwcpiglw_nonce' 	=> $rtwcpiglw_ajax_nonce
									);
			wp_localize_script( $this->rtwcpiglw_plugin_name, 'rtwcpiglw_ajax_param', $rtwcpiglw_translation_array );
			wp_enqueue_script( $this->rtwcpiglw_plugin_name );

			wp_enqueue_script( "blockUI", plugins_url( 'woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js' ), array( 'jquery' ), $this->rtwcpiglw_version, false );
			wp_enqueue_script( 'jquery.validate', RTWCPIGLW_URL . 'assets/jquery/jquery.validate/jquery.validate.js', array( 'jquery' ), $this->rtwcpiglw_version, false );

			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_script( 'html2canvas', plugin_dir_url( __FILE__ ) .'js/html2canvas.js','','',true);
			wp_enqueue_script( 'tipTip', plugins_url( 'woocommerce/assets/js/jquery-tiptip/jquery.tipTip.min.js' ), array( 'jquery' ), $this->rtwcpiglw_version, false );
			
		}
	}

	/**
	 * function for add custom menu in woocommerce menu page.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_add_menu_page() {
		
		add_submenu_page( 'woocommerce', 'PDF Invoice Settings', esc_html__('PDF Invoice Settings', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), 'manage_options', 'rtwcpiglw-pdf-invoice-settings', array($this,'rtwcpiglw_pdf_invoice_settings_callback') );

		add_submenu_page( 'woocommerce', 'PDF Packing Slip', esc_html__('PDF Packing Slip', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), 'manage_options', 'rtwcpiglw-pdf-packing-slip-settings', array($this,'rtwcpiglw_pdf_packing_slip_callback') );

		add_submenu_page( 'woocommerce', 'PDF Shipping Label', esc_html__('PDF Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), 'manage_options', 'rtwcpiglw-pdf-shipping-label-settings', array($this,'rtwcpiglw_pdf_shipping_lable_callback') );

		add_submenu_page( 'woocommerce', 'PDF Credit Note', esc_html__('PDF Credit Note', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), 'manage_options', 'rtwcpiglw-pdf-credit-note-settings', array($this,'rtwcpiglw_pdf_credit_note_callback') );

	}

	/**
	 * function for display pdf invoice settings tabs on front end.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_pdf_invoice_settings_callback() {

		include_once(RTWCPIGLW_DIR.'admin/partials/rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce-admin-display.php');

	}

	/**
	 * function for display pdf packing slip settings tabs on front end.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_pdf_packing_slip_callback() {

		include_once(RTWCPIGLW_DIR.'admin/partials/rtwcpiglw-woocommerce-pdf-packing-slip-admin-display.php');

	}

	/**
	 * function for display pdf shipping lable settings tabs on front end.
	 *
	 * @since    1.2.0
	 */
	function rtwcpiglw_pdf_shipping_lable_callback() {

		include_once(RTWCPIGLW_DIR.'admin/partials/rtwcpiglw-woocommerce-pdf-shipping-lable-admin-display.php');

	}

	/**
	 * function for display pdf shipping lable settings tabs on front end.
	 *
	 * @since    1.4.0
	 */
	function rtwcpiglw_pdf_credit_note_callback() {

		include_once(RTWCPIGLW_DIR.'admin/partials/rtwcpiglw-woocommerce-pdf-credit-note-admin-display.php');

	}

	/**
	 * Adding Meta container admin shop_order pages.
	 *
	 * @since    1.0.0
	 */ 
	
	function rtwcpiglw_add_meta_box($rtwcpiglw_post_id, $rtwcpiglw_param )
	{
		
		$settings_opt = get_option('rtwcpiglw_pkngslp_basic_stng_opt');
		
		if(OrderUtil::custom_orders_table_usage_is_enabled()){
			if($rtwcpiglw_post_id == 'woocommerce_page_wc-orders'){
				
				if ( isset($settings_opt['rtwcpiglw_enable_pkng_slp']) && $settings_opt['rtwcpiglw_enable_pkng_slp'] == 1  ) 
				{
					add_meta_box( 'pdf_packing_slip', esc_html__('Generate packing Slip', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), array($this, 'rtwcpiglw_packing_slip_metabox_callback'), 'woocommerce_page_wc-orders', 'side', 'core' );
				}
				$invoic_settings_opt = get_option('rtwcpiglw_normal_inv_setting_opt');
				$proforma_settings_opt = get_option('rtwcpiglw_proforma_setting_opt');
				if($rtwcpiglw_param->get_status() == 'completed')
				{
					if (isset($invoic_settings_opt['rtwcpiglw_normal_invoice']) && $invoic_settings_opt['rtwcpiglw_normal_invoice'] == '1' )
					{
						add_meta_box( 'pdf_invoice', esc_html__('PDF Invoices', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), array($this, 'rtwcpiglw_pdf_invoice_metabox_callback'), 'woocommerce_page_wc-orders', 'side', 'core');	
					}
				}
				$shipping_settings_opt = get_option('rtwcpiglw_shipng_label_stng_opt');
				if (isset($shipping_settings_opt['rtwcpiglw_enable_shpng_lbl']) &&  $shipping_settings_opt['rtwcpiglw_enable_shpng_lbl'] == '1'  )
				{
					add_meta_box( 'pdf_shipping_label', esc_html__('Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), array($this, 'rtwcpiglw_shipping_label_metabox_callback'), 'woocommerce_page_wc-orders', 'side', 'core' );
				}
			}
		}
		else{

			global $post;
		
			if( $post->post_type == 'shop_order' )
			{
			
				$rtwcpiglw_order = wc_get_order( $rtwcpiglw_param->ID );
				if ( $settings_opt['rtwcpiglw_enable_pkng_slp'] == '1'  ) 
				{
					add_meta_box( 'pdf_packing_slip', esc_html__('Generate packing Slip', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), array($this, 'rtwcpiglw_packing_slip_metabox_callback'), 'shop_order', 'side', 'core' );
				}
				$invoic_settings_opt = get_option('rtwcpiglw_normal_inv_setting_opt');
				$proforma_settings_opt = get_option('rtwcpiglw_proforma_setting_opt');
				if($rtwcpiglw_order->get_status() == 'completed')
				{
					if (isset($invoic_settings_opt['rtwcpiglw_normal_invoice']) && $invoic_settings_opt['rtwcpiglw_normal_invoice'] == '1' )
					{
						add_meta_box( 'pdf_invoice', esc_html__('PDF Invoices', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), array($this, 'rtwcpiglw_pdf_invoice_metabox_callback'), 'shop_order', 'side', 'core');	
					}
				}
				$shipping_settings_opt = get_option('rtwcpiglw_shipng_label_stng_opt');
				if (isset($shipping_settings_opt['rtwcpiglw_enable_shpng_lbl']) &&  $shipping_settings_opt['rtwcpiglw_enable_shpng_lbl'] == '1'  )
				{
					add_meta_box( 'pdf_shipping_label', esc_html__('Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'), array($this, 'rtwcpiglw_shipping_label_metabox_callback'), 'shop_order', 'side', 'core' );
				}
			}
			
			
		}
	}

	/**
	 * Adding Meta field in the meta container admin shop_order pages.
	 *
	 * @since    1.0.0
	 */

	function rtwcpiglw_pdf_invoice_metabox_callback($post)
	{
		include(RTWCPIGLW_DIR.'admin/partials/rtwcpiglw_html/rtwcpiglw_render_invoice_btn.php');
	}

	/**
	 * Adding Meta field in the meta container for shipping label in admin shop_order pages.
	 *
	 * @since    1.2.0
	 */

	function rtwcpiglw_shipping_label_metabox_callback($post)
	{
		include(RTWCPIGLW_DIR.'admin/partials/rtwcpiglw_html/rtwcpiglw_render_shipping_label_btn.php');
	}

	/**
	 * Adding Meta field in the meta container for packing slip in admin shop_order pages.
	 *
	 * @since    1.2.1
	 */

	function rtwcpiglw_packing_slip_metabox_callback($post)
	{
		include(RTWCPIGLW_DIR.'admin/partials/rtwcpiglw_html/rtwcpiglw_render_packing_slip_btn.php');
	}

	/*
	* Function to show settings link
	*/
	function rtwcpiglw_add_setting_links( $rtwcpiglw_links ){
		$rtwcpiglw_links[] = '<a href="' . esc_url(admin_url( 'admin.php?page=rtwcpiglw-pdf-invoice-settings' )) . '">'.esc_html__( 'Invoice Settings', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ).'</a>';
		$rtwcpiglw_links[] = '<a href="' . esc_url(admin_url( 'admin.php?page=rtwcpiglw-pdf-packing-slip-settings' )) . '">'.esc_html__( 'Packing Slip Settings', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ).'</a>';
		return $rtwcpiglw_links;
	} 
	/*
	* function to download PDF Invoice.
	*/
	function rtwcpiglw_invoice_regenerate_callback()
	{
		if( isset( $_GET[ 'rtwcpiglw_order_id' ] ))
		{
			$pdf_name_option = get_option( 'rtwcpiglw_basic_setting_opt' );
			if ( isset($pdf_name_option) && $pdf_name_option['rtwcpiglw_custm_pdf_name'] != '') {
				$pdf_name = $pdf_name_option['rtwcpiglw_custm_pdf_name'];
			}else{
				$pdf_name = 'rtwcpiglw_';
			}
			$rtwcpiglw_file_name = $pdf_name.sanitize_text_field($_GET[ 'rtwcpiglw_order_id' ]).'.pdf';
			$rtwcpiglw_file_url 	= RTWCPIGLW_PDF_DIR.'/'. $rtwcpiglw_file_name;
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"".$rtwcpiglw_file_name."\""); 
			readfile( $rtwcpiglw_file_url );
			exit;
		}
	}

	/**
	 * Save admin settings.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_save_admin_setting()
	{

		register_setting('rtwcpiglw_header_setting','rtwcpiglw_header_setting_opt');
		register_setting('rtwcpiglw_pckngslp_header_setting','rtwcpiglw_pkngslp_header_stng_opt');
		register_setting('rtwcpiglw_pckngslp_basic_setting','rtwcpiglw_pkngslp_basic_stng_opt');
		register_setting('rtwcpiglw_footer_setting','rtwcpiglw_footer_setting_opt');
		register_setting('rtwcpiglw_basic_setting','rtwcpiglw_basic_setting_opt');
		register_setting('rtwcpiglw_css_setting','rtwcpiglw_css_setting_opt');
		register_setting('rtwcpiglw_watermark_setting','rtwcpiglw_watermark_setting_opt');
		register_setting('rtwcpiglw_prodct_tax_setting','rtwcpiglw_prodct_tax_setting_opt');
		register_setting('rtwcpiglw_proforma_setting','rtwcpiglw_proforma_setting_opt');
		register_setting('rtwcpiglw_normal_inv_setting','rtwcpiglw_normal_inv_setting_opt');

	}

	/**
	 * function for send email with invoice to the admin.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_send_invoice_on_mail($rtwcpiglw_atchmnt, $rtwcpiglw_mail_type, $rtwcpiglw_ordr_obj)
	{
		if (!isset($rtwcpiglw_mail_type) || !is_object($rtwcpiglw_ordr_obj) || !is_a($rtwcpiglw_ordr_obj, 'WC_Order')) 
		{
			return $rtwcpiglw_atchmnt;
		}

		$order_id = $rtwcpiglw_ordr_obj->get_id();

		$rtwcpiglw_normal_invoice   = false;
		$rtwcpiglw_proforma_invoice  = false;
		$pdf_name_option = get_option( 'rtwcpiglw_basic_setting_opt' );
		if ( isset($pdf_name_option) && $pdf_name_option['rtwcpiglw_custm_pdf_name'] != '') {
			$pdf_name = $pdf_name_option['rtwcpiglw_custm_pdf_name'];
		}else{
			$pdf_name = 'rtwcpiglw_';
		}
		$rtwcpiglw_dir = RTWCPIGLW_PDF_DIR.$pdf_name.$order_id.'.pdf';

		if ($rtwcpiglw_mail_type == 'customer_refunded_order') 
		{
			$credit_note = RTWCPIGLW_CREDITNOTE_DIR.'credi-note-'.$order_id.'.pdf';
			if (file_exists($credit_note))
			{
				$rtwcpiglw_credit_note = true;
			}
		}

		if ($rtwcpiglw_mail_type == 'customer_invoice') 
		{
			if (get_option('rtwcpiglw_regular_invoice') == 'yes') 
			{
				if (file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_normal_invoice = true;
				}
			}
			if (get_option('rtwcpiglw_proforma_invoice') == 'yes') 
			{
				if (file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_proforma_invoice = true;
				}
			}
		}
		else if ($rtwcpiglw_mail_type == 'customer_on_hold_order') 
		{
			if (get_option('rtwcpiglw_proforma_invoice') == 'yes' && get_option('rtwcpiglw_attchd_profrma_ordr_mail') == 'yes' )
			{
				if (file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_proforma_invoice = true;
				}
			}
		}
		else if ($rtwcpiglw_mail_type == 'customer_processing_order')
		{
			if (get_option('rtwcpiglw_regular_invoice') == 'yes' && get_option('rtwcpiglw_atchd_ordr_mail') == 'yes')
			{
				if(file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_normal_invoice = true;
				}
			}
			if (get_option('rtwcpiglw_proforma_invoice') == 'yes' && get_option('rtwcpiglw_attchd_ordr_mail') == 'yes') 
			{
				if (file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_proforma_invoice = true;
				}
			}
		}
		else if ($rtwcpiglw_mail_type == 'customer_completed_order')
		{
			if (get_option('rtwcpiglw_rtwcpiglw_regular_invoice') == 'yes' && get_option('rtwcpiglw_atchd_ordr_mail') == 'yes')
			{
				if (file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_normal_invoice = true;
				}
			}
		}
		else if ($rtwcpiglw_mail_type == 'new_order')
		{
			if (get_option('rtwcpiglw_proforma_invoice') == 'yes' && get_option('rtwcpiglw_attchd_ordr_mail') == 'yes')
			{
				if (file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_proforma_invoice = true;
				}
			}
		}
		else if ($rtwcpiglw_mail_type == 'partial_payment') 
		{
			if (get_option('rtwcpiglw_proforma_invoice') == 'yes')
			{
				if (file_exists($rtwcpiglw_dir))
				{
					$rtwcpiglw_proforma_invoice = true;
				}
			}
		}
		if ($rtwcpiglw_proforma_invoice = true)
		{

			if (!file_exists($rtwcpiglw_dir)){

				return $rtwcpiglw_atchmnt;
			}

			if (is_string($rtwcpiglw_atchmnt) && empty($rtwcpiglw_atchmnt)){

				$rtwcpiglw_atchmnt = $rtwcpiglw_dir;
			}

			if (is_string($rtwcpiglw_atchmnt) && !empty($rtwcpiglw_atchmnt)){

				$rtwcpiglw_atchmnt .= PHP_EOL . $rtwcpiglw_dir;
			}

			if (is_array($rtwcpiglw_atchmnt)){

				array_push($rtwcpiglw_atchmnt, $rtwcpiglw_dir);
			}

			return $rtwcpiglw_atchmnt ;
		}
		if ($rtwcpiglw_normal_invoice = true)
		{

			if (empty($rtwcpiglw_dir)){

				return $rtwcpiglw_atchmnt;
			}

			if (is_string($rtwcpiglw_atchmnt) && empty($rtwcpiglw_atchmnt)){

				$rtwcpiglw_atchmnt = $rtwcpiglw_dir;
			}

			if (is_string($rtwcpiglw_atchmnt) && !empty($rtwcpiglw_atchmnt)){

				$rtwcpiglw_atchmnt .= PHP_EOL . $rtwcpiglw_dir;
			}

			if (is_array($rtwcpiglw_atchmnt)){

				array_push($rtwcpiglw_atchmnt, $rtwcpiglw_dir);
			}

			return $rtwcpiglw_atchmnt ;
		}
		if ( $rtwcpiglw_credit_note == true ) 
		{
			if (empty($credit_note)){

				return $rtwcpiglw_atchmnt;
			}

			if (is_string($rtwcpiglw_atchmnt) && empty($rtwcpiglw_atchmnt)){

				$rtwcpiglw_atchmnt = $credit_note;
			}

			if (is_string($rtwcpiglw_atchmnt) && !empty($rtwcpiglw_atchmnt)){

				$rtwcpiglw_atchmnt .= PHP_EOL . $credit_note;
			}

			if (is_array($rtwcpiglw_atchmnt)){

				array_push($rtwcpiglw_atchmnt, $credit_note);
			}

			return $rtwcpiglw_atchmnt ;
		}
	}

    /**
	 * function for provide download packing slip link in order list page.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_admin_pckng_slip_link($rtwcpiglw_actn, $rtwcpiglw_odr)
    {
    	$packing_slp_setting = get_option('rtwcpiglw_pkngslp_basic_stng_opt');
		if (!$rtwcpiglw_odr) {
			return $rtwcpiglw_actn;
		}

		if ( !isset($packing_slp_setting['rtwcpiglw_download_pkng_slp']) || $packing_slp_setting['rtwcpiglw_download_pkng_slp'] != '1' ) {
			return $rtwcpiglw_actn;
		}		
		$rtwcpiglw_pckng_slip = RTWCPIGLW_PDF_PCKNGSLP_URL.'rtwcpiglw_'.$rtwcpiglw_odr->get_id().'.pdf';
		$rtwcpiglw_pckng_slp = RTWCPIGLW_PDF_PCKNGSLP_DIR.'rtwcpiglw_'.$rtwcpiglw_odr->get_id().'.pdf';
		if (file_exists($rtwcpiglw_pckng_slp)) 
		{
			$rtwcpiglw_dwnld_pckngslp_btn = '<a id="rtwcpiglw_img_btn" class="rtw_btn" href="'.esc_url($rtwcpiglw_pckng_slip).'" data-tip="'.esc_attr__('Download Packing Slip', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce').'" download>' .
			'<img src="'.esc_url(RTWCPIGLW_URL.'assets/pckng.png').'"  height="22px;" width="22px;" alt="'.esc_attr__('Packing Slip', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce').'"></a>';
			/** This is for displaying the button **/
			echo $rtwcpiglw_dwnld_pckngslp_btn;
		}
		$shipping_opt = get_option('rtwcpiglw_shipng_label_stng_opt');
		if ( isset($shipping_opt['rtwcpiglw_enable_shpng_lbl']) == '1' && isset($shipping_opt['rtwcpiglw_download_shpng_lbl']) == '1' ) 
		{
			$rtwcpiglw_shipping = RTWCPIGLW_PDF_DIR.'rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_odr->get_id().'.pdf';
			$rtwcpiglw_pckng_slp = RTWCPIGLW_PDF_URL.'rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_odr->get_id().'.pdf';
			if (file_exists($rtwcpiglw_shipping)) 
			{
				$rtwcpiglw_dwnld_pckngslp_btn = '<a id="rtwcpiglw_img_btn" class="rtw_btn" href="'.esc_url($rtwcpiglw_pckng_slp).'" data-tip="'.esc_attr__('Download Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce').'" download>' .
				'<img src="'.esc_url(RTWCPIGLW_URL.'assets/imagess.png').'" height="22px;" width="22px;" alt="'.esc_attr__('Packing Slip', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce').'"></a>';
				/** This is for displaying the button **/
				echo $rtwcpiglw_dwnld_pckngslp_btn;
			}
		}
		return $rtwcpiglw_actn;
	}

	/**
	 * function for regenerate pdf invoice when order status is changed.
	 *
	 * @since    1.0.0
	 */
	public function rtwcpiglw_make_invoice_on_order_status_change($rtwcpiglw_odr_id, $rtwcpiglw_odr_objct)
    {
    	$rtwcpiglw_pdf_invoice = rtwcpiglw_make_invoice($rtwcpiglw_odr_id, $rtwcpiglw_odr_objct);
    }

	/**
	 * function for add custom bulk action into woocoomerce action.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_add_bulk_action_in_orderlist($rtwcpiglw_bulk_action)
	{
		$rtwcpiglw_bulk_action['bulk_pdf_invoice'] = esc_html__( 'Download Invoice', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' );
		return $rtwcpiglw_bulk_action;
	}

	function rtwcpiglw_add_bulk_action_in_orderlist_hp($rtwcpiglw_bulk_action)
	{
		$rtwcpiglw_bulk_action['bulk_pdf_invoice_hp'] = esc_html__( 'Download Invoice', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' );
		return $rtwcpiglw_bulk_action;
	}

	/**
	 * function for handel custom bulk action.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_handle_bulk_action($rtwcpiglw_redirect, $rtwcpiglw_action, $rtwcpiglw_post_ids)
	{
		if ($rtwcpiglw_action == 'bulk_pdf_invoice') 
		{
			if ( class_exists('ZipArchive') ) 
			{
				$pdf_name_option = get_option( 'rtwcpiglw_basic_setting_opt' );
				if ( isset($pdf_name_option) && $pdf_name_option['rtwcpiglw_custm_pdf_name'] != '') {
					$pdf_name = $pdf_name_option['rtwcpiglw_custm_pdf_name'];
				}else{
					$pdf_name = 'rtwcpiglw_';
				}
				$rtwcpiglw_output = ob_get_contents();
				ob_clean();
				$rtwcpiglw_zip = new ZipArchive;
				$rtwcpiglw_archive_file_name = $pdf_name.time().'.zip';

				if ($rtwcpiglw_zip->open($rtwcpiglw_archive_file_name, ZipArchive::CREATE) === TRUE) 
				{
					foreach ($rtwcpiglw_post_ids as $rtwcpiglw_key => $rtwcpiglw_value) 
					{
						$rtwcpiglw_file = RTWCPIGLW_PDF_DIR.$pdf_name.$rtwcpiglw_value.'.pdf';
						if (file_exists($rtwcpiglw_file)) {
							$rtwcpiglw_zip->addFile($rtwcpiglw_file, 'rtwcpiglw_pdf_zip/'.$rtwcpiglw_value);
						}else{
							$invoice_text = "PDF Invoice Does not Exist for Order No : ".$rtwcpiglw_value.", Please unselect This Order.";
							esc_html_e( $invoice_text, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' );
							die();
						}
					}	
				}

				$rtwcpiglw_zip->close();
				header("Content-type: application/zip");
				header("Content-Disposition: attachment; filename=".$rtwcpiglw_archive_file_name);
				header("Content-length: " . filesize($rtwcpiglw_archive_file_name));
				header("Pragma: no-cache"); 
				header("Expires: 0"); 
				readfile($rtwcpiglw_archive_file_name);
				unlink($rtwcpiglw_archive_file_name);
				exit();
			}
		}

	}
	// for bulk if hpos

	function rtwcpiglw_handle_bulk_hp_action()
	{
		$rtwcpiglw_action = $_POST['rtwcpiglw_action'];
		$rtwcpiglw_arr_order_id = $_POST['rtwcpiglw_arr_order_id'];
		
			$rtwcpiglw_redirect = admin_url().'admin.php?page=wc-orders';
			
			if ($rtwcpiglw_action == 'bulk_pdf_invoice_hp') 
			{
				if ( class_exists('ZipArchive') ) 
				{
					$pdf_name_option = get_option( 'rtwcpiglw_basic_setting_opt' );
					if ( isset($pdf_name_option) && $pdf_name_option['rtwcpiglw_custm_pdf_name'] != '') {
						$pdf_name = $pdf_name_option['rtwcpiglw_custm_pdf_name'];
					}else{
						$pdf_name = 'rtwcpiglw_';
					}
					$rtwcpiglw_output = ob_get_contents();
					ob_clean();
					$rtwcpiglw_zip = new ZipArchive;

					$fodldr_path = RTWCPIGLW_PDF_DIR."rtwcpiglw_zip_bulk";
					if ( !is_dir ( $fodldr_path ) ) 
					{
						mkdir ( $fodldr_path , 0755, true );
					}

					$rtwcpiglw_archive_file_name = $fodldr_path.'/'.$pdf_name.'bulki_invoices'.'.zip';

					if(file_exists($rtwcpiglw_archive_file_name)){
						unlink($rtwcpiglw_archive_file_name);
					}
					
					if ($rtwcpiglw_zip->open($rtwcpiglw_archive_file_name, ZipArchive::CREATE) === TRUE) 
					{
						
						foreach ($rtwcpiglw_arr_order_id as $rtwcpiglw_key => $rtwcpiglw_value) 
						{
							$rtwcpiglw_file = RTWCPIGLW_PDF_DIR.$pdf_name.$rtwcpiglw_value.'.pdf';
							if (file_exists($rtwcpiglw_file)) {
								$rtwcpiglw_zip->addFile($rtwcpiglw_file, $rtwcpiglw_value.'.pdf');
							}
							else{
								$invoice_text = "PDF Invoice Does not Exist for Order No : ".$rtwcpiglw_value.", Please unselect This Order.";
								esc_html_e( $invoice_text, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' );
								die();
							}
						}	
					}
					$rtwcpiglw_permalink = RTWCPIGLW_PDF_URL."rtwcpiglw_zip_bulk/".$pdf_name.'bulki_invoices'.'.zip';
					$rtwcpiglw_zip->close();
					 echo json_encode( array( 'rtwcpiglw_status' => true, 'rtwcpiglw_parmalink' =>$rtwcpiglw_permalink));
					 die;
				}
			}
			
		
	}
	/**
	 * function for regenerate deleted pdf invoice.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_regnrate_invoice()
	{
		$rtwcpiglw_check_ajax = check_ajax_referer( 'rtwcpiglw-ajax-security-string', 'rtwcpiglw_security_check' );

		if ( $rtwcpiglw_check_ajax ) 
		{
			$rtwcpiglw_ordr_id = sanitize_text_field($_POST[ 'order_id' ]);
			$rtwcpiglw_ordr_obj = wc_get_order( $rtwcpiglw_ordr_id );
			$rtwcpiglw_regenrate_invoice = rtwcpiglw_make_invoice($rtwcpiglw_ordr_id, $rtwcpiglw_ordr_obj);
			if (!empty($rtwcpiglw_regenrate_invoice)) 
			{
				echo json_encode( array( 'rtwcpiglw_status' => true, 'rtwcpiglw_message' => esc_html__( 'Successfully Regenerated', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
				die;
			}
			else
			{
				echo json_encode( array( 'rtwcpiglw_status' => false, 'rtwcpiglw_message' => esc_html__( 'Something Went Wrong', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
				die;
			}
		}
	}

	/**
	 * function for regenerate deleted shipping label.
	 *
	 * @since    1.2.0
	 */
	function rtwcpiglw_regnrate_shipping_lbl()
	{
		$rtwcpiglw_check_ajax = check_ajax_referer( 'rtwcpiglw-ajax-security-string', 'rtwcpiglw_security' );
		if ( $rtwcpiglw_check_ajax ) 
		{
			$rtwcpiglw_ordr_id = sanitize_text_field($_POST[ 'order_id' ]);
			$rtwcpiglw_ordr_obj = wc_get_order( $rtwcpiglw_ordr_id );
			$rtwcpiglw_regenrate_shipng_lbl = $this->rtwcpiglw_make_shipping_lable($rtwcpiglw_ordr_id, $rtwcpiglw_ordr_obj);
			if (!empty($rtwcpiglw_regenrate_shipng_lbl)) 
			{
				echo json_encode( array( 'rtwcpiglw_status' => true, 'rtwcpiglw_message' => esc_html__( 'Successfully Regenerated', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
				die;
			}
			else
			{
				echo json_encode( array( 'rtwcpiglw_status' => false, 'rtwcpiglw_message' => esc_html__( 'Something Went Wrong', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
				die;
			}
		}
	}

	/**
	 * function for regenerate deleted packind slip.
	 *
	 * @since    1.2.1
	 */
	function rtwcpiglw_regnrate_packng_slp()
	{
		$rtwcpiglw_check_ajax = check_ajax_referer( 'rtwcpiglw-ajax-security-string', 'rtwcpiglw_security' );
		if ( $rtwcpiglw_check_ajax ) 
		{
			$rtwcpiglw_ordr_id = sanitize_text_field($_POST[ 'order_id' ]);
			$rtwcpiglw_ordr_obj = wc_get_order( $rtwcpiglw_ordr_id );
			$rtwcpiglw_regenrate_shipng_lbl = $this->rtwcpiglw_create_packng_slip($rtwcpiglw_ordr_id, $rtwcpiglw_ordr_obj);
			if (!empty($rtwcpiglw_regenrate_shipng_lbl)) 
			{
				echo json_encode( array( 'rtwcpiglw_status' => true, 'rtwcpiglw_message' => esc_html__( 'Successfully Regenerated', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
				die;
			}
			else
			{
				echo json_encode( array( 'rtwcpiglw_status' => false, 'rtwcpiglw_message' => esc_html__( 'Something Went Wrong', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
				die;
			}
		}
	}

	/**
	 * callback function for regenerate deleted shipping label.
	 *
	 * @since    1.2.0
	 */
	public function rtwcpiglw_make_shipping_lable( $rtwcpiglw_ordr_id, $rtwcpiglw_ordr_obj )
	{
		$rtwcpiglw_order = wc_get_order( $rtwcpiglw_ordr_id );
		if ( !$rtwcpiglw_order ) {
			$rtwcpiglw_order = $rtwcpiglw_ordr_obj;
		}
		$rtwcpiglw_order_data = $rtwcpiglw_order->get_data();
		$rtwcpiglw_user_email = $rtwcpiglw_order->get_billing_email();
		$rtwcpiglw_shpng_total = $rtwcpiglw_order->get_shipping_total();
		$rtwcpiglw_shipping_tax   = $rtwcpiglw_order->get_shipping_tax();
		

		$rtwcpiglw_product_qty = array();
					
		foreach( $rtwcpiglw_order->get_items() as $rtwcpiglw_item_key => $rtwcpiglw_item_values )
		{ 
			
			$prod_sku = new WC_Product($rtwcpiglw_item_values->get_product_id());
			      
			if ( rtwcpiglw_woo_product_bundled_compatibility() ) 
			{  
				if ( $prod_sku->get_sku() ) 
				{
					$rtwcpiglw_product_id[] = $rtwcpiglw_item_values->get_product_id();
					
					if ( in_array($rtwcpiglw_item_values->get_name(), $rtwcpiglw_product_qty) ) {
						$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name().' - '] = $rtwcpiglw_item_values->get_quantity();
					}else{
						$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
					}
					$prod_qty[] = $rtwcpiglw_item_values->get_quantity();
					$rtwcpiglw_total_amnt[] = $rtwcpiglw_item_values->get_total();
					$rtwcpiglw_total_line_amnt[] = $rtwcpiglw_order->get_formatted_line_subtotal( $rtwcpiglw_item_values );
					$rtwcpiglw_tax_class[] = $rtwcpiglw_item_values->get_tax_class(); // Tax class

		    		$rtwcpiglw_subtotal_tax[] = $rtwcpiglw_item_values->get_subtotal_tax(); // Line item name

		    		$rtwcpiglw_total_tax[] = $rtwcpiglw_item_values->get_total_tax(); // Tax rate code

		    		$rtwcpiglw_taxes_array[] = $rtwcpiglw_item_values->get_taxes(); 

		    		$rtwcpiglw_prduct_vrtion_id = $rtwcpiglw_item_values->get_variation_id();

		    		if ($rtwcpiglw_prduct_vrtion_id){

		    			$rtwcpiglw_prduct = new WC_Product_Variation($rtwcpiglw_item_values->get_variation_id());

		    		}else{

		    			$rtwcpiglw_prduct = new WC_Product($rtwcpiglw_item_values->get_product_id());
		    		}
		    		if ( $rtwcpiglw_prduct->get_sku() ) {
		    			$rtwcpiglw_sku[] = $rtwcpiglw_prduct->get_sku();
		    		}
				}
			}
			else
			{ 
				
				$rtwcpiglw_product_id[] = $rtwcpiglw_item_values->get_product_id();
				if ( in_array($rtwcpiglw_item_values->get_name(), $rtwcpiglw_product_qty) ) {
					$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name().' - '] = $rtwcpiglw_item_values->get_quantity();
				}else{
					$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
				}
				$rtwcpiglw_total_amnt[] = $rtwcpiglw_item_values->get_total();
				$rtwcpiglw_total_line_amnt[] = $rtwcpiglw_order->get_formatted_line_subtotal( $rtwcpiglw_item_values );
				$rtwcpiglw_tax_class[] = $rtwcpiglw_item_values->get_tax_class(); // Tax class

	    		$rtwcpiglw_subtotal_tax[] = $rtwcpiglw_item_values->get_subtotal_tax(); // Line item name

	    		$rtwcpiglw_total_tax[] = $rtwcpiglw_item_values->get_total_tax(); // Tax rate code

	    		$rtwcpiglw_taxes_array[] = $rtwcpiglw_item_values->get_taxes(); 

	    		$rtwcpiglw_prduct_vrtion_id = $rtwcpiglw_item_values->get_variation_id();

	    		if ($rtwcpiglw_prduct_vrtion_id){

	    			$rtwcpiglw_prduct = new WC_Product_Variation($rtwcpiglw_item_values->get_variation_id());

	    		}else{

	    			$rtwcpiglw_prduct = new WC_Product($rtwcpiglw_item_values->get_product_id());
	    		}
	    		if ( $rtwcpiglw_prduct->get_sku() ) {
	    			$rtwcpiglw_sku[] = $rtwcpiglw_prduct->get_sku();
	    		}
			}
    	}
		     
    	if ($rtwcpiglw_product_id != '') 
		{
			
			foreach ($rtwcpiglw_product_id as $rtwcpiglw_k => $rtwcpiglw_v) 
			{
				$rtwcpiglw_pro = new WC_Product( $rtwcpiglw_v );
				$product_weight[] = $rtwcpiglw_pro->get_weight();
				
			}
		
		}
    	if ($rtwcpiglw_order->get_items( 'tax' ) != '') 
    	{
    		foreach ($rtwcpiglw_order->get_items( 'tax' ) as $rtwcpiglw_key => $rtwcpiglw_value) 
    		{
				$rtwcpiglw_item_type = $rtwcpiglw_value->get_type(); // Line item type
			    $rtwcpiglw_item_name = $rtwcpiglw_value->get_name(); // Line item name
			    $rtwcpiglw_rate_code = $rtwcpiglw_value->get_rate_code(); // Tax rate code
			    $rtwcpiglw_tax_rate_label = $rtwcpiglw_value->get_label(); // Tax label
			    $rtwcpiglw_tax_rate_id = $rtwcpiglw_value->get_rate_id(); // Tax rate ID
			    $rtwcpiglw_compound = $rtwcpiglw_value->get_compound(); // Tax compound
			    $rtwcpiglw_tax_amount_total = $rtwcpiglw_value->get_tax_total(); // Tax rate total
			    $rtwcpiglw_tax_shipping_total[] = $rtwcpiglw_value->get_shipping_tax_total();
			}
		}
				
		$rtwcpiglw_data = array();
		if ( !empty($product_weight) ) 
		{
			
			$total = 0;
			foreach ($product_weight as $k => $v) {
				$total = $total+(int)$v;
			}
		
			$rtwcpiglw_data['total_weight'] = $total;
		}
		$meta = $rtwcpiglw_order->get_meta('_wctmw_tracking');
		$rtwcpiglw_data['tracking_no'] = '';
		if (!empty($meta)) {
			foreach ($meta as $k => $v) {
				$rtwcpiglw_data['tracking_no'] = $v['tracking_number'];
			}
			
		}
	
		
		if (!empty($prod_qty)) 
		{
			
			$count = 0;
			$total_weight = 0;
			foreach ($prod_qty as $key => $value) 
			{
				if ( $product_weight[$count] != '' ) {
					$total_weight = ($total_weight + ($value * $product_weight[$count]));
				}else{
					$total_weight = ($total_weight + ($value * 0));
				}
				$count++;
			}
			$rtwcpiglw_data['total_weight'] = $total_weight;
		}
		
		
		$rtwcpiglw_data['store_address_1'] = get_option( 'woocommerce_store_address' );
		$rtwcpiglw_data['store_address_2'] = get_option( 'woocommerce_store_address_2' );
		$rtwcpiglw_data['store_city'] = get_option( 'woocommerce_store_city' );
		$rtwcpiglw_data['store_postcode'] = get_option( 'woocommerce_store_postcode' );
		$rtwcpiglw_data['store_country'] = WC()->countries->countries[$rtwcpiglw_order->get_shipping_country()];
		$rtwcpiglw_data['seller_name'] = get_option( 'woocommerce_store_address' );
		$rtwcpiglw_data['shipping_method'] =	$rtwcpiglw_ordr_obj->get_shipping_method();
		$rtwcpiglw_data['shipping_first_name'] =	$rtwcpiglw_ordr_obj->get_shipping_first_name();
		$rtwcpiglw_data['shipping_last_name'] = $rtwcpiglw_ordr_obj->get_shipping_last_name();
		$rtwcpiglw_data['shipping_company'] = $rtwcpiglw_ordr_obj->get_shipping_company();
		$rtwcpiglw_data['shipping_address_1'] = $rtwcpiglw_ordr_obj->get_shipping_address_1();
		$rtwcpiglw_data['shipping_address_2'] = $rtwcpiglw_ordr_obj->get_shipping_address_2();
		$rtwcpiglw_data['shipping_city'] = $rtwcpiglw_ordr_obj->get_shipping_city();
		$rtwcpiglw_data['shipping_state'] = $rtwcpiglw_ordr_obj->get_shipping_state();
		$rtwcpiglw_data['shipping_postcode'] = $rtwcpiglw_ordr_obj->get_shipping_postcode();
		$rtwcpiglw_data['shipping_country'] = $rtwcpiglw_ordr_obj->get_shipping_country();
		$rtwcpiglw_data['order_id'] = $rtwcpiglw_ordr_id;
		$rtwcpiglw_data['billing_first_name'] = $rtwcpiglw_ordr_obj->get_billing_first_name();
		$rtwcpiglw_data['billing_email'] = $rtwcpiglw_ordr_obj->get_billing_email();
		$rtwcpiglw_data['billing_last_name'] = $rtwcpiglw_ordr_obj->get_billing_last_name();
		$rtwcpiglw_data['billing_address_1'] = $rtwcpiglw_ordr_obj->get_billing_address_1();
		$rtwcpiglw_data['billing_address_2'] = $rtwcpiglw_ordr_obj->get_billing_address_2();
		$rtwcpiglw_data['billing_city'] = $rtwcpiglw_ordr_obj->get_billing_city();
		$rtwcpiglw_data['billing_state'] = $rtwcpiglw_ordr_obj->get_billing_state();
		$rtwcpiglw_data['billing_postcode'] = $rtwcpiglw_ordr_obj->get_billing_postcode();
		$rtwcpiglw_data['billing_country'] = $rtwcpiglw_ordr_obj->get_billing_country();
		$rtwcpiglw_data['payment_method'] = $rtwcpiglw_ordr_obj->get_payment_method_title();
		$rtwcpiglw_data['customer_note'] = $rtwcpiglw_ordr_obj->get_customer_note();
		$amount_sign = get_option('woocommerce_currency');
		$rtwcpiglw_data['order_amount'] = wc_price( $rtwcpiglw_ordr_obj->get_total() );
		$rtwcpiglw_data['billing_company'] = $rtwcpiglw_ordr_obj->get_billing_company();
		$rtwcpiglw_data['billing_phone'] = $rtwcpiglw_ordr_obj->get_billing_phone();
		   
		if(rtwcpiglw_woo_seq_order_no_compatibility())
		{
			
			$rtwcpiglw_data['order_id'] = (string) apply_filters( 'woocommerce_order_number', $rtwcpiglw_ordr_id , $rtwcpiglw_ordr_obj);
		}
		else
		{
			
			$rtwcpiglw_data['order_id'] = $rtwcpiglw_ordr_id;
		}
		$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_tax_amount_total;
		$rtwcpiglw_data['order_date'] = $rtwcpiglw_order_data['date_created']->date('d/m/Y');
		$rtwcpiglw_data['subtotal_amount'] = ( $rtwcpiglw_ordr_obj->get_total() - $rtwcpiglw_ordr_obj->get_total_tax() );
		$rtwcpiglw_data['line_no'] = 1;
		
		
		if(!empty($rtwcpiglw_tax_rate_id))
		{
			$rtwcpiglw_tax_rates = WC_Tax::_get_tax_rate( $rtwcpiglw_tax_rate_id );
			if (!empty($rtwcpiglw_tax_rates)) 
			{
				$rtwcpiglw_tax_rate = $rtwcpiglw_tax_rates['tax_rate'];
			}
			
		}
		else
		{
			$rtwcpiglw_tax_rate = '0.00%';
		}
		

		if ($rtwcpiglw_product_id != '') 
		{
			
			foreach ($rtwcpiglw_product_id as $rtwcpiglw_k => $rtwcpiglw_v) 
			{
				$rtwcpiglw_product[] = wc_get_product( $rtwcpiglw_v );
				$rtwcpiglw_excerpt[] = get_the_excerpt( $rtwcpiglw_v );
				$rtwcpiglw_pro = new WC_Product( $rtwcpiglw_v ); 
				$rtwcpiglw_price[] = $rtwcpiglw_pro->get_price();
				$rtwcpiglw_term_list = wp_get_post_terms($rtwcpiglw_v,'product_cat',array('fields'=>'all'));
				$rtwcpiglw_cat_id = $rtwcpiglw_term_list[0];
				$rtwcpiglw_cat_name[] = $rtwcpiglw_term_list[0]->name;
				$rtwcpiglw_cat[] = get_term_link ($rtwcpiglw_cat_id, 'product_cat');
			
			}
		}
		if ($rtwcpiglw_order->get_items() != '') {
			foreach( $rtwcpiglw_order->get_items() as $rtwcpiglw_item_id => $rtwcpiglw_item ) {
				$rtwcpiglw_product = apply_filters( 'woocommerce_order_item_product', $rtwcpiglw_order->get_product_from_item( $rtwcpiglw_item ), $rtwcpiglw_item );
				if ( $rtwcpiglw_product->get_variation_id() ) {
					$rtwcpiglw_product = new WC_Product_Variation($rtwcpiglw_item_values->get_variation_id());
					if ( $rtwcpiglw_product->get_image() ) {
						$rtwcpiglw_prdct_img[] = $rtwcpiglw_product->get_image(array( $width,$height ));
					}
				}else{
					if ( $rtwcpiglw_product->get_image() ) {
						$rtwcpiglw_prdct_img[] = $rtwcpiglw_product->get_image(array( $width,$height ));
					}
				}
			}
			
		}

		$rtwcpiglw_shipping_lbl = get_option( 'rtwcpiglw_shipping_format');
		
		if($rtwcpiglw_shipping_lbl == '')
		{
			$rtwcpiglw_shipping_lbl = '<div style="max-width: 1170px; margin: 0 auto; padding: 30px 0; box-sizing: border-box;">
			<table style="width: 650px; border-collapse: collapse; margin: 0 auto; font-family: Helvetica; border: 1px solid #dddddd; box-sizing: border-box;">
			<thead>
			<tr>
			<th style="border: 1px solid #dddddd; width: 100px; box-sizing: border-box;" rowspan="3"> </th>
			</tr>
			<tr>
			<th style="border: 1px solid #dddddd; font-size: 13px; padding: 5px 3px; box-sizing: border-box;" colspan="2">RTW Logistics</th>
			</tr>
			<tr>
			<th style="border: 1px solid #dddddd; text-transform: uppercase; font-size: 18px; font-weight: bold; padding: 5px 3px; box-sizing: border-box;">PrePaid</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			<td style="border: 1px solid #dddddd; padding: 20px; width: 50%; box-sizing: border-box;">
			
			</td>
			<td style="border: 1px solid #dddddd; width: 50%; padding: 20px; box-sizing: border-box;">
			<p style="font-size: 25px; font-weight: bold; margin: 0; line-height: 22px; padding-bottom: 10px; box-sizing: border-box;">Return Address</p>
			<p style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">RedefiningTheWeb 100 MAIN ST. SEATTLE WA,98104, USA</p>
			<p style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">Phone: 987-654-032</p>
			<p style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">E-mail: developer@redefiningtheweb.com</p>
			</td>
			</tr>
			<tr>
			<td style="border: 1px solid #dddddd; padding: 20px; box-sizing: border-box;">
			<div style="margin: 0; line-height: 22px; font-size: 19px; font-weight: bold; box-sizing: border-box;">Shipping Customer Address</div>
			<div style="font-size: 13px; margin: 0; line-height: 22px box-sizing: border-box;">[shipping_first_name] [shipping_last_name]</div>
			<div style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">[shipping_address_1] , [shipping_address_2]</div>
			<div style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">[shipping_city] , [shipping_state]</div>
			<div style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">[shipping_postcode] , [shipping_country]</div>
			</td>
			<td style="border: 1px solid #dddddd; padding: 20px; box-sizing: border-box;">
			
			</td>
			</tr>
			<tr>
			<td colspan="4">
			<table style="width: 100%; border-collapse: collapse; box-sizing: border-box;">
			<thead>
			<tr>
			<th style="border: 1px solid #dddddd; font-family: Helvetica; font-size: 13px; padding: 5px; box-sizing: border-box;">Sr. No.</th>
			<th style="border: 1px solid #dddddd; font-family: Helvetica; font-size: 13px; padding: 5px; box-sizing: border-box;">Seller Name</th>
			<th style="border: 1px solid #dddddd; font-family: Helvetica; font-size: 13px; padding: 5px; box-sizing: border-box;">Date</th>
			<th style="border: 1px solid #dddddd; font-family: Helvetica; font-size: 13px; padding: 5px; box-sizing: border-box;">Order Number</th>
			<th style="border: 1px solid #dddddd; font-family: Helvetica; font-size: 13px; padding: 5px; box-sizing: border-box;">Order Amount</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			<td style="border: 1px solid #dddddd; font-size: 13px; padding: 5px; box-sizing: border-box;">1</td>
			<td style="border: 1px solid #dddddd; font-size: 13px; padding: 5px; box-sizing: border-box;">[seller_name]</td>
			<td style="border: 1px solid #dddddd; font-size: 13px; padding: 5px; box-sizing: border-box;">[order_date]</td>
			<td style="border: 1px solid #dddddd; font-size: 13px; padding: 5px; box-sizing: border-box;">[order_id]</td>
			<td style="border: 1px solid #dddddd; font-size: 13px; padding: 5px; box-sizing: border-box;">[order_amount]</td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>
			</tbody>
			</table>
			</div>';
		}
	
		$rtwcpiglw_shipping_lbl = stripcslashes($rtwcpiglw_shipping_lbl);
	     	

		$rtwcpiglw_qr_cntnt = get_option('rtwcpiglw_qr_code_content');
		   
		$str = '';
		foreach ($rtwcpiglw_data as $k => $val) 
		{
			if ( strpos($rtwcpiglw_qr_cntnt, '['.$k.']') !== false ) {
				if ( $val != '' ) 
				{
					$str.= '<p>'.$val.'</p>';
				}
			}
		}

		if( $rtwcpiglw_qr_cntnt == '' ){
			$qr_text = '<table><thead><tr><th>Order No.</th><th>Customer Name</th><th>Order Total</th></tr></thead><tbody><tr><td>'.$rtwcpiglw_ordr_id.'</td><td>'.$rtwcpiglw_ordr_obj->get_billing_first_name().' '.$rtwcpiglw_ordr_obj->get_billing_last_name().'</td><<td>'.$rtwcpiglw_ordr_obj->get_total().'</td>/tr></tbody></table>';
		}else{
			$qr_text = $str;
		}

		$rtwcpiglw_barcode_cntnt = get_option('rtwcpiglw_bar_code_content');
		$rtwcpiglw_barcode_cntnt = do_shortcode( $rtwcpiglw_barcode_cntnt );
		if( $rtwcpiglw_barcode_cntnt != '' ){
			$text = '';
			foreach ($rtwcpiglw_data as $k => $val) 
			{
				if ( strpos($rtwcpiglw_barcode_cntnt, '['.$k.']') !== false ) {
					if ( $val != '' ) 
					{
						$text.= '<p>'.$val.'</p>';
					}
				}
			}
		}else{
			$text = '<table><thead><tr><th>Order No.</th><th>Customer Name</th><th>Order Total</th></tr></thead><tbody><tr><td>'.$rtwcpiglw_ordr_id.'</td><td>'.$rtwcpiglw_ordr_obj->get_billing_first_name().' '.$rtwcpiglw_ordr_obj->get_billing_last_name().'</td><<td>'.$rtwcpiglw_ordr_obj->get_total().'</td>/tr></tbody></table>';
		}
	

		if ( !is_dir ( RTWCPIGLW_PDF_SHPNGLBL_DIR ) ) 
		{
			mkdir ( RTWCPIGLW_PDF_SHPNGLBL_DIR, 0755, true );
		}
		
		if ( $rtwcpiglw_shipping_lbl != '' ) 
		{
			
			if ( !empty( $rtwcpiglw_data ) ) 
			{
				foreach ($rtwcpiglw_data as $rtwcpiglw_key => $rtwcpiglw_val) 
				{
					
					$rtwcpiglw_shipping_lbl = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_shipping_lbl);
				}
			}
			
			
		}

		$rtwcpiglw_pro_desc = 'Shipping_label';
		$rtwcpiglw_regenrate_shpng_lbl = rtwcpiglw_convert_to_pdf($rtwcpiglw_shipping_lbl, $rtwcpiglw_ordr_id, $rtwcpiglw_user_email,$rtwcpiglw_pro_desc);
		if (is_array($rtwcpiglw_regenrate_shpng_lbl) && !empty($rtwcpiglw_regenrate_shpng_lbl)) 
		{
			echo json_encode( array( 'rtwcpiglw_status' => true, 'rtwcpiglw_message' => esc_html__( 'Successfully Regenerated', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
			die;
		}
		else
		{
			echo json_encode( array( 'rtwcpiglw_status' => false, 'rtwcpiglw_message' => esc_html__( 'Something Went Wrong', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ) ) );
			die;
		}
	}

	/**
	 * function for create packing slip for an order.
	 *
	 * @since    1.0.0
	 */
	function rtwcpiglw_create_packng_slip($rtwcpiglw_ordr_no,$rtwcpiglw_ordr_obj)
	{
		$rtwcpiglw_pkngslp_pdf = rtwcpiglw_create_pdf_packngslip($rtwcpiglw_ordr_no,$rtwcpiglw_ordr_obj);
	}
}
