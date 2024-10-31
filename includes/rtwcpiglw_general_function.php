<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
} 

/**
 * checking woocommerce sequential order number plugin is activated or not.
 *
 * @since    1.3.0
 */
function rtwcpiglw_woo_seq_order_no_compatibility(){
  
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  if ( is_plugin_active( 'woocommerce-sequential-order-numbers/woocommerce-sequential-order-numbers.php' ) || is_plugin_active( 'woocommerce-sequential-order-numbers-pro/woocommerce-sequential-order-numbers-pro.php' ) )
  {
    return true;
  }else{
    return false;
  }
}
/**
 * checking woocommerce product bundel plugin is activated or not.
 *
 * @since    2.0.0
 */
function rtwcpiglw_woo_product_bundled_compatibility(){
  
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  if ( is_plugin_active( 'woocommerce-product-bundles/woocommerce-product-bundles.php' ) )
  {
    return true;
  }else{
    return false;
  }
}

/**
 * function for regenerate pdf invoice when order status is changed.
 *
 * @since    1.0.0
 */
function rtwcpiglw_make_invoice($rtwcpiglw_odr_id, $rtwcpiglw_odr_objct)
{

	$rtwcpiglw_stng = array();
	$rtwcpiglw_basic_stng = get_option('rtwcpiglw_basic_setting_opt');
	if( !$rtwcpiglw_basic_stng )
	{
		$rtwcpiglw_basic_stng = array();
	}
	$rtwcpiglw_css_stng = get_option('rtwcpiglw_css_setting_opt');
	if( !$rtwcpiglw_css_stng )
	{
		$rtwcpiglw_css_stng = array();
	}
	$rtwcpiglw_prdct_tax_stng = get_option('rtwcpiglw_prodct_tax_setting_opt');
	if( !$rtwcpiglw_prdct_tax_stng )
	{
		$rtwcpiglw_prdct_tax_stng = array();
	}
	$rtwcpiglw_header_stng = get_option('rtwcpiglw_header_setting_opt');
	if( !$rtwcpiglw_header_stng )
	{
		$rtwcpiglw_header_stng = array();
	}
	$rtwcpiglw_footer_stng = get_option('rtwcpiglw_footer_setting_opt');
	if( !$rtwcpiglw_footer_stng )
	{
		$rtwcpiglw_footer_stng = array();
	}
	$rtwcpiglw_watermark_stng = get_option('rtwcpiglw_watermark_setting_opt');
	if( !$rtwcpiglw_watermark_stng )
	{
		$rtwcpiglw_watermark_stng = array();
	}
	$rtwcpiglw_invoice_format_stng = get_option('rtwcpiglw_invoice_format_setting_opt');
	if( !$rtwcpiglw_invoice_format_stng )
	{
		$rtwcpiglw_invoice_format_stng = array();
	}
	$rtwcpiglw_stng = array_merge($rtwcpiglw_basic_stng,$rtwcpiglw_prdct_tax_stng,$rtwcpiglw_css_stng,$rtwcpiglw_header_stng,$rtwcpiglw_footer_stng,$rtwcpiglw_watermark_stng);

	if(rtwcpiglw_woo_seq_order_no_compatibility())
	{
		$rtwcpiglw_odr_id = (string) apply_filters( 'woocommerce_order_number', $rtwcpiglw_odr_id , $rtwcpiglw_odr_objct);
	}

	$status = get_option( 'rtwcpiglw_when_gnrate_invoice' , array() );
	if ( $status == '' ) {
		$status = 'processing';
	}
	$tax_name = array();

	if( $rtwcpiglw_odr_objct->get_status() == $status || $rtwcpiglw_odr_objct->get_status() == 'completed')
	{	
		
		$rtwcpiglw_currency_symbol = get_option('woocommerce_currency');
		
	
		
		$rtwcpiglw_order = wc_get_order( $rtwcpiglw_odr_id );
		$currency_code = $rtwcpiglw_order->get_currency();
		define('CURRENCY', $currency_code);
		
		if ( !$rtwcpiglw_order ) {
			$rtwcpiglw_order = $rtwcpiglw_odr_objct;
		}
		$rtwcpiglw_order_data   = $rtwcpiglw_order->get_data();
		$rtwcpiglw_user_email   = $rtwcpiglw_order->get_billing_email();
		$rtwcpiglw_shpng_total  = $rtwcpiglw_order->get_shipping_total();

		$rtwcpiglw_shpng_amnt   = '';
		$rtwcpiglw_total_discount = $rtwcpiglw_order->get_discount_total();

    	foreach( $rtwcpiglw_order->get_items('fee') as $item_id => $item_fee )
    	{
		    $fee_total[] = $item_fee->get_total();
			}
		$rtwcpiglw_product_qty = array();
		foreach( $rtwcpiglw_order->get_items() as $rtwcpiglw_item_key => $rtwcpiglw_item_values )
		{
			$prod_sku = new WC_Product($rtwcpiglw_item_values->get_product_id());
			if ( rtwcpiglw_woo_product_bundled_compatibility() ) 
			{
				if ( $prod_sku->get_sku() ) 
				{
					$rtwcpiglw_product_id[] = $rtwcpiglw_item_values->get_product_id();
					if ( !array_key_exists($rtwcpiglw_item_values->get_name(), $rtwcpiglw_product_qty) ) {
						$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
					}else{
						$rtwcpiglw_product_qty[' '.$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
					}
					$rtwcpiglw_total_amnt[] = $rtwcpiglw_item_values->get_total();
					$rtwcpiglw_prodct_price[] = ( $rtwcpiglw_item_values->get_total()/$rtwcpiglw_item_values->get_quantity() );
					$rtwcpiglw_subtotal_amnt[] = $rtwcpiglw_item_values->get_subtotal();
					$rtwcpiglw_total_line_amnt[] = $rtwcpiglw_order->get_formatted_line_subtotal( $rtwcpiglw_item_values );
					$rtwcpiglw_tax_class = $rtwcpiglw_item_values->get_tax_class(); // Tax class
					if ( $rtwcpiglw_tax_class !== '' ) {
						$tax_obj = WC_Tax::get_rates_for_tax_class( $rtwcpiglw_tax_class );
						foreach($tax_obj as $k => $val){
							$rtwcpiglw_standrd_rate = WC_Tax::get_rate_percent( $k );
							$rtwcpiglw_standrd_label = WC_Tax::get_rate_label( $k );
						}				
						$tax_name[] = $rtwcpiglw_standrd_label.' ('.$rtwcpiglw_standrd_rate.' )';
					}else{
						$rtwcpiglw_prod_data = $rtwcpiglw_item_values->get_product();
						if( $rtwcpiglw_prod_data->tax_status == 'taxable' ){
							$rtwcpiglw_standrd_rate = WC_Tax::get_rate_percent( 1 );
							$rtwcpiglw_standrd_label = WC_Tax::get_rate_label( 1 );
							$tax_name[] = $rtwcpiglw_standrd_label.' ('.$rtwcpiglw_standrd_rate.' )';
						}else{
							$tax_name[] = "0.00 %";
						}
					}
		    		$rtwcpiglw_subtotal_tax[] = $rtwcpiglw_item_values->get_subtotal_tax(); 
		    		$rtwcpiglw_total_tax[] = $rtwcpiglw_item_values->get_total_tax();
		    		$rtwcpiglw_taxes_array = $rtwcpiglw_item_values->get_taxes();
		    		$rtwcpiglw_prduct_vrtion_id = $rtwcpiglw_item_values->get_variation_id();
		    		if ($rtwcpiglw_prduct_vrtion_id){
		    			$rtwcpiglw_prduct = new WC_Product_Variation($rtwcpiglw_item_values->get_variation_id());
		    		}else{
		    			$rtwcpiglw_prduct = new WC_Product($rtwcpiglw_item_values->get_product_id());
		    		}
		    		$rtwcpiglw_sku[] = $rtwcpiglw_prduct->get_sku();
				}
			}
			else
			{
				$rtwcpiglw_product_id[] = $rtwcpiglw_item_values->get_product_id();
				$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
				$rtwcpiglw_total_amnt[] = $rtwcpiglw_item_values->get_total();
				$rtwcpiglw_prodct_price[] = ( $rtwcpiglw_item_values->get_total()/$rtwcpiglw_item_values->get_quantity() );
				$rtwcpiglw_subtotal_amnt[] = $rtwcpiglw_item_values->get_subtotal();
				$rtwcpiglw_total_line_amnt[] = $rtwcpiglw_order->get_formatted_line_subtotal( $rtwcpiglw_item_values );
				$rtwcpiglw_tax_class = $rtwcpiglw_item_values->get_tax_class(); // Tax class
				if ( $rtwcpiglw_tax_class !== '' ) {
					$tax_obj = WC_Tax::get_rates_for_tax_class( $rtwcpiglw_tax_class );
					foreach($tax_obj as $k => $val){
						$rtwcpiglw_standrd_rate = WC_Tax::get_rate_percent( $k );
						$rtwcpiglw_standrd_label = WC_Tax::get_rate_label( $k );
					}				
					$tax_name[] = $rtwcpiglw_standrd_label.' ('.$rtwcpiglw_standrd_rate.' )';
				}else{
					$rtwcpiglw_prod_data = $rtwcpiglw_item_values->get_product();
					if( $rtwcpiglw_prod_data->tax_status == 'taxable' ){
						$rtwcpiglw_standrd_rate = WC_Tax::get_rate_percent( 1 );
						$rtwcpiglw_standrd_label = WC_Tax::get_rate_label( 1 );
						$tax_name[] = $rtwcpiglw_standrd_label.' ('.$rtwcpiglw_standrd_rate.' )';
					}else{
						$tax_name[] = "0.00 %";
					}
				}
	    		$rtwcpiglw_subtotal_tax[] = $rtwcpiglw_item_values->get_subtotal_tax(); 
	    		$rtwcpiglw_total_tax[] = $rtwcpiglw_item_values->get_total_tax();
	    		$rtwcpiglw_taxes_array = $rtwcpiglw_item_values->get_taxes();
	    		$rtwcpiglw_prduct_vrtion_id = $rtwcpiglw_item_values->get_variation_id();
	    		if ($rtwcpiglw_prduct_vrtion_id){
	    			$rtwcpiglw_prduct = new WC_Product_Variation($rtwcpiglw_item_values->get_variation_id());
	    		}else{
	    			$rtwcpiglw_prduct = new WC_Product($rtwcpiglw_item_values->get_product_id());
	    		}
	    		$rtwcpiglw_sku[] = $rtwcpiglw_prduct->get_sku();
			}
		}
    	if (!empty($fee_total)) {
			$totalfee = 0;
			foreach ($fee_total as $k => $v) {
				$totalfee = $totalfee + $v;
			}
			$rtwcpiglw_data['processing_fees'] = $rtwcpiglw_currency_symbol.' '.wc_format_decimal($totalfee,2);
		}else{
			$rtwcpiglw_data['processing_fees'] = $rtwcpiglw_currency_symbol.' 0.00';
		}
		$rtwcpiglw_data['store_address_1'] = get_option( 'woocommerce_store_address' );
		$rtwcpiglw_data['store_address_2'] = get_option( 'woocommerce_store_address_2' );
		$rtwcpiglw_data['store_city'] = get_option( 'woocommerce_store_city' );
		$rtwcpiglw_data['store_postcode'] = get_option( 'woocommerce_store_postcode' );
		$rtwcpiglw_data['store_country'] = WC()->countries->get_base_country();
		$rtwcpiglw_data['shipping_method'] =	$rtwcpiglw_odr_objct->get_shipping_method();
		$rtwcpiglw_data['shipping_first_name'] =	$rtwcpiglw_odr_objct->get_shipping_first_name();
		if( $rtwcpiglw_data['shipping_first_name'] == '' )
		{
			$rtwcpiglw_data['shipping_first_name'] = $rtwcpiglw_odr_objct->get_billing_first_name();
		}
		$rtwcpiglw_data['shipping_last_name'] = $rtwcpiglw_odr_objct->get_shipping_last_name();
		if( $rtwcpiglw_data['shipping_last_name'] == '' )
		{
			$rtwcpiglw_data['shipping_last_name'] = $rtwcpiglw_odr_objct->get_billing_last_name();
		}
		$rtwcpiglw_data['shipping_company'] = $rtwcpiglw_odr_objct->get_shipping_company();
		if( $rtwcpiglw_data['shipping_company'] == '' )
		{
			$rtwcpiglw_data['shipping_company'] = $rtwcpiglw_odr_objct->get_billing_company();
		}
		$rtwcpiglw_data['shipping_address_1'] = $rtwcpiglw_odr_objct->get_shipping_address_1();
		if( $rtwcpiglw_data['shipping_address_1'] == '' )
		{
			$rtwcpiglw_data['shipping_address_1'] = $rtwcpiglw_odr_objct->get_billing_address_1();
		}
		$rtwcpiglw_data['shipping_address_2'] = $rtwcpiglw_odr_objct->get_shipping_address_2();
		if( $rtwcpiglw_data['shipping_address_2'] == '' )
		{
			$rtwcpiglw_data['shipping_address_2'] = $rtwcpiglw_odr_objct->get_billing_address_2();
		}
		$rtwcpiglw_data['shipping_city'] = $rtwcpiglw_odr_objct->get_shipping_city();
		if( $rtwcpiglw_data['shipping_city'] == '' )
		{
			$rtwcpiglw_data['shipping_city'] = $rtwcpiglw_odr_objct->get_billing_city();
		}
		$rtwcpiglw_data['shipping_state'] = $rtwcpiglw_odr_objct->get_shipping_state();
		if( $rtwcpiglw_data['shipping_state'] == '' )
		{
			$rtwcpiglw_data['shipping_state'] = $rtwcpiglw_odr_objct->get_billing_state();
		}
		$rtwcpiglw_data['shipping_postcode'] = $rtwcpiglw_odr_objct->get_shipping_postcode();
		if( $rtwcpiglw_data['shipping_postcode'] == '' )
		{
			$rtwcpiglw_data['shipping_postcode'] = $rtwcpiglw_odr_objct->get_billing_postcode();
		}
		$rtwcpiglw_data['shipping_country'] = $rtwcpiglw_odr_objct->get_shipping_country();
		if( $rtwcpiglw_data['shipping_country'] == '' )
		{
			$rtwcpiglw_data['shipping_country'] = $rtwcpiglw_odr_objct->get_billing_country();
		}

		$rtwcpiglw_data['billing_first_name'] = $rtwcpiglw_odr_objct->get_billing_first_name();
		$rtwcpiglw_data['billing_email'] = $rtwcpiglw_odr_objct->get_billing_email();
		$rtwcpiglw_data['billing_last_name'] = $rtwcpiglw_odr_objct->get_billing_last_name();
		$rtwcpiglw_data['billing_address_1'] = $rtwcpiglw_odr_objct->get_billing_address_1();
		$rtwcpiglw_data['billing_address_2'] = $rtwcpiglw_odr_objct->get_billing_address_2();
		$rtwcpiglw_data['billing_city'] = $rtwcpiglw_odr_objct->get_billing_city();
		$rtwcpiglw_data['billing_state'] = $rtwcpiglw_odr_objct->get_billing_state();
		$rtwcpiglw_data['billing_postcode'] = $rtwcpiglw_odr_objct->get_billing_postcode();
		$rtwcpiglw_data['billing_country'] = $rtwcpiglw_odr_objct->get_billing_country();
		$rtwcpiglw_data['order_amount'] = $rtwcpiglw_odr_objct->get_total();
		$rtwcpiglw_data['billing_company'] = $rtwcpiglw_odr_objct->get_billing_company();
		$rtwcpiglw_data['billing_phone'] = $rtwcpiglw_odr_objct->get_billing_phone();
		$rtwcpiglw_data['payment_method'] = $rtwcpiglw_odr_objct->get_payment_method_title();
		$rtwcpiglw_data['order_id'] = $rtwcpiglw_odr_id;
		$rtwcpiglw_data['order_date'] = $rtwcpiglw_order_data['date_created']->date('d/m/Y');
		$rtwcpiglw_data['order_time'] = $rtwcpiglw_order_data['date_created']->date('h:i:s');
		$rtwcpiglw_data['customer_note'] = $rtwcpiglw_odr_objct->get_customer_note();
		$rtwcpiglw_data['total_discount'] = $rtwcpiglw_odr_objct->get_total_discount();

		if ( $rtwcpiglw_shpng_amnt == '' ) {
			$rtwcpiglw_shpng_amnt = 0.00;
		}
		if ( $rtwcpiglw_odr_objct->get_total_tax() == '' ) {
			$get_total_tax = 0.00;
		}else{
			$get_total_tax = $rtwcpiglw_odr_objct->get_total_tax();
		}
		$rtwcpiglw_data['subtotal_amount'] = $rtwcpiglw_odr_objct->get_subtotal();
   
		if ($rtwcpiglw_product_id != '') 
		{
			foreach ($rtwcpiglw_product_id as $rtwcpiglw_k => $rtwcpiglw_v) 
			{
				$rtwcpiglw_pro = new WC_Product( $rtwcpiglw_v );
				$price_exclude_tax = wc_get_price_excluding_tax( $rtwcpiglw_pro );
				$price_incl_tax = wc_get_price_including_tax( $rtwcpiglw_pro );
				$tax_amount[]     = ($price_incl_tax - $price_exclude_tax);
				$rtwcpiglw_price[] = $rtwcpiglw_pro->get_price();
				$rtwcpiglw_regular_price[] = $rtwcpiglw_pro->get_regular_price();
				if(!empty($rtwcpiglw_pro->get_sale_price())){
					$rtwcpiglw_sale_price[] = $rtwcpiglw_pro->get_sale_price();
				}else{
					$rtwcpiglw_sale_price[] = 0.00;
				}
				$rtwcpiglw_term_list = wp_get_post_terms($rtwcpiglw_v,'product_cat',array('fields'=>'all'));
				$rtwcpiglw_cat_id = $rtwcpiglw_term_list[0];
				$rtwcpiglw_cat_name[] = $rtwcpiglw_term_list[0]->name;
				$rtwcpiglw_cat[] = get_term_link ($rtwcpiglw_cat_id, 'product_cat');
			}
		}

		$width = get_option('rtwcpiglw_prod_img_width');
		$height = get_option('rtwcpiglw_prod_img_height');
		if ( $width == '' ) {
			$width = 50;
		}
		if ( $height == '' ) {
			$height = 50;
		}
		if ($rtwcpiglw_order->get_items() != '') {
			foreach( $rtwcpiglw_order->get_items() as $rtwcpiglw_item_id => $rtwcpiglw_item ) {
				$rtwcpiglw_product = apply_filters( 'woocommerce_order_item_product', $rtwcpiglw_order->get_product_from_item( $rtwcpiglw_item ), $rtwcpiglw_item );
				if ( $rtwcpiglw_product ) {
					$rtwcpiglw_prdct_img[] = $rtwcpiglw_product->get_image(array( $width,$height ));
				}
			}
		}
		$rtwcpiglw_nmbrng_mthd = get_option('rtwcpiglw_nmbrng_method');
		$currency_symbol = get_option('woocommerce_currency');

		if($rtwcpiglw_nmbrng_mthd != '')
		{
			if( $rtwcpiglw_odr_objct->get_status() == 'completed' )
			{
				if ($rtwcpiglw_nmbrng_mthd == 'intrnl_suf_pre') 
				{
					$rtwcpiglw_nxt_nmbr = get_option('rtwcpiglw_nxt_nmbr');
					$rtwcpiglw_prefix = get_option('rtwcpiglw_prefix');
					$rtwcpiglw_suffix = get_option('rtwcpiglw_suffix');
					if ( strpos($rtwcpiglw_prefix, 'day') !== false ) {
						$rtwcpiglw_prefix = date('D');
					}else if( strpos($rtwcpiglw_prefix, 'year') !== false ){
						$rtwcpiglw_prefix = date('Y');
					}else if( strpos($rtwcpiglw_prefix, 'month') !== false ){
						$rtwcpiglw_prefix = date('m');
					}

					if ( strpos($rtwcpiglw_suffix, 'day') !== false ) {
						$rtwcpiglw_suffix = date('D');
					}else if( strpos($rtwcpiglw_suffix, 'year') !== false ){
						$rtwcpiglw_suffix = date('Y');
					}else if( strpos($rtwcpiglw_suffix, 'month') !== false ){
						$rtwcpiglw_suffix = date('m');
					}
					
					if ($rtwcpiglw_nxt_nmbr != '') 
					{
						$rtwcpiglw_options = ( $rtwcpiglw_nxt_nmbr +1 );
						$rtwcpiglw_data['order_id'] = $rtwcpiglw_prefix.$rtwcpiglw_nxt_nmbr.$rtwcpiglw_suffix;
					}
					else
					{
						$rtwcpiglw_options = 0;
						$rtwcpiglw_data['order_id'] = $rtwcpiglw_prefix.'0'.$rtwcpiglw_suffix;
					}
					update_option( 'rtwcpiglw_nxt_nmbr', $rtwcpiglw_options );
				}
				else if($rtwcpiglw_nmbrng_mthd == 'ordr_suf_pre')
				{
					$rtwcpiglw_prefix = $rtwcpiglw_stng['prefix'];
					$rtwcpiglw_suffix = $rtwcpiglw_stng['suffix'];
					$rtwcpiglw_data['order_id'] = $rtwcpiglw_prefix.$rtwcpiglw_odr_id.$rtwcpiglw_suffix;
				}
				else
				{
					$rtwcpiglw_data['order_id'] = $rtwcpiglw_odr_id;
				} 
			}
			else
			{
				$rtwcpiglw_data['order_id'] = $rtwcpiglw_odr_id;
			}
		}
		else
		{
			$rtwcpiglw_data['order_id'] = $rtwcpiglw_odr_id;
		}

		if (! class_exists ( 'simple_html_dom_node' )) 
		{
			require_once (RTWCPIGLW_DIR .'/includes/simplehtmldom/simple_html_dom.php');
		}

		$rtwcpiglw_invoice = get_option( 'rtwcpiglw_invoice_format_setting_opt' );
		$rtwcpiglw_invoice = apply_filters( 'rtwcpiglw_invoice_format_option', $rtwcpiglw_invoice , $rtwcpiglw_odr_id);

		$rtwcpiglw_invoice_temp = isset($rtwcpiglw_invoice['invoice_template']) ? $rtwcpiglw_invoice['invoice_template'] : '4';

		if( $rtwcpiglw_invoice_temp == '4' )
		{

			$rtwcpiglw_invoice_format = stripcslashes($rtwcpiglw_invoice['invoice_format_4']);
			if ( $rtwcpiglw_invoice_format == '' ) 
			{
				$rtwcpiglw_invoice_format = get_option( 'rtwcpiglw_invoice_format_setting_opt' );
				
				$rtwcpiglw_invoice_format = $rtwcpiglw_invoice_format['invoice_format'];
				if($rtwcpiglw_invoice_format=='')
				{
					$rtwcpiglw_invoice_format = '<table class="invhead" style="width: 100%; font-size: 14px; border: none;">
					<tbody>
					<tr>
					<td style="width: 40%; border: none;">
					<div class="rtwcpig-logo" style="width: 29%; display: inline-block;"><img class="alignnone" style="margin-bottom: 15px;" alt="shop logo" width="100" height="100" /></div>
					<p style="margin: 5px 0;">Invoice No: [order_id]</p>
					<p style="margin: 5px 0;">Invoice Date: [order_date]</p>
					</td>
					<td style="width: 60%; border: none;">
					<div style="width: 69%; display: inline-block;">
					<p style="margin: 5px 5px 5px 0px;"><strong>RedefiningTheWeb</strong></p>
					<p style="margin: 5px 5px 5px 0px;">100 MAIN ST. SEATTLE WA,98104, USA</p>
					<p style="margin: 5px 5px 5px 0px;">www.redefiningtheweb.com</p>
					<p style="margin: 5px 5px 5px 0px;">Phone: 987-654-032</p>
					<p style="margin: 5px 5px 5px 0px;">E-mail: developer@redefiningtheweb.com</p>
					</div>
					</td>
					</tr>
					</tbody>
					</table>
					<div> </div>
					<div class="rtwcpig-invoice-wrapper"><br />
					<table style="width: 100%; border-collapse: collapse; border: 1px solid #b08c77; font-size: 13px;">
					<thead>
					<tr>
					<th>
					<p style="color: #777777; font-weight: bold; margin: 5px 5px 5px 0px; text-align: left;">Shipping Address</p>
					</th>
					<th style="border-left: 1px solid #b08c77;">
					<p style="color: #777777; font-weight: bold; margin: 5px 5px 5px 0px; text-align: left;">Billing Address</p>
					</th>
					</tr>
					</thead>
					<tbody>
					<tr style="border-bottom: none;">
					<td style="width: 50%; border-bottom: none;">
					<p>[shipping_first_name] [shipping_last_name]</p>
					<p>[shipping_address_1] , [shipping_address_2], [shipping_city], [shipping_state], [shipping_country], [shipping_postcode]</p>
					</td>
					<td style="width: 50%; border-bottom: none; border-left: 1px solid #b08c77;">
					<p style="margin: 5px 0;">[billing_first_name] [billing_last_name]</p>
					<p style="margin: 5px 0;">[billing_address_1] , [billing_address_2], [billing_city], [billing_state], [billing_country], [billing_postcode]</p>
					<p style="margin: 5px 0;">[billing_email]</p>
					<p>[billing_phone]</p>
					</td>
					</tr>
					</tbody>
					</table>
					</div>
					<div style="margin-top: 40px; color: #444444;">
					<table id="rtwcpiglw_prod_table" style="width: 100%; border-collapse: collapse; font-size: 13px; border: 1px solid #b08c77;">
					<thead>
					<tr>
					<th style="width: 100px; padding: 15px 10px; text-align: left; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Line No.</th>
					<th style="width: 200px; padding: 15px 10px; text-align: left; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Product</th>
					<th style="width: 100px; text-align: center; padding: 15px 10px; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Price</th>
					<th style="width: 100px; text-align: center; padding: 15px 10px; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Quantity</th>
					<th style="width: 100px; text-align: center; padding: 15px 10px; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Tax Rate</th>
					<th style="width: 100px; text-align: center; padding: 15px 10px; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Discount</th>
					<th style="width: 100px; text-align: center; padding: 15px 10px; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Tax Amount</th>
					<th style="width: 100px; text-align: center; padding: 15px 10px; border-bottom: 2px solid #dddddd; border-top: 2px solid #dddddd; background-color: #b08c77; color: #f5fffa;">Line Total</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td style="padding: 10px; border-bottom: 2px solid #dddddd; text-align: left; color: #444444;">[line_number]</td>
					<td style="padding: 10px; border-bottom: 2px solid #dddddd; text-align: left; color: #444444;">[product_name][product_img]</td>
					<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[product_price]</td>
					<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[product_qty]</td>
					<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[tax_rate]</td>
					<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[discount]</td>
					<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[tax_amount]</td>
					<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[line_total]</td>
					</tr>
					</tbody>
					</table>
					</div>
					<div class="rtwcpig-subtotal-wrapper" style="float: right; text-align: right;">
					<div style="width: 60%; float: right;">
					<table style="float: right; width: 100%; border-collapse: collapse; margin-top: 50px; font-size: 13px; border: 1px solid #b08c77;">
					<tbody>
					<tr>
					<th style="color: #f5fffa; background-color: #b08c77; padding: 10px; text-align: center; border-top: 2px solid #dddddd; border-bottom: 2px solid #dddddd;" colspan="2">Invoice Summary</th>
					</tr>
					<tr>
					<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>SubTotal</strong></td>
					<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[subtotal_amount]</td>
					</tr>
					<tr>
					<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Tax</strong></td>
					<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[row_tax_amount]</td>
					</tr>
					<tr>
					<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Shipping Charges</strong></td>
					<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[shipping_charges]</td>
					</tr>
					<tr>
					<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Total</strong></td>
					<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[order_amount]</td>
					</tr>
					<tr>
					<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Payment Method</strong></td>
					<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[payment_method]</td>
					</tr>
					<tr style="border-bottom: none;">
					<td style="width: 170px; padding: 10px 5px; text-align: left; border-bottom: none; color: #444444;"><strong>Amount In Words</strong></td>
					<td style="padding: 10px 5px; text-align: left; border-bottom: none; color: #444444;">[total_amnt_in_words]</td>
					</tr>
					</tbody>
					</table>
					</div>
					</div>
					<div style="width: 100%; float: left; font-size: 11px;"><hr />
					<p>Terms &amp; Conditions:</p>
					<ol>
					<li>Goods once sold can be exchanged within 7 days of delivery.</li>
					<li>No cash refund.</li>
					</ol>
					<p>Please joins us on Facebook at https://www.facebook.com/RedefiningTheWeb/</p>
					</div>';
				}
							
				if(strpos($rtwcpiglw_invoice_format,'[total_amnt_in_words]') !== false)
				{	
					if (get_option('rtwcpiglw_dsply_amnt_word') == 'yes') 
					{
						$rtwcpiglw_data['total_amnt_in_words'] = esc_html__(rtwcpiglw_convert_amount_in_words($rtwcpiglw_data['order_amount']), 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
						$rtwcpiglw_data['total_amnt_in_words'] .= esc_html__(' Only', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr style="border-bottom: none;">
						<td style="width: 170px; padding: 10px 5px; text-align: left; border-bottom: none; color: #444444;"><strong>Amount In Words</strong></td>
						<td style="padding: 10px 5px; text-align: left; border-bottom: none; color: #444444;">[total_amnt_in_words]</td>
					</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				
				if(strpos($rtwcpiglw_invoice_format,'[payment_method]') !== false)
				{
					if (get_option('rtwcpiglw_dsply_paymnt_mthd') == 'yes') 
					{
						$rtwcpiglw_data['payment_method'] = $rtwcpiglw_order->get_payment_method_title();
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
						<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Payment Method</strong></td>
						<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[payment_method]</td>
					</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				
				if(strpos($rtwcpiglw_invoice_format,'[shipping_charges]') !== false)
				{
					if (get_option('rtwcpiglw_dsply_fee_shipng') == 'yes') 
					{
						$rtwcpiglw_data['shipping_charges'] = $rtwcpiglw_shpng_amnt;
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
						<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Shipping Charges</strong></td>
						<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[shipping_charges]</td>
					</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				if(strpos($rtwcpiglw_invoice_format,'[row_tax_amount]') !== false)
				{
					
						$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_odr_objct->get_total_tax();
					
				}
			}
			else
			{
				if(strpos($rtwcpiglw_invoice_format,'[total_amnt_in_words]') !== false)
				{	
					if (get_option('rtwcpiglw_dsply_amnt_word') == 'yes') 
					{
						$rtwcpiglw_data['total_amnt_in_words'] = esc_html__(rtwcpiglw_convert_amount_in_words($rtwcpiglw_data['order_amount']), 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
						$rtwcpiglw_data['total_amnt_in_words'] .= esc_html__(' Only', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; color: #777777;">Amount In Words</th>
<td style="color: #444444; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 14px;">[total_amnt_in_words]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				
				if(strpos($rtwcpiglw_invoice_format,'[payment_method]') !== false)
				{
					if (get_option('rtwcpiglw_dsply_paymnt_mthd') == 'yes') 
					{
						$rtwcpiglw_data['payment_method'] = $rtwcpiglw_order->get_payment_method_title();
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; color: #777777;">Payment Method</th>
<td style="color: #444444; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 14px;">[payment_method]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				
				if(strpos($rtwcpiglw_invoice_format,'[shipping_charges]') !== false)
				{
					if (get_option('rtwcpiglw_dsply_fee_shipng') == 'yes') 
					{
						$rtwcpiglw_data['shipping_charges'] = $rtwcpiglw_shpng_amnt;
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; color: #777777;">Shipping Charges</th>
<td style="color: #444444; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 14px;">[shipping_charges]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				if(strpos($rtwcpiglw_invoice_format,'[row_tax_amount]') !== false)
				{
					if (get_option('rtwcpiglw_dsplay_tax_row') == 'yes') 
					{
						$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_odr_objct->get_total_tax();
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="color: #777777; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd;">Tax</th>
<td style="text-align: right; color: #444444; padding: 10px; border-bottom: 1px solid #dddddd; font-size: 14px;">[row_tax_amount]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
			}
				
			if ($rtwcpiglw_invoice_format != '') 
			{
				foreach ($rtwcpiglw_data as $rtwcpiglw_key => $rtwcpiglw_val) 
				{
					if ( $rtwcpiglw_key == 'order_amount' ) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'row_tax_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_odr_objct->get_total_tax();
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_odr_objct->get_total_tax());
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'shipping_charges' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'subtotal_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);	
					}
			    }

			    $rtwcpiglw_invoice_format = htmlspecialchars_decode ( htmlentities ( $rtwcpiglw_invoice_format, ENT_NOQUOTES, 'UTF-8', false ), ENT_NOQUOTES );
				$rtwcpiglw_count = 0;
				$line_numb = 1;
				$rtwcpiglw_string2 = '';
				$rtwcpiglw_dom = new simple_html_dom ();
				$rtwcpiglw_dom->load ( $rtwcpiglw_invoice_format );
				$rtwcpiglw_prod_tr = '';
				$rtwcpiglw_count = 0;
				foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody tr') as $val) 
				{
					$rtwcpiglw_prod_tr = $val->outertext;
				}
				$rtwcpiglw_prod_tr_final = '';
				if ($rtwcpiglw_product_qty != '') 
				{
					foreach ($rtwcpiglw_product_qty as $key => $value) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') 
						{
							$rtwcpiglw_pric[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							
							$rtwcpiglw_ttl_amnt[] = ($rtwcpiglw_price[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_ttl_tax[] = ($rtwcpiglw_total_tax[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_line_ttl[] = ($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
						}else{

							$rtwcpiglw_pric[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count], 2);
							$rtwcpiglw_ttl_amnt[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] ,2);
							$rtwcpiglw_ttl_tax[] = wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							$rtwcpiglw_line_ttl[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							
						}
						$rtwcpiglw_prod_tr_final .= str_replace( array('[line_number]', '[product_name]', '[product_img]', '[product_price]', '[product_qty]', '[tax_rate]', '[discount]', '[tax_amount]', '[line_total]'), array($line_numb, $key, ($rtwcpiglw_prdct_img[$rtwcpiglw_count].' '.$rtwcpiglw_prdct_dtls[$rtwcpiglw_count]), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_prodct_price[$rtwcpiglw_count],2), $value,$tax_name[$rtwcpiglw_count] , $rtwcpiglw_currency_symbol.' '.( wc_format_decimal( ($rtwcpiglw_subtotal_amnt[$rtwcpiglw_count] - $rtwcpiglw_total_amnt[$rtwcpiglw_count]) ,2 ) ), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count],2), $rtwcpiglw_currency_symbol.' '.wc_format_decimal(($rtwcpiglw_total_amnt[$rtwcpiglw_count]),2)), $rtwcpiglw_prod_tr);

						$rtwcpiglw_count = ++$rtwcpiglw_count;
						$line_numb = ++$line_numb;
					}
				}
			}
		}
		else if( $rtwcpiglw_invoice_temp == 2 )
		{
			$rtwcpiglw_invoice_format = stripcslashes($rtwcpiglw_invoice['invoice_format_2']);
			
			if(strpos($rtwcpiglw_invoice_format,'[total_amnt_in_words]')!= false)
				{
					if (get_option('rtwcpiglw_dsply_amnt_word') == 'yes') 
					{
						$rtwcpiglw_data['total_amnt_in_words'] = esc_html__(rtwcpiglw_convert_amount_in_words($rtwcpiglw_data['order_amount']), 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
						$rtwcpiglw_data['total_amnt_in_words'] .= esc_html__(' Only', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Amount In Words</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[total_amnt_in_words]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				
				if(strpos($rtwcpiglw_invoice_format,'[payment_method]')!= false)
				{
					if (get_option('rtwcpiglw_dsply_paymnt_mthd') == 'yes') 
					{
						$rtwcpiglw_data['payment_method'] = $rtwcpiglw_order->get_payment_method_title();
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Payment Method</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[payment_method]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				
				if(strpos($rtwcpiglw_invoice_format,'[shipping_charges]')!= false)
				{
					if (get_option('rtwcpiglw_dsply_fee_shipng') == 'yes') 
					{
						$rtwcpiglw_data['shipping_charges'] = $rtwcpiglw_shpng_amnt;
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Shipping Charges</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[shipping_charges]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}
				if(strpos($rtwcpiglw_invoice_format,'[row_tax_amount]')!= false)
				{
					if (get_option('rtwcpiglw_dsplay_tax_row') == 'yes') 
					{
						$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_odr_objct->get_total_tax();
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Tax</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[row_tax_amount]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}

			if ($rtwcpiglw_invoice_format != '') 
			{
				foreach ($rtwcpiglw_data as $rtwcpiglw_key => $rtwcpiglw_val) 
				{
					if ( $rtwcpiglw_key == 'order_amount' ) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'row_tax_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_odr_objct->get_total_tax();
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_odr_objct->get_total_tax());
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'shipping_charges' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'subtotal_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);	
					}
				}

				$rtwcpiglw_invoice_format = htmlspecialchars_decode ( htmlentities ( $rtwcpiglw_invoice_format, ENT_NOQUOTES, 'UTF-8', false ), ENT_NOQUOTES );
				$rtwcpiglw_count = 0;
				$line_numb = 1; 
				$rtwcpiglw_string2 = '';
				$rtwcpiglw_dom = new simple_html_dom ();
				$rtwcpiglw_dom->load ( $rtwcpiglw_invoice_format );
				$rtwcpiglw_prod_tr = '';
				$rtwcpiglw_count = 0;
				foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody tr') as $val) 
				{
					$rtwcpiglw_prod_tr = $val->outertext;
				}
				$rtwcpiglw_prod_tr_final = '';

				if ($rtwcpiglw_product_qty != '') 
				{
					foreach ($rtwcpiglw_product_qty as $key => $value) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') 
						{
							//$rtwcpiglw_pric[] = wc_format_decimal($price_exclude_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							
							$rtwcpiglw_ttl_amnt[] = ($rtwcpiglw_price[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_ttl_tax[] = ($rtwcpiglw_total_tax[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_line_ttl[] = ($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							$rtwcpiglw_dicount[] = ( $rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ).' '.$rtwcpiglw_currency_symbol;
						}else{

							//$rtwcpiglw_pric[] = wc_format_decimal($price_exclude_tax[$rtwcpiglw_count], 2);
							$rtwcpiglw_ttl_amnt[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] ,2);
							$rtwcpiglw_ttl_tax[] = wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							$rtwcpiglw_line_ttl[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							if( $rtwcpiglw_sale_price[$rtwcpiglw_count] != 0 ){
								$rtwcpiglw_dicount[] =  wc_format_decimal(($rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ), 2);
							}else{
								$rtwcpiglw_dicount[] = 0.00;
							}
							
						}

						$rtwcpiglw_prod_tr_final .= str_replace( array('[line_number]', '[product_name]', '[product_img]', '[product_price]', '[product_qty]', '[tax_rate]', '[discount]', '[tax_amount]', '[line_total]'), array($line_numb, $key, ($rtwcpiglw_prdct_img[$rtwcpiglw_count].' '.$rtwcpiglw_prdct_dtls[$rtwcpiglw_count]), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_prodct_price[$rtwcpiglw_count],2), $value,$tax_name[$rtwcpiglw_count] , $rtwcpiglw_currency_symbol.' '.( wc_format_decimal( ($rtwcpiglw_subtotal_amnt[$rtwcpiglw_count] - $rtwcpiglw_total_amnt[$rtwcpiglw_count]) ,2 ) ), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count],2), $rtwcpiglw_currency_symbol.' '.wc_format_decimal(($rtwcpiglw_total_amnt[$rtwcpiglw_count]),2)), $rtwcpiglw_prod_tr);

						$rtwcpiglw_count = ++$rtwcpiglw_count;
						$line_numb = ++$line_numb;
					}
				}
			}
		}
		else if( $rtwcpiglw_invoice_temp == 3 )
		{
			$rtwcpiglw_invoice_format = stripcslashes($rtwcpiglw_invoice['invoice_format_3']);

			if(strpos($rtwcpiglw_invoice_format,'[total_amnt_in_words]')!= false)
				{
					if (get_option('rtwcpiglw_dsply_amnt_word') == 'yes') 
					{
						$rtwcpiglw_data['total_amnt_in_words'] = esc_html__(rtwcpiglw_convert_amount_in_words($rtwcpiglw_data['order_amount']), 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
						$rtwcpiglw_data['total_amnt_in_words'] .= esc_html__(' Only', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="color: #444444; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">Amount In Words</th>
<td style="color: #555555; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">[total_amnt_in_words]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}

				if(strpos($rtwcpiglw_invoice_format,'[payment_method]')!= false)
				{
					if (get_option('rtwcpiglw_dsply_paymnt_mthd') == 'yes') 
					{
						$rtwcpiglw_data['payment_method'] = $rtwcpiglw_order->get_payment_method_title();
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="color: #444444; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">Payment Method</th>
<td style="color: #555555; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">[payment_method]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}

				if(strpos($rtwcpiglw_invoice_format,'[shipping_charges]')!= false)
				{
					if (get_option('rtwcpiglw_dsply_fee_shipng') == 'yes') 
					{
						$rtwcpiglw_data['shipping_charges'] = $rtwcpiglw_shpng_amnt;
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="color: #444444; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">Shipping Charges</th>
<td style="color: #555555; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">[shipping_charges]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}

				if(strpos($rtwcpiglw_invoice_format,'[row_tax_amount]')!= false)
				{
					if (get_option('rtwcpiglw_dsplay_tax_row') == 'yes') 
					{
						$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_odr_objct->get_total_tax();
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('<tr>
<th style="color: #444444; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">Tax</th>
<td style="color: #555555; padding: 10px; text-align: left; border-bottom: 1px solid #dddddd; font-size: 15px;">[row_tax_amount]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
					}
				}

			if ($rtwcpiglw_invoice_format != '') 
			{
				foreach ($rtwcpiglw_data as $rtwcpiglw_key => $rtwcpiglw_val) 
				{
					if ( $rtwcpiglw_key == 'order_amount' ) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'row_tax_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_odr_objct->get_total_tax();
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_odr_objct->get_total_tax());
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'shipping_charges' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'subtotal_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);	
					}
				}

				$rtwcpiglw_invoice_format = htmlspecialchars_decode ( htmlentities ( $rtwcpiglw_invoice_format, ENT_NOQUOTES, 'UTF-8', false ), ENT_NOQUOTES );
				$rtwcpiglw_count = 0;
				$line_numb = 1;
				$rtwcpiglw_string2 = '';
				$rtwcpiglw_dom = new simple_html_dom ();
				$rtwcpiglw_dom->load ( $rtwcpiglw_invoice_format );
				$rtwcpiglw_prod_tr = '';
				$rtwcpiglw_count = 0;
				foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody tr') as $val) 
				{
					$rtwcpiglw_prod_tr = $val->outertext;
				}
				$rtwcpiglw_prod_tr_final = '';		
				if ($rtwcpiglw_product_qty != '') 
				{
					foreach ($rtwcpiglw_product_qty as $key => $value) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') 
						{
							//$rtwcpiglw_pric[] = wc_format_decimal($price_exclude_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							
							$rtwcpiglw_ttl_amnt[] = ($rtwcpiglw_price[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_ttl_tax[] = ($rtwcpiglw_total_tax[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_line_ttl[] = ($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							$rtwcpiglw_dicount[] = ( $rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ).' '.$rtwcpiglw_currency_symbol;
						}else{

							//$rtwcpiglw_pric[] = wc_format_decimal($price_exclude_tax[$rtwcpiglw_count], 2);
							$rtwcpiglw_ttl_amnt[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] ,2);
							$rtwcpiglw_ttl_tax[] = wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							$rtwcpiglw_line_ttl[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							if( $rtwcpiglw_sale_price[$rtwcpiglw_count] != 0 ){
								$rtwcpiglw_dicount[] =  wc_format_decimal(($rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ), 2);
							}else{
								$rtwcpiglw_dicount[] = 0.00;
							}
							
						}

						$rtwcpiglw_prod_tr_final .= str_replace( array('[line_number]', '[product_name]', '[product_img]', '[product_price]', '[product_qty]', '[tax_rate]', '[discount]', '[tax_amount]', '[line_total]'), array($line_numb, $key, ($rtwcpiglw_prdct_img[$rtwcpiglw_count].' '.$rtwcpiglw_prdct_dtls[$rtwcpiglw_count]), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_prodct_price[$rtwcpiglw_count],2), $value,$tax_name[$rtwcpiglw_count] , $rtwcpiglw_currency_symbol.' '.( wc_format_decimal( ($rtwcpiglw_subtotal_amnt[$rtwcpiglw_count] - $rtwcpiglw_total_amnt[$rtwcpiglw_count]) ,2 ) ), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count],2), $rtwcpiglw_currency_symbol.' '.wc_format_decimal(($rtwcpiglw_total_amnt[$rtwcpiglw_count]),2)), $rtwcpiglw_prod_tr);

						$rtwcpiglw_count = ++$rtwcpiglw_count;
						$line_numb = ++$line_numb;
					}
				}
			}
		}
		else if( $rtwcpiglw_invoice_temp == 4 )
		{
			$rtwcpiglw_invoice_format = stripcslashes($rtwcpiglw_invoice['invoice_format_4']);

			if(strpos($rtwcpiglw_invoice_format,'[total_amnt_in_words]')!= false)
			{
				if (get_option('rtwcpiglw_dsply_amnt_word') == 'yes') 
				{
					$rtwcpiglw_data['total_amnt_in_words'] = esc_html__(rtwcpiglw_convert_amount_in_words($rtwcpiglw_data['order_amount']), 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
					$rtwcpiglw_data['total_amnt_in_words'] .= esc_html__(' Only', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr style="border-bottom: none;">
<td style="width: 170px; padding: 10px 5px; text-align: left; border-bottom: none; color: #444444;"><strong>Amount In Words</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: none; color: #444444;">[total_amnt_in_words]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
				}
			}

			if(strpos($rtwcpiglw_invoice_format,'[payment_method]')!= false)
			{
				if ($rtwcpiglw_stng['rtwcpiglw_dsply_paymnt_mthd'] == '1') 
				{
					$rtwcpiglw_data['payment_method'] = $rtwcpiglw_order->get_payment_method_title();
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Payment Method</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[payment_method]</td>
</tr>', ' ', $rtwcpiglw_invoice_format);
				}
			}

			if(strpos($rtwcpiglw_invoice_format,'[shipping_charges]')!= false)
			{
				if (get_option('rtwcpiglw_dsply_fee_shipng') == 'yes') 
				{
					$rtwcpiglw_data['shipping_charges'] = $rtwcpiglw_shpng_amnt;
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Shipping Charges</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[shipping_charges]</td>
</tr>', ' ', $rtwcpiglw_invoice_format);
				}
			}

			if(strpos($rtwcpiglw_invoice_format,'[row_tax_amount]')!= false)
			{
				if (get_option('rtwcpiglw_dsplay_tax_row') == 'yes') 
				{
					$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_odr_objct->get_total_tax();
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="width: 150px; padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;"><strong>Tax</strong></td>
<td style="padding: 10px 5px; text-align: left; border-bottom: 2px solid #dddddd; color: #444444;">[row_tax_amount]</td>
</tr>', " ", trim($rtwcpiglw_invoice_format));
				}
			}

			if ($rtwcpiglw_invoice_format != '') 
			{
				foreach ($rtwcpiglw_data as $rtwcpiglw_key => $rtwcpiglw_val) 
				{
					if ( $rtwcpiglw_key == 'order_amount' ) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'row_tax_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_odr_objct->get_total_tax();
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_odr_objct->get_total_tax());
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'shipping_charges' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'subtotal_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_val,2);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);	
					}
				}

				$rtwcpiglw_invoice_format = htmlspecialchars_decode ( htmlentities ( $rtwcpiglw_invoice_format, ENT_NOQUOTES, 'UTF-8', false ), ENT_NOQUOTES );
				$rtwcpiglw_count = 0;
				$line_numb = 1; 
				$rtwcpiglw_string2 = '';
				$rtwcpiglw_dom = new simple_html_dom ();
				$rtwcpiglw_dom->load ( $rtwcpiglw_invoice_format );
				$rtwcpiglw_prod_tr = '';
				$rtwcpiglw_count = 0;
				foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody tr') as $val) 
				{
					$rtwcpiglw_prod_tr = $val->outertext;
				}
				$rtwcpiglw_prod_tr_final = '';		
				if ($rtwcpiglw_product_qty != '') 
				{
					foreach ($rtwcpiglw_product_qty as $key => $value) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') 
						{	
							$rtwcpiglw_ttl_amnt[] = ($rtwcpiglw_price[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_ttl_tax[] = ($rtwcpiglw_total_tax[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_line_ttl[] = ($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							$rtwcpiglw_dicount[] = ( $rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ).' '.$rtwcpiglw_currency_symbol;
						}else{
							$rtwcpiglw_ttl_amnt[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] ,2);
							$rtwcpiglw_ttl_tax[] = wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							$rtwcpiglw_line_ttl[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							if( $rtwcpiglw_sale_price[$rtwcpiglw_count] != 0 ){
								$rtwcpiglw_dicount[] =  wc_format_decimal(($rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ), 2);
							}else{
								$rtwcpiglw_dicount[] = 0.00;
							}
							
						}

						$rtwcpiglw_prod_tr_final .= str_replace( array('[line_number]', '[product_name]', '[product_img]', '[product_price]', '[product_qty]', '[tax_rate]', '[discount]', '[tax_amount]', '[line_total]'), array($line_numb, $key, ($rtwcpiglw_prdct_img[$rtwcpiglw_count].' '.$rtwcpiglw_prdct_dtls[$rtwcpiglw_count]), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_prodct_price[$rtwcpiglw_count],2), $value,$rtwcpiglw_currency_symbol.' '.wc_format_decimal($tax_name[$rtwcpiglw_count],2) , $rtwcpiglw_currency_symbol.' '.( wc_format_decimal( ($rtwcpiglw_subtotal_amnt[$rtwcpiglw_count] - $rtwcpiglw_total_amnt[$rtwcpiglw_count]) ,2 ) ), $rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count],2), $rtwcpiglw_currency_symbol.' '.(wc_format_decimal($rtwcpiglw_total_amnt[$rtwcpiglw_count],2))), $rtwcpiglw_prod_tr);

						$rtwcpiglw_count = ++$rtwcpiglw_count;
						$line_numb = ++$line_numb;
					}
				}
			}
		}
		else if ( $rtwcpiglw_invoice_temp == 5 ) 
		{
			$rtwcpiglw_invoice_format = stripcslashes($rtwcpiglw_invoice['invoice_format_5']);

			if(strpos($rtwcpiglw_invoice_format,'[shipping_charges]')!= false)
			{
				if (get_option('rtwcpiglw_dsply_fee_shipng') == 'yes') 
				{
					$rtwcpiglw_data['shipping_charges'] = $rtwcpiglw_shpng_amnt;
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="text-align: right; padding-left: 10px; padding-right: 20px; background: #2897b8; color: white; width: 205px; height: 40px; font-size: 15px;">Shipping Charge</td>
<td style="text-align: right; background: #2897b8; padding-left: 10px; padding-right: 20px; color: white; width: 100px; height: 40px; font-size: 15px;">[shipping_charges]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
				}
			}

			if(strpos($rtwcpiglw_invoice_format,'[row_tax_amount]')!= false)
			{
				if (get_option('rtwcpiglw_dsplay_tax_row') == 'yes') 
				{
					$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_odr_objct->get_total_tax();
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="text-align: right; padding-left: 10px; padding-right: 20px; background: #2897b8; color: white; width: 205px; height: 40px; font-size: 15px;">Total Tax</td>
<td style="text-align: right; background: #2897b8; padding-left: 10px; padding-right: 20px; color: white; width: 100px; height: 40px; font-size: 15px;">[row_tax_amount]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
				}
			}
			if ($rtwcpiglw_invoice_format != '') 
			{
				foreach ($rtwcpiglw_data as $rtwcpiglw_key => $rtwcpiglw_val) 
				{
					if ( $rtwcpiglw_key == 'order_amount' ) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'row_tax_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_odr_objct->get_total_tax();
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_odr_objct->get_total_tax());
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'shipping_charges' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'subtotal_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);	
					}
				}

				$rtwcpiglw_invoice_format = htmlspecialchars_decode ( htmlentities ( $rtwcpiglw_invoice_format, ENT_NOQUOTES, 'UTF-8', false ), ENT_NOQUOTES );
				$rtwcpiglw_count = 0;
				$line_numb = 1; 
				$rtwcpiglw_string2 = '';
				$rtwcpiglw_dom = new simple_html_dom ();
				$rtwcpiglw_dom->load ( $rtwcpiglw_invoice_format );
				$rtwcpiglw_prod_tr = '';
				$rtwcpiglw_count = 0;
				foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody tr') as $val) 
				{
					$rtwcpiglw_prod_tr = $val->outertext;
				}
				$rtwcpiglw_prod_tr_final = '';		
				if ($rtwcpiglw_product_qty != '') 
				{
					foreach ($rtwcpiglw_product_qty as $key => $value) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') 
						{	
							$rtwcpiglw_ttl_amnt[] = ($rtwcpiglw_price[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_ttl_tax[] = ($rtwcpiglw_total_tax[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_line_ttl[] = ($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							$rtwcpiglw_dicount[] = ( $rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ).' '.$rtwcpiglw_currency_symbol;
						}else{
							$rtwcpiglw_ttl_amnt[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] ,2);
							$rtwcpiglw_ttl_tax[] = wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							$rtwcpiglw_line_ttl[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							if( $rtwcpiglw_sale_price[$rtwcpiglw_count] != 0 ){
								$rtwcpiglw_dicount[] =  wc_format_decimal(($rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ), 2);
							}else{
								$rtwcpiglw_dicount[] = 0.00;
							}
							
						}

						$rtwcpiglw_prod_tr_final .= str_replace( array('[product_name]', '[product_img]', '[product_qty]', '[tax_rate]', '[product_price]', '[discount]', '[line_total]'), array($key,($rtwcpiglw_prdct_img[$rtwcpiglw_count].' '.$rtwcpiglw_prdct_dtls[$rtwcpiglw_count]),$value,$tax_name[$rtwcpiglw_count],$rtwcpiglw_currency_symbol.' '.($rtwcpiglw_prodct_price[$rtwcpiglw_count]),$rtwcpiglw_currency_symbol.' '.( wc_format_decimal( ($rtwcpiglw_subtotal_amnt[$rtwcpiglw_count] - $rtwcpiglw_total_amnt[$rtwcpiglw_count]) ,2 ) ), $rtwcpiglw_currency_symbol.' '.(($rtwcpiglw_total_amnt[$rtwcpiglw_count]))), $rtwcpiglw_prod_tr);

						$rtwcpiglw_count = ++$rtwcpiglw_count;
						$line_numb = ++$line_numb;
					}
				}
			}
		}
		else if ($rtwcpiglw_invoice_temp == 6) 
		{
			$rtwcpiglw_invoice_format = stripcslashes($rtwcpiglw_invoice['invoice_format_6']);
			if(strpos($rtwcpiglw_invoice_format,'[shipping_charges]')!= false)
			{
				if (get_option('rtwcpiglw_dsply_fee_shipng') == 'yes') 
				{
					$rtwcpiglw_data['shipping_charges'] = $rtwcpiglw_shpng_amnt;
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="padding-top: 10px; padding-bottom: 10px; background: whitesmoke;">Shipping Charges</td>
<td style="background: whitesmoke;">[shipping_charges]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
				}
			}

			if(strpos($rtwcpiglw_invoice_format,'[row_tax_amount]')!= false)
			{
				if (get_option('rtwcpiglw_dsplay_tax_row') == 'yes') 
				{
					$rtwcpiglw_data['row_tax_amount'] = $rtwcpiglw_odr_objct->get_total_tax();
				}
				else
				{
					$rtwcpiglw_invoice_format = str_replace('<tr>
<td style="padding-top: 10px; padding-bottom: 10px; background: whitesmoke;">Total Tax</td>
<td style="background: whitesmoke;">[row_tax_amount]</td>
</tr>', " ", $rtwcpiglw_invoice_format);
				}
			}
			if ($rtwcpiglw_invoice_format != '') 
			{
				foreach ($rtwcpiglw_data as $rtwcpiglw_key => $rtwcpiglw_val) 
				{
					if ( $rtwcpiglw_key == 'order_amount' ) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'row_tax_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_odr_objct->get_total_tax();
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_odr_objct->get_total_tax());
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'shipping_charges' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					if( $rtwcpiglw_key == 'subtotal_amount' )
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') {
							$rtwcpiglw_val = $rtwcpiglw_val;
						}else{
							$rtwcpiglw_val = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_val);
						}
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);
					}
					else
					{
						$rtwcpiglw_invoice_format = str_replace('['.$rtwcpiglw_key.']', $rtwcpiglw_val, $rtwcpiglw_invoice_format);	
					}
				}

				$rtwcpiglw_invoice_format = htmlspecialchars_decode ( htmlentities ( $rtwcpiglw_invoice_format, ENT_NOQUOTES, 'UTF-8', false ), ENT_NOQUOTES );
				$rtwcpiglw_count = 0;
				$line_numb = 1; 
				$rtwcpiglw_string2 = '';
				$rtwcpiglw_dom = new simple_html_dom ();
				$rtwcpiglw_dom->load ( $rtwcpiglw_invoice_format );
				$rtwcpiglw_prod_tr = '';
				$rtwcpiglw_count = 0;
				foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody') as $val) 
				{
					$rtwcpiglw_prod_tr = $val->outertext;
				}
				$rtwcpiglw_prod_tr_final = '';		
				if ($rtwcpiglw_product_qty != '') 
				{
					foreach ($rtwcpiglw_product_qty as $key => $value) 
					{
						if (get_option('rtwcpiglw_dsply_crrncy_smbl') != 'yes') 
						{	
							$rtwcpiglw_ttl_amnt[] = ($rtwcpiglw_price[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_ttl_tax[] = ($rtwcpiglw_total_tax[$rtwcpiglw_count].' '.$rtwcpiglw_currency_symbol);
							$rtwcpiglw_line_ttl[] = ($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count]).' '.$rtwcpiglw_currency_symbol;
							$rtwcpiglw_dicount[] = ( $rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ).' '.$rtwcpiglw_currency_symbol;
						}else{
							$rtwcpiglw_ttl_amnt[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] ,2);
							$rtwcpiglw_ttl_tax[] = wc_format_decimal($rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							$rtwcpiglw_line_ttl[] = wc_format_decimal($rtwcpiglw_price[$rtwcpiglw_count] + $rtwcpiglw_total_tax[$rtwcpiglw_count] , 2);
							if( $rtwcpiglw_sale_price[$rtwcpiglw_count] != 0 ){
								$rtwcpiglw_dicount[] =  wc_format_decimal(($rtwcpiglw_price[$rtwcpiglw_count] - $rtwcpiglw_sale_price[$rtwcpiglw_count] ), 2);
							}else{
								$rtwcpiglw_dicount[] = 0.00;
							}
							
						}

						$rtwcpiglw_prod_tr_final .= str_replace( 
							array('[product_name]', '[product_img]', '[product_qty]', '[tax_rate]', '[product_price]', '[discount]', '[line_total]'), 
							array(
								$key,
								($rtwcpiglw_prdct_img[$rtwcpiglw_count].' '.$rtwcpiglw_prdct_dtls[$rtwcpiglw_count]),
								$value,
								$tax_name[$rtwcpiglw_count],
								$rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_prodct_price[$rtwcpiglw_count],2),
								$rtwcpiglw_currency_symbol.' '.( wc_format_decimal( ($rtwcpiglw_subtotal_amnt[$rtwcpiglw_count] - $rtwcpiglw_total_amnt[$rtwcpiglw_count]) ,2 ) ), 
								$rtwcpiglw_currency_symbol.' '.wc_format_decimal(($rtwcpiglw_total_amnt[$rtwcpiglw_count]),2)), 
								$rtwcpiglw_prod_tr);

						$rtwcpiglw_count = ++$rtwcpiglw_count;
						$line_numb = ++$line_numb;
					}
				}
			}
		}

		$rtwcpiglw_dom = new simple_html_dom ();
		$rtwcpiglw_dom->load ( $rtwcpiglw_invoice_format );
		foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody') as $val) 
		{
			$val->outertext = $rtwcpiglw_prod_tr_final;
		}
		$rtwcpiglw_invoice_format = $rtwcpiglw_dom->save();
		$rtwcpiglw_pdf_invoice = rtwcpiglw_convert_to_pdf($rtwcpiglw_invoice_format, $rtwcpiglw_odr_id, $rtwcpiglw_user_email);

		return $rtwcpiglw_pdf_invoice;
	}
	else
	{
		return ;
	}	
}

/**
 * function for create pdf for invoice.
 *
 * @since    1.0.0
 */
function rtwcpiglw_convert_to_pdf( $rtwcpiglw_pdf_html, $rtwcpiglw_ordr_id, $rtwcpiglw_user_email, $rtwcpiglw_pro_desc='')
{
	$pdf_name_option = get_option( 'rtwcpiglw_basic_setting_opt' );
	if ( isset($pdf_name_option) && $pdf_name_option['rtwcpiglw_custm_pdf_name'] != '') {
		$pdf_name = $pdf_name_option['rtwcpiglw_custm_pdf_name'];
	}else{
		$pdf_name = 'rtwcpiglw_';
	}
	if ($rtwcpiglw_pro_desc == 'Shipping_label') 
	{
		$rtwcpiglw_file_path = RTWCPIGLW_PDF_DIR.'/rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_ordr_id.'.pdf';
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		$rtwcpiglw_file_path = RTWCPIGLW_CREDITNOTE_DIR.'credi-note-'.$rtwcpiglw_ordr_id.'.pdf';
	}
	else
	{
		$rtwcpiglw_file_path = RTWCPIGLW_PDF_DIR.$pdf_name.$rtwcpiglw_ordr_id.'.pdf'; 
	}

	if(get_option('rtwcpiglw_table_border') == 'yes')
	{
		$rtwcpiglw_pdf_css = '<style>
		body
		{
			margin: 0px;
		}
		table 
		{
			width : 100%;
		}
		table, td, th
		{
			border: 1px solid black;
			border-collapse: collapse;
		}
		th
		{
			background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
			font-weight:bold;
		}
		tr
		{
			border: 1px solid black;
			border-collapse: collapse;
		}
		td
		{
			font-size:12pt;
		}
		.rtwcpiglw_text {
			font-weight:bold;
			padding-top:6px;
			text-align: right;
			display: inline-block;
			margin-top: 5px;
			margin:bottom: 5px;
		}
		.rtwcpiglw_text_label {
			font-weight: bold;
			width: 200px;
			display: block;
		}
		#rtwcpiglw_text_center
		{
			text-align: center;
		}';
		$rtwcpiglw_pdf_css .= '<style> div
		{ 
			margin-top:0px;
			margin-bottom:0px;
			padding-top:0px;
			padding-bottom:0px;
		}
		td, tr, th
		{
			text-align: left;
		}';
	}
	else
	{
		$rtwcpiglw_pdf_css = '<style>
		body
		{
			margin: 0px;
		}
		img
		{
			float:left;
		}
		table 
		{
			width : 100%;
		}
		table
		{
			border-collapse: collapse;
		}
		th
		{
			font-weight:bold;
			padding:10px;
			border-bottom:1px solid #dddddd;
			text-align: center;
		}
		td
		{
			padding:10px;
			border-bottom:1px solid #dddddd;
			text-align: center;
		}
		.rtwcpiglw_text {
			font-weight:lighter;
			padding-top:6px;
			text-align: right;
			display: inline-block;
			margin-top: 5px;
			margin:bottom: 5px;
		}
		.rtwcpiglw_text_label {
			width: 200px;
			display: block;
			font-weight: bold;
		}
		#rtwcpiglw_text_center
		{
			text-align: center;
		}';
	}
	
	if ( $rtwcpiglw_pro_desc == 'Shipping_label' ) 
	{
		$shpng_page = get_option( 'rtwcpiglw_shpng_lbl_css_setting_opt');
		if ( !empty($shpng_page) && isset($shpng_page['rtwcpiglw_pdf_page_size']) ) 
		{
			$rtwcpiglw_page_size = $shpng_page['rtwcpiglw_pdf_page_size'];
		}
		else
		{
			$rtwcpiglw_page_size = serialize(array(210,297));
		}
	}
	else if( $rtwcpiglw_pro_desc == 'credit_note' )
	{
		$credit_note = get_option( 'rtwcpiglw_credit_note_css_setting_opt' );
		if( isset( $credit_note['rtwcpiglw_pdf_page_size'] ) && !empty( $credit_note ['rtwcpiglw_pdf_page_size'] ) && $credit_note['rtwcpiglw_pdf_page_size'] != 'select' ) 
		{
			$rtwcpiglw_page_size = $credit_note['rtwcpiglw_pdf_page_size'];
		}else{

			$rtwcpiglw_page_size = serialize(array(210,297));
		}
	}
	else
	{
		if( isset( $rtwcpiglw_stng['rtwcpiglw_pdf_page_size'] ) && !empty( $rtwcpiglw_stng ['rtwcpiglw_pdf_page_size'] ) && $rtwcpiglw_stng['rtwcpiglw_pdf_page_size'] != 'select' ) 
		{
			$rtwcpiglw_page_size = $rtwcpiglw_stng ['rtwcpiglw_pdf_page_size'];
		}else{

			$rtwcpiglw_page_size = serialize(array(210,297));
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpnglbl_page_orien') != '' )
		{
			$rtwcpiglw_page_orientation = get_option('rtwcpiglw_shpnglbl_page_orien');
		}
		else
		{
			$rtwcpiglw_page_orientation = 'P';
		}
	}
	else if( $rtwcpiglw_pro_desc == 'credit_note' )
	{
		if( get_option('rtwcpiglw_credit_note_page_orien') != '' ) 
		{
			$rtwcpiglw_page_orientation = get_option('rtwcpiglw_credit_note_page_orien');
		}
		else
		{
			$rtwcpiglw_page_orientation = 'P';
		}
	}
	else
	{
		if( get_option('rtwcpiglw_rtwcpiglw_page_orien') != '' ) 
		{
			$rtwcpiglw_page_orientation = get_option('rtwcpiglw_rtwcpiglw_page_orien');
		}
		else
		{
			$rtwcpiglw_page_orientation = 'P';
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpnglbl_body_left_margin') !='' ) {
			$rtwcpiglw_lft_marg = get_option('rtwcpiglw_shpnglbl_body_left_margin');	
		} else {

			$rtwcpiglw_lft_marg = 15;
		}
	}
	else if( $rtwcpiglw_pro_desc == 'credit_note' )
	{
		if( get_option('rtwcpiglw_credit_note_body_left_margin') !='' ) {
			$rtwcpiglw_lft_marg = get_option('rtwcpiglw_credit_note_body_left_margin');	
		} else {

			$rtwcpiglw_lft_marg = 15;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_body_left_margin') !='' ) {
			$rtwcpiglw_lft_marg = get_option('rtwcpiglw_body_left_margin');	
		} else {

			$rtwcpiglw_lft_marg = 15;
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpnglbl_body_right_margin') !='' ) {

			$rtwcpiglw_rgt_marg = get_option('rtwcpiglw_shpnglbl_body_right_margin');	
		} else {

			$rtwcpiglw_rgt_marg = 15;
		}
	}
	else if( $rtwcpiglw_pro_desc == 'credit_note' )
	{
		if( get_option('rtwcpiglw_credit_note_body_right_margin') !='' ) {

			$rtwcpiglw_rgt_marg = get_option('rtwcpiglw_credit_note_body_right_margin');	
		} else {

			$rtwcpiglw_rgt_marg = 15;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_body_right_margin') !='' ) {

			$rtwcpiglw_rgt_marg = get_option('rtwcpiglw_body_right_margin');	
		} else {

			$rtwcpiglw_rgt_marg = 15;
		}
	}

	if ( $rtwcpiglw_pro_desc == 'Shipping_label' ) 
	{
		if( get_option('rtwcpiglw_shpnglbl_body_top_margin') !='' ) {

			$rtwcpiglw_top_marg = get_option('rtwcpiglw_shpnglbl_body_top_margin');	
		} else {

			$rtwcpiglw_top_marg = 15;
		}
	}
	else if( $rtwcpiglw_pro_desc == 'credit_note' )
	{
		if( get_option('rtwcpiglw_credit_note_body_top_margin') !='' ) {

			$rtwcpiglw_top_marg = get_option('rtwcpiglw_credit_note_body_top_margin');	
		} else {

			$rtwcpiglw_top_marg = 15;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_body_top_margin') !='' ) {

			$rtwcpiglw_top_marg = get_option('rtwcpiglw_body_top_margin');	
		} else {

			$rtwcpiglw_top_marg = 15;
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpng_lbl_header_top_margin') !='' ) {
			$rtwcpiglw_hdr_top_marg = get_option('rtwcpiglw_shpng_lbl_header_top_margin');	
		} else {

			$rtwcpiglw_hdr_top_marg = 7;
		}
	}
	elseif ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if( get_option('rtwcpiglw_credit_note_header_top_margin') !='' ) {
			$rtwcpiglw_hdr_top_marg = get_option('rtwcpiglw_credit_note_header_top_margin');	
		} else {

			$rtwcpiglw_hdr_top_marg = 7;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_header_top_margin') !='' ) {
			$rtwcpiglw_hdr_top_marg = get_option('rtwcpiglw_header_top_margin');	
		} else {

			$rtwcpiglw_hdr_top_marg = 7;
		}
	}

	/*PDF footer top margin*/
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpng_lbl_footer_top_margin') !='' ) 
		{
			$rtwcpiglw_foo_top_marg = get_option('rtwcpiglw_shpng_lbl_footer_top_margin');	
		} 
		else 
		{
			$rtwcpiglw_foo_top_marg = 15;
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note'  ) 
	{
		if( get_option('rtwcpiglw_credit_note_footer_top_margin') !='' ) 
		{
			$rtwcpiglw_foo_top_marg = get_option('rtwcpiglw_credit_note_footer_top_margin');	
		} 
		else 
		{
			$rtwcpiglw_foo_top_marg = 15;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_footer_top_margin') !='' ) 
		{
			$rtwcpiglw_foo_top_marg = get_option('rtwcpiglw_footer_top_margin');	
		} 
		else 
		{
			$rtwcpiglw_foo_top_marg = 15;
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpnglbl_body_font_family') !='' ) 
		{
			$rtwcpiglw_body_font_family = get_option('rtwcpiglw_shpnglbl_body_font_family');
		}
		else
		{
			$rtwcpiglw_body_font_family = "dejavusanscondensed";
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if( get_option('rtwcpiglw_credit_note_body_font_family') !='' ) 
		{
			$rtwcpiglw_body_font_family = get_option('rtwcpiglw_credit_note_body_font_family');
		}
		else
		{
			$rtwcpiglw_body_font_family = "dejavusanscondensed";
		}
	}
	else
	{
		if( get_option('rtwcpiglw_body_font_family') !='' ) 
		{
			$rtwcpiglw_body_font_family = get_option('rtwcpiglw_body_font_family');
		}
		else
		{
			$rtwcpiglw_body_font_family = "dejavusanscondensed";
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if(get_option('rtwcpiglw_shpnglbl_body_font_size') !='' ) 
		{
			$rtwcpiglw_body_font_size = get_option('rtwcpiglw_shpnglbl_body_font_size');
		} 
		else
		{
			$rtwcpiglw_body_font_size = 10;
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if( get_option('rtwcpiglw_credit_note_body_font_size') !='' ) 
		{
			$rtwcpiglw_body_font_size = get_option('rtwcpiglw_credit_note_body_font_size');
		}
		else
		{
			$rtwcpiglw_body_font_size = 10;
		}
	}
	else
	{
		if(get_option('rtwcpiglw_body_font_size') !='' ) 
		{
			$rtwcpiglw_body_font_size = get_option('rtwcpiglw_body_font_size');
		} 
		else
		{
			$rtwcpiglw_body_font_size = 10;
		}
	}

	if ( $rtwcpiglw_pro_desc == '' || $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		$rtwcpiglw_option = get_option('rtwcpiglw_invoice_format_setting_opt');
		$rtwcpiglw_credit_note = get_option( 'rtwcpiglw_credit_note_format_setting_opt' );

		if( $rtwcpiglw_option['invoice_template'] == 1 || $rtwcpiglw_option['invoice_template'] == 5 || $rtwcpiglw_option['invoice_template'] == 6 || $rtwcpiglw_credit_note['invoice_template'] == 6 )
		{
			$rtwcpiglw_top_marg = 0;
			$rtwcpiglw_rgt_marg = 0;
			$rtwcpiglw_lft_marg = 0;
			$rtwcpiglw_hdr_top_marg = 0;
		}
		else if( $rtwcpiglw_option['invoice_template'] == 3 || $rtwcpiglw_credit_note['invoice_template'] == 3 )
		{
			$rtwcpiglw_rgt_marg = 12;
			$rtwcpiglw_lft_marg = 12;
		}
	}
	include(RTWCPIGLW_DIR ."includes/mpdf/autoload.php");
	$rtwcpiglw_mpdf = new \Mpdf\Mpdf( ['mode' => 'utf-8', 'format' => unserialize( $rtwcpiglw_page_size ), 'default_font_size' => $rtwcpiglw_body_font_size, 'default_font' => $rtwcpiglw_body_font_family, 'margin_left' => $rtwcpiglw_lft_marg, 'margin_right' => $rtwcpiglw_rgt_marg, 'margin_top' => $rtwcpiglw_top_marg, 'margin_bottom' => '20', 'margin_header' => $rtwcpiglw_hdr_top_marg, 'margin_footer' => $rtwcpiglw_foo_top_marg, 'orientation' => $rtwcpiglw_page_orientation ]);
	if ( $rtwcpiglw_option['invoice_template'] == 1 || $rtwcpiglw_option['invoice_template'] == 5 || $rtwcpiglw_option['invoice_template'] == 6 || $rtwcpiglw_credit_note['invoice_template'] == 6 ) 
	{
		$rtwcpiglw_mpdf->setAutoTopMargin = 'stretch';
		$rtwcpiglw_mpdf->setAutoBottomMargin = 'stretch';
		$rtwcpiglw_mpdf->SetDisplayMode('fullpage');
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpng_lbl_header_font_size') != '' ) {

			$rtwcpiglw_hdr_font_size = get_option('rtwcpiglw_shpng_lbl_header_font_size');
		} else {

			$rtwcpiglw_hdr_font_size = 20;
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if( get_option('rtwcpiglw_credit_note_header_font_size') != '' ) {

			$rtwcpiglw_hdr_font_size = get_option('rtwcpiglw_credit_note_header_font_size');
		} else {

			$rtwcpiglw_hdr_font_size = 20;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_header_font_size') != '' ) {

			$rtwcpiglw_hdr_font_size = get_option('rtwcpiglw_header_font_size');
		} else {

			$rtwcpiglw_hdr_font_size = 20;
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpng_lbl_header_font') !='' ) {

			$rtwcpiglw_hdr_font_family = get_option('rtwcpiglw_shpng_lbl_header_font');
		} else{

			$rtwcpiglw_hdr_font_family = 'sans-serif';
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if( get_option('rtwcpiglw_credit_note_header_font') != '' ) {

			$rtwcpiglw_hdr_font_family = get_option('rtwcpiglw_credit_note_header_font');
		} else {

			$rtwcpiglw_hdr_font_family = 20;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_header_font_family') !='' ) {

			$rtwcpiglw_hdr_font_family = get_option('rtwcpiglw_header_font_family');
		} else{

			$rtwcpiglw_hdr_font_family = 'sans-serif';
		}
	}
	
	$rtwcpiglw_mpdf->defaultheaderfontsize = $rtwcpiglw_hdr_font_size;
	$rtwcpiglw_mpdf->defaultheaderfontstyle = $rtwcpiglw_hdr_font_family;
	$rtwcpiglw_mpdf->defaultheaderline = 1;

	$rtwcpiglw_site_name=get_bloginfo ( 'name' );
	$rtwcpiglw_site_desc=get_bloginfo ( 'description' );
	$rtwcpiglw_site_url=home_url();

	//***$rtwcpiglw_stng['rtw_header_html'] this variable is used for HTML***//
	if ( $rtwcpiglw_pro_desc == 'Shipping_label' ) 
	{
		$shpng_hdr_html = get_option('rtwcpiglw_shpng_lbl_header_stng_opt');
		if (!empty($shpng_hdr_html) && isset($shpng_hdr_html['rtw_header_html']) && $shpng_hdr_html['rtw_header_html'] != '' ) 
		{
			$rtwcpiglw_hdr_html = $shpng_hdr_html['rtw_header_html'];

			$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr(get_option('rtwcpiglw_header_font_family')).';">'.stripcslashes($rtwcpiglw_hdr_html).'</h2></div>', 'O' );

			$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr(get_option('rtwcpiglw_header_font_family')).';">'.stripcslashes($rtwcpiglw_hdr_html).'</h2></div>', 'E');
		}
		else
		{
			$rtwcpiglw_mpdf->SetHTMLHeader('', 'O' );
			$rtwcpiglw_mpdf->SetHTMLHeader('', 'E');
		}
	}
	else if ($rtwcpiglw_pro_desc == 'credit_note') 
	{
		$credit_hdr_html = get_option('rtwcpiglw_credit_note_header_stng_opt');
		if (!empty($credit_hdr_html) && isset($credit_hdr_html['rtw_header_html']) && $credit_hdr_html['rtw_header_html'] != '' ) 
		{
			$rtwcpiglw_hdr_html = $credit_hdr_html['rtw_header_html'];

			$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr(get_option('rtwcpiglw_header_font_family')).';">'.stripcslashes($rtwcpiglw_hdr_html).'</h2></div>', 'O' );

			$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr(get_option('rtwcpiglw_header_font_family')).';">'.stripcslashes($rtwcpiglw_hdr_html).'</h2></div>', 'E');
		}
		else
		{
			$rtwcpiglw_mpdf->SetHTMLHeader('', 'O' );
			$rtwcpiglw_mpdf->SetHTMLHeader('', 'E');
		}
	}
	else
	{
		$invoice_hdr_html = get_option('rtwcpiglw_header_setting_opt');
		if( isset( $invoice_hdr_html['rtw_header_html'] ) && $invoice_hdr_html['rtw_header_html'] != '' ) 
		{
			$rtwcpiglw_hdr_html = $invoice_hdr_html['rtw_header_html'];

			$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr(get_option('rtwcpiglw_header_font_family')).';">'.stripcslashes($rtwcpiglw_hdr_html).'</h2></div>', 'O' );

			$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr(get_option('rtwcpiglw_header_font_family')).';">'.stripcslashes($rtwcpiglw_hdr_html).'</h2></div>', 'E');
		}
		else
		{
			$rtwcpiglw_mpdf->SetHTMLHeader('', 'O' );
			$rtwcpiglw_mpdf->SetHTMLHeader('', 'E');
		}
	}
    
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpng_lbl_footer_font_size') !='' ) {

			$rtwcpiglw_foo_font_size = get_option('rtwcpiglw_shpng_lbl_footer_font_size');
		} else {

			$rtwcpiglw_foo_font_size = 10;
		}
	}
	else if ($rtwcpiglw_pro_desc == 'credit_note') 
	{
		if( get_option('rtwcpiglw_credit_note_footer_font_size') !='' ) {

			$rtwcpiglw_foo_font_size = get_option('rtwcpiglw_credit_note_footer_font_size');
		} else {

			$rtwcpiglw_foo_font_size = 10;
		}
	}
	else
	{
		if( get_option('rtwcpiglw_footer_font_size') !='' ) {

			$rtwcpiglw_foo_font_size = get_option('rtwcpiglw_footer_font_size');
		} else {

			$rtwcpiglw_foo_font_size = 10;
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if(get_option('rtwcpiglw_shpng_lbl_footer_font_family') !='' ) {

			$rtwcpiglw_foo_family = get_option('rtwcpiglw_shpng_lbl_footer_font_family');
		} else {

			$rtwcpiglw_foo_family = 'sans-serif';
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if(get_option('rtwcpiglw_credit_note_footer_font_family') !='' ) {

			$rtwcpiglw_foo_family = get_option('rtwcpiglw_credit_note_footer_font_family');
		} else {

			$rtwcpiglw_foo_family = 'sans-serif';
		}
	}
	else
	{
		if(get_option('rtwcpiglw_footer_font_family') !='' ) {

			$rtwcpiglw_foo_family = get_option('rtwcpiglw_footer_font_family');
		} else {

			$rtwcpiglw_foo_family = 'sans-serif';
		}
	}

	$rtwcpiglw_mpdf->defaultfooterfontsize = $rtwcpiglw_foo_font_size;	/* in pts */
	$rtwcpiglw_mpdf->defaultfooterfontstyle = $rtwcpiglw_foo_family;	/* blank, B, I, or BI */
	$rtwcpiglw_mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */

	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		$shpng_footr_html = get_option( 'rtwcpiglw_shpng_lable_footer_setting_opt' );
		if( isset($shpng_footr_html['rtw_footer_html']) ) {
			$rtwcpiglw_footer_txt = $shpng_footr_html['rtw_footer_html'];
		} else {
			$rtwcpiglw_footer_txt = '';
		}
	}
	else
	{
		$invoice_footr_html = get_option( 'rtwcpiglw_footer_setting_opt' );
		if( isset($invoice_footr_html['rtw_footer_html']) && !empty( $invoice_footr_html['rtw_footer_html'] ) ) {
			$rtwcpiglw_footer_txt = $invoice_footr_html['rtw_footer_html'];
		} else {
			$rtwcpiglw_footer_txt = '';
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if (get_option('rtwcpiglw_shpng_lbl_page_no') !='' && get_option('rtwcpiglw_shpng_lbl_page_no') == 'yes' ) {
			$rtwcpiglw_page_no = '' ;
		}else{
			$rtwcpiglw_page_no = '{PAGENO}/{nbpg}';
		}
	}
	else if ($rtwcpiglw_pro_desc == 'credit_note') 
	{
		if (get_option('rtwcpiglw_credit_note_page_no') !='' && get_option('rtwcpiglw_credit_note_page_no') == 'yes' ) {
			$rtwcpiglw_page_no = '' ;
		}else{
			$rtwcpiglw_page_no = '{PAGENO}/{nbpg}';
		}
	}
	else
	{
		if (get_option('rtwcpiglw_page_no') !='' && get_option('rtwcpiglw_page_no') == 'yes' ) {
			$rtwcpiglw_page_no = '' ;
		}else{
			$rtwcpiglw_page_no = '{PAGENO}/{nbpg}';
		}
	}
	

	/*
	*  $rtwcpiglw_footer_txt this variable is used for HTML 
	*/
	if( !empty($rtwcpiglw_footer_txt) )
	{
		$rtwcpiglw_mpdf->SetHTMLFooter( '<div style="width:100%;margin:0px;padding:0px;border-top: 2px solid #000000;"><div style="width: 92%;margin-top:'.esc_attr($rtwcpiglw_foo_top_marg).';font-size:'.esc_attr($rtwcpiglw_foo_font_size).';font-family:'.esc_attr($rtwcpiglw_foo_family).'">'.stripcslashes($rtwcpiglw_footer_txt).'</div><div style="width: ;margin:0px;padding:0px;float:;text-align:;font-size:'.esc_attr($rtwcpiglw_foo_font_size).';">'.$rtwcpiglw_page_no.'</div>', 'O' );
		$rtwcpiglw_mpdf->SetHTMLFooter( '<div style="width:100%;margin:0px;padding:0px;margin-top:2px;border-top: 2px solid #000000;padding-top:10px"><div style="width: 92%;margin-top:'.esc_attr($rtwcpiglw_foo_top_marg).';font-size:'.esc_attr($rtwcpiglw_foo_font_size).'">'.stripcslashes($rtwcpiglw_footer_txt).'</div><div style="width: 8%;margin:0px;padding:0px;float:;text-align:;font-size:'.esc_attr($rtwcpiglw_foo_font_size).';">'.$rtwcpiglw_page_no.'</div>', 'E' );
	}

	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		$shipping_watermrk = get_option('rtwcpiglw_shpng_lbl_watermark_setting_opt');
		if( isset($shipping_watermrk['rtwcpiglw_enable_shpng_lbl_text_watermark']) )
		{
			if( $shipping_watermrk['rtwcpiglw_shpng_lbl_watermark_font'] )
			{
				$rtwcpiglw_alpha=0.2;
				$rtwcpiglw_mpdf->SetWatermarkText( trim($shipping_watermrk['rtwcpiglw_shpng_lbl_watermark_font']),$rtwcpiglw_alpha );
				$rtwcpiglw_mpdf->showWatermarkText = true;
			}
		}
	}
	else
	{
		$watermark_opt = get_option('rtwcpiglw_watermark_setting_opt');
		if( isset($watermark_opt['rtwcpiglw_enable_text_watermark']) )
		{
			if( $watermark_opt['rtwcpiglw_watermark_text'] )
			{
				$rtwcpiglw_alpha=0.2;
				$rtwcpiglw_mpdf->SetWatermarkText( trim($watermark_opt['rtwcpiglw_watermark_text']),$rtwcpiglw_alpha );
				$rtwcpiglw_mpdf->showWatermarkText = true;
			}	
		}
		if( isset($watermark_opt['rtwcpiglw_enable_image_watermark']) )
		{
			if( $watermark_opt['rtwcpiglw_watermark_img_url'] )
			{
				$rtwcpiglw_alpha=0.2;
				$rtwcpiglw_mpdf->SetWatermarkImage($watermark_opt['rtwcpiglw_watermark_img_url'],$rtwcpiglw_alpha);
				$rtwcpiglw_mpdf->showWatermarkImage = true;
			}	
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		$watermark_opt = get_option('rtwcpiglw_shpng_lbl_watermark_setting_opt');
		if( isset($watermark_opt['rtwcpiglw_enable_shpng_lbl_image_watermark']) )
		{
			if ( $watermark_opt['rtwcpiglw_watermark_img_url'] ) {
				$rtwcpiglw_alpha_img = 0.2;
				$rtwcpiglw_mpdf->SetWatermarkImage($watermark_opt['rtwcpiglw_watermark_img_url'],$rtwcpiglw_alpha_img);
				$rtwcpiglw_mpdf->showWatermarkImage = true;
			}
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if( get_option('rtwcpiglw_enable_creditnote_image_watermark') !='' && get_option('rtwcpiglw_enable_creditnote_image_watermark') == 'yes' )
		{
			$credit_wtrmrk = get_option('rtwcpiglw_creditnote_watermark_setting_opt');
			if( !empty($credit_wtrmrk) && isset( $credit_wtrmrk ['rtwcpiglw_watermark_img_url'] ) )
			{
				$rtwcpiglw_alpha_img = 0.2;
				$rtwcpiglw_watermark_img_dim ='D';
				$rtwcpiglw_watermark_pos = 'P';
				$rtwcpiglw_mpdf->SetWatermarkImage($credit_wtrmrk ['rtwcpiglw_watermark_img_url'],$rtwcpiglw_alpha_img,$rtwcpiglw_watermark_img_dim , $rtwcpiglw_watermark_pos);
				$rtwcpiglw_mpdf->showWatermarkImage = true;
			}	
		}
	}
	else
	{
		if( get_option('rtwcpiglw_enable_image_watermark') !='' && get_option('rtwcpiglw_enable_image_watermark') == 'yes' )
		{
			if( isset( $rtwcpiglw_stng ['rtwcpiglw_watermark_img_url'] ) && !empty($rtwcpiglw_stng ['rtwcpiglw_watermark_img_url']) )
			{
				$rtwcpiglw_alpha_img = 0.2;
				$rtwcpiglw_watermark_img_dim ='D';
				$rtwcpiglw_watermark_pos = 'P';
				$rtwcpiglw_mpdf->SetWatermarkImage($rtwcpiglw_stng ['rtwcpiglw_watermark_img_url'],$rtwcpiglw_alpha_img,$rtwcpiglw_watermark_img_dim , $rtwcpiglw_watermark_pos);
				$rtwcpiglw_mpdf->showWatermarkImage = true;
			}	
		}
	}
	
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if( get_option('rtwcpiglw_shpng_lbl_rtl') != '' && get_option('rtwcpiglw_shpng_lbl_rtl') == 'yes'){
			$rtwcpiglw_mpdf->SetDirectionality('rtl');
		}else{
			$rtwcpiglw_mpdf->SetDirectionality('ltr');
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if( get_option('rtwcpiglw_credit_note_rtl') != '' && get_option('rtwcpiglw_credit_note_rtl') == 'yes'){
			$rtwcpiglw_mpdf->SetDirectionality('rtl');
		}else{
			$rtwcpiglw_mpdf->SetDirectionality('ltr');
		}
	}
	else
	{
		if( get_option('rtwcpiglw_rtl') != '' && get_option('rtwcpiglw_rtl') == 'yes'){
			$rtwcpiglw_mpdf->SetDirectionality('rtl');
		}else{
			$rtwcpiglw_mpdf->SetDirectionality('ltr');
		}
	}

	//$rtwcpiglw_mpdf->showImageErrors = true;
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		if ( !is_dir ( RTWCPIGLW_PDF_SHPNGLBL_DIR ) ) 
		{
			mkdir ( RTWCPIGLW_PDF_SHPNGLBL_DIR, 0777);
		}
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		if ( !is_dir ( RTWCPIGLW_CREDITNOTE_DIR ) ) 
		{
			mkdir ( RTWCPIGLW_CREDITNOTE_DIR, 0755, true );
		}
	}
	else
	{
		if ( !is_dir ( RTWCPIGLW_PDF_DIR ) ) 
		{
			mkdir ( RTWCPIGLW_PDF_DIR, 0755, true );
		}
	}
	try
	{ 
		$rtwcpiglw_mpdf->autoScriptToLang = true;
		$rtwcpiglw_mpdf->autoLangToFont = true;
		$rtwcpiglw_basic_stng = get_option('rtwcpiglw_basic_setting_opt');
		$shipping_labl_opt = get_option('rtwcpiglw_shipng_label_stng_opt');
		if ( $rtwcpiglw_pro_desc == 'Shipping_label' && isset($shipping_labl_opt['back_color']) ) {
			$rtwcpiglw_mpdf->SetDefaultBodyCSS('background-color', $shipping_labl_opt['back_color']);
		}
		else
		{
			$rtwcpiglw_mpdf->SetDefaultBodyCSS('background-color', $rtwcpiglw_basic_stng['back_color']);
		}
		$rtwcpiglw_pdf_html = do_shortcode( $rtwcpiglw_pdf_html );
		$rtwcpiglw_mpdf->WriteHTML($rtwcpiglw_pdf_html);
		$rtwcpiglw_mpdf->Output($rtwcpiglw_file_path,'F');	
	}
	catch( Exception $rtwcpiglw_excptn)
	{
		print_r($rtwcpiglw_excptn);
	}
	if( $rtwcpiglw_pro_desc == 'Shipping_label' )
	{
		$rtwcpiglw_Dir_path = RTWCPIGLW_PDF_DIR.'/rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_ordr_id.'.pdf';
		$rtwcpiglw_file_url = RTWCPIGLW_PDF_URL.'/rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_ordr_id.'.pdf';
	}
	else if ( $rtwcpiglw_pro_desc == 'credit_note' ) 
	{
		$rtwcpiglw_Dir_path = RTWCPIGLW_CREDITNOTE_DIR.$rtwcpiglw_ordr_id.'.pdf';
		$rtwcpiglw_file_url = RTWCPIGLW_CREDITNOTE_URL.$rtwcpiglw_ordr_id.'.pdf';
	}
	else
	{
		$rtwcpiglw_Dir_path = RTWCPIGLW_PDF_DIR.$pdf_name.$rtwcpiglw_ordr_id.'.pdf';
		$rtwcpiglw_file_url = RTWCPIGLW_PDF_URL.$pdf_name.$rtwcpiglw_ordr_id.'.pdf';
	}
	
	$rtwcpiglw_pdf_file_name = $pdf_name.$rtwcpiglw_ordr_id.'.pdf';
	
	$rtwcpiglw_pdf_invoice = array('dir_path' => $rtwcpiglw_Dir_path, 'file_url' => $rtwcpiglw_file_url);

	return $rtwcpiglw_pdf_invoice;
}

/**
 * function for convrt amount in words.
 *
 * @since    1.0.0
 * 
 */
function rtwcpiglw_convert_amount_in_words($rtwcpiglw_amount)
{
	if ( CURRENCY &&  CURRENCY != 'INR' ) 
	{
		$obj = new IndianCurrency($rtwcpiglw_amount);
		return $obj->get_words();
	}
	else
	{
		$hyphen      = '-';
    $conjunction = ' ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($rtwcpiglw_amount)) {
        return false;
    }

    if (($rtwcpiglw_amount >= 0 && (int) $rtwcpiglw_amount < 0) || (int) $rtwcpiglw_amount < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($rtwcpiglw_amount < 0) {
        return $negative . rtwcpiglw_convert_amount_in_words(abs($rtwcpiglw_amount));
    }

    $string = $fraction = null;

    if (strpos($rtwcpiglw_amount, '.') !== false) {
        list($rtwcpiglw_amount, $fraction) = explode('.', $rtwcpiglw_amount);
    }

    switch (true) {
        case $rtwcpiglw_amount < 21:
        
            $string = $dictionary[$rtwcpiglw_amount];
            break;
        case $rtwcpiglw_amount < 100:
        
            $tens   = ((int) ($rtwcpiglw_amount / 10)) * 10;
            $units  = $rtwcpiglw_amount % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $rtwcpiglw_amount < 1000:
       
            $hundreds  = $rtwcpiglw_amount / 100;
            $remainder = $rtwcpiglw_amount % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . rtwcpiglw_convert_amount_in_words($remainder);
            }
            break;
        default:
        
            $baseUnit = pow(1000, floor(log($rtwcpiglw_amount, 1000)));
            $numBaseUnits = (int) ($rtwcpiglw_amount / $baseUnit);
            $remainder = $rtwcpiglw_amount % $baseUnit;
            $string = rtwcpiglw_convert_amount_in_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= rtwcpiglw_convert_amount_in_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $rtwcpiglw_amount) {
            $words[] = $dictionary[$rtwcpiglw_amount];
        }
        $string .= implode(' ', $words);

    }

    return $string;
	}
}

/**
 * function for create packing slip for an order.
 *
 * @since    1.0.0
 */
function rtwcpiglw_create_pdf_packngslip($rtwcpiglw_ordr_no,$rtwcpiglw_ordr_obj)
{
	$rtwcpiglw_order = wc_get_order( $rtwcpiglw_ordr_no );
	$currency_code = $rtwcpiglw_ordr_obj->get_currency();
	define('CURRENCY', $currency_code);
	$rtwcpiglw_currency_symbol = get_woocommerce_currency_symbol( $currency_code );
	$tax_name = array();
	$rtwcpiglw_product_qty = array();
	$prod_qty[] = array();
	if ($rtwcpiglw_order->get_items( 'tax' ) != '') 
  	{
  		foreach ($rtwcpiglw_order->get_items( 'tax' ) as $rtwcpiglw_key => $rtwcpiglw_value) {
			$rtwcpiglw_item_type = $rtwcpiglw_value->get_type(); // Line item type
		    $rtwcpiglw_item_name = $rtwcpiglw_value->get_name(); // Line item name
		    $rtwcpiglw_rate_code = $rtwcpiglw_value->get_rate_code(); // Tax rate code
		    $rtwcpiglw_tax_rate_label[] = $rtwcpiglw_value->get_label(); // Tax label
		    $rtwcpiglw_tax_rate_id[] = $rtwcpiglw_value->get_rate_id(); // Tax rate ID
		    $rtwcpiglw_compound = $rtwcpiglw_value->get_compound(); // Tax compound
		    $rtwcpiglw_tax_amount_total = $rtwcpiglw_value->get_tax_total(); // Tax rate total
		    $rtwcpiglw_tax_shipping_total[] = $rtwcpiglw_value->get_shipping_tax_total();
		    $rtwcpiglw_total_tax_rate[] = $rtwcpiglw_value->get_rate_percent();
		}
  	}
	foreach( $rtwcpiglw_order->get_items() as $rtwcpiglw_item_key => $rtwcpiglw_item_values )
	{
		$prod_sku = new WC_Product($rtwcpiglw_item_values->get_product_id());
		if (  rtwcpiglw_woo_product_bundled_compatibility() ) 
		{
			if ( $prod_sku->get_sku() ) 
			{
				$rtwcpiglw_total_tax[] = $rtwcpiglw_item_values->get_total_tax();
				$rtwcpiglw_tax_class = $rtwcpiglw_item_values->get_tax_class(); // Tax class
				if ( $rtwcpiglw_tax_class !== '' ) 
				{
					$data[] = WC_Tax::get_rates_for_tax_class( $rtwcpiglw_tax_class );
					foreach ($data as $k => $val) {
						foreach ($rtwcpiglw_tax_rate_id as $key => $rate_id) {
							if ( isset($val[$rate_id]) && !empty($val[$rate_id]) ) {
								$tax_name[] = $val[$rate_id];
							}
						}
					}
				}else{
					$tax_name[] = '';
				}
				$rtwcpiglw_product_id[] = $rtwcpiglw_item_values->get_product_id();
				$qty[] = $rtwcpiglw_item_values->get_quantity();
				if ( !array_key_exists($rtwcpiglw_item_values->get_name(), $rtwcpiglw_product_qty) ) {
					$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
				}else{
					$rtwcpiglw_product_qty[' '.$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
				}
				$prod_qty[] = $rtwcpiglw_item_values->get_quantity();
				$rtwcpiglw_total_amnt[] = $rtwcpiglw_item_values->get_total();
				$rtwcpiglw_total_line_amnt[] = $rtwcpiglw_order->get_formatted_line_subtotal( $rtwcpiglw_item_values );
				$rtwcpiglw_prduct_vrtion_id = $rtwcpiglw_item_values->get_variation_id();
    		if ($rtwcpiglw_prduct_vrtion_id){
    			$rtwcpiglw_prduct = new WC_Product_Variation($rtwcpiglw_item_values->get_variation_id());
    		}else{
    			$rtwcpiglw_prduct = new WC_Product($rtwcpiglw_item_values->get_product_id());
    		}
    		$rtwcpiglw_sku[] = $rtwcpiglw_prduct->get_sku();
			}
		}
		else
		{
			$rtwcpiglw_total_tax[] = $rtwcpiglw_item_values->get_total_tax();
			$rtwcpiglw_tax_class = $rtwcpiglw_item_values->get_tax_class(); // Tax class
			if ( $rtwcpiglw_tax_class !== '' ) 
			{
				$data[] = WC_Tax::get_rates_for_tax_class( $rtwcpiglw_tax_class );
				foreach ($data as $k => $val) {
					foreach ($rtwcpiglw_tax_rate_id as $key => $rate_id) {
						if ( isset($val[$rate_id]) && !empty($val[$rate_id]) ) {
							$tax_name[] = $val[$rate_id];
						}
					}
				}
			}else{
				$tax_name[] = '';
			}
			$prod_qty[] = $rtwcpiglw_item_values->get_quantity();
			$rtwcpiglw_product_id[] = $rtwcpiglw_item_values->get_product_id();
			if ( !array_key_exists($rtwcpiglw_item_values->get_name(), $rtwcpiglw_product_qty) ) {
				$rtwcpiglw_product_qty[$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
			}else{
				$rtwcpiglw_product_qty[' '.$rtwcpiglw_item_values->get_name()] = $rtwcpiglw_item_values->get_quantity();
			}
			$rtwcpiglw_total_amnt[] = $rtwcpiglw_item_values->get_total();
			$rtwcpiglw_total_line_amnt[] = $rtwcpiglw_order->get_formatted_line_subtotal( $rtwcpiglw_item_values );
			$rtwcpiglw_prduct_vrtion_id = $rtwcpiglw_item_values->get_variation_id();
  		if ($rtwcpiglw_prduct_vrtion_id){
  			$rtwcpiglw_prduct = new WC_Product_Variation($rtwcpiglw_item_values->get_variation_id());
  		}else{
  			$rtwcpiglw_prduct = new WC_Product($rtwcpiglw_item_values->get_product_id());
  		}
  		$rtwcpiglw_sku[] = $rtwcpiglw_prduct->get_sku();
    	}
  	}
	 

  	if ( !empty($tax_name) ) {
  		$tax_string = array();
  		foreach ($tax_name as $name_key => $name_value) {
  			if ( is_object($name_value) && !empty($name_value) ) {
  				$tax_string[] = $name_value->tax_rate_name.' ( '.(int)$name_value->tax_rate.'% )';
  			}
  		}
  	}else{
  		$tax_string[] = '0.00%';
  	}
	
	$width = get_option('rtwcpiglw_prod_img_width');
	$height = get_option('rtwcpiglw_prod_img_height');
	if ( $width == '' ) {
		$width = 50;
	}
	if ( $height == '' ) {
		$height = 50;
	}
	if ($rtwcpiglw_order->get_items() != '') {
		foreach( $rtwcpiglw_order->get_items() as $rtwcpiglw_item_id => $rtwcpiglw_item ) {
			$rtwcpiglw_prodct_price[] = ( $rtwcpiglw_item->get_total()/$rtwcpiglw_item->get_quantity() );
			$rtwcpiglw_product = apply_filters( 'woocommerce_order_item_product', $rtwcpiglw_order->get_product_from_item( $rtwcpiglw_item ), $rtwcpiglw_item );
			if ( $rtwcpiglw_product->get_variation_id() ) {
				$rtwcpiglw_product = new WC_Product_Variation($rtwcpiglw_item->get_variation_id());
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


	$rtwcpiglw_pckng_slp_formt = get_option('pckng_slp_format');
	if( $rtwcpiglw_pckng_slp_formt == '')
	{
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
		
		$rtwcpiglw_pckng_slp_formt = '
		<table class="invhead" style="width: 100%; font-size: 14px; border: none;">
			<tbody>
				<tr>
					<td style="width: 40%; border: none; padding: 15px;">
						<div class="rtwcpig-logo"><img class="alignnone" style="margin-bottom: 15px;" alt="shop logo" width="100" height="100" /></div>
						</td>
						<td style="width: 60%; border: none; padding: 15px;">
						<p style="margin: 5px 0;"><span style="display: inline-block; width: 120px;">Order No:</span> [order_id]</p>
						<p style="margin: 5px 0;"><span style="display: inline-block; width: 120px;">Order Date:</span> [order_date]</p>
						<p style="margin: 5px 0;"><span style="display: inline-block; width: 120px;">Total Items:</span> [total_items]</p>
						<p style="margin: 5px 0;"><span style="display: inline-block; width: 120px;">Total Products:</span> [total_products]</p>
						<p style="margin: 5px 0;"><span style="display: inline-block; width: 120px;">Order Amount:</span> [order_amount]</p>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="rtwcpig-invoice-wrapper"><br />
			<table style="width: 100%; border-collapse: collapse; border: 1px solid #b08c77; font-size: 13px;">
				<thead>
					<tr>
						<th style="color: #000000; padding: 15px 10px; font-weight: bold; margin: 5px 5px 5px 0px; text-align: left; border: 1px solid #b08c77; background-color: #5ee3b6; font-size: 15px;">Seller Address</th>
						<th style="color: #000000; padding: 15px 10px; font-weight: bold; margin: 5px 5px 5px 0px; text-align: left; border: 1px solid #b08c77; background-color: #5ee3b6; font-size: 15px;">Billing Address</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width: 50%; border: 1px solid #b08c77; padding: 10px;">
							<p><strong>RedefiningTheWeb</strong></p>
							<p>100 MAIN ST. SEATTLE WA,98104, USA</p>
							<p>www.redefiningtheweb.com</p>
							<p>Phone: 987-654-032</p>
							<p>E-mail: developer@redefiningtheweb.com</p>
							</td>
							<td style="width: 50%; border: 1px solid #b08c77; padding: 10px;">
							<p style="margin: 5px 0;">[billing_first_name] [billing_last_name]</p>
							<p style="margin: 5px 0;">[billing_address_1] , [billing_address_2], [billing_city], [billing_state], [billing_country], [billing_postcode]</p>
							<p style="margin: 5px 0;">[billing_email]</p>
							<p>[billing_phone]</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="margin-top: 40px; color: #444444;">
			<table id="rtwcpiglw_prod_table" style="width: 100%; border-collapse: collapse; font-size: 13px; border: 1px solid #b08c77;">
				<thead>
					<tr>
						<th style="width: 100px; font-size: 15px; padding: 15px 10px; text-align: left; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Line No.</th>
						<th style="width: 150px; padding: 15px 10px; text-align: left; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Product SKU</th>
						<th style="width: 110px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Product</th>
						<th style="width: 110px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Price</th>
						<th style="width: 110px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Tax Amount</th>
						<th style="width: 110px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Quantity</th>
						<th style="width: 110px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Line Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="padding: 10px; border-bottom: 2px solid #dddddd; text-align: left; color: #444444;">[line_number]</td>
						<td style="padding: 10px; border-bottom: 2px solid #dddddd; text-align: left; color: #444444;">[product_sku]</td>
						<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[product_name]</td>
						<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[product_price]</td>
						<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[tax_amount]</td>
						<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[product_qty]</td>
						<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[line_total]</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="width: 100%; float: left; font-size: 11px;"><hr />
			<p>Terms &amp; Conditions:</p>
			<ol>
				<li>Goods once sold can be exchanged within 7 days of delivery.</li>
				<li>No cash refund.</li>
			</ol>
			<p>Please joins us on Facebook at https://www.facebook.com/RedefiningTheWeb/</p>
		</div>';
	}
	

	$rtwcpiglw_data = array();

	$rtwcpiglw_data['shipping_method'] = $rtwcpiglw_ordr_obj->get_shipping_method();

	$rtwcpiglw_data['shipping_first_name'] =	$rtwcpiglw_ordr_obj->get_shipping_first_name();
	if( $rtwcpiglw_data['shipping_first_name'] == '' )
	{
		$rtwcpiglw_data['shipping_first_name'] = $rtwcpiglw_ordr_obj->get_billing_first_name();
	}

	$rtwcpiglw_data['shipping_last_name'] = $rtwcpiglw_ordr_obj->get_shipping_last_name();
	if( $rtwcpiglw_data['shipping_last_name'] == '' )
	{
		$rtwcpiglw_data['shipping_last_name'] = $rtwcpiglw_ordr_obj->get_billing_last_name();
	}
	$rtwcpiglw_data['shipping_company'] = $rtwcpiglw_ordr_obj->get_shipping_company();
	if( $rtwcpiglw_data['shipping_company'] == '' )
	{
		$rtwcpiglw_data['shipping_company'] = $rtwcpiglw_ordr_obj->get_billing_company();
	}
	$rtwcpiglw_data['shipping_address_1'] = $rtwcpiglw_ordr_obj->get_shipping_address_1();
	if( $rtwcpiglw_data['shipping_address_1'] == '' )
	{
		$rtwcpiglw_data['shipping_address_1'] = $rtwcpiglw_ordr_obj->get_billing_address_1();
	}
	$rtwcpiglw_data['shipping_address_2'] = $rtwcpiglw_ordr_obj->get_shipping_address_2();
	if( $rtwcpiglw_data['shipping_address_2'] == '' )
	{
		$rtwcpiglw_data['shipping_address_2'] = $rtwcpiglw_ordr_obj->get_billing_address_2();
	}
	$rtwcpiglw_data['shipping_city'] = $rtwcpiglw_ordr_obj->get_shipping_city();
	if( $rtwcpiglw_data['shipping_city'] == '' )
	{
		$rtwcpiglw_data['shipping_city'] = $rtwcpiglw_ordr_obj->get_billing_city();
	}
	$rtwcpiglw_data['shipping_state'] = $rtwcpiglw_ordr_obj->get_shipping_state();
	if( $rtwcpiglw_data['shipping_state'] == '' )
	{
		$rtwcpiglw_data['shipping_state'] = $rtwcpiglw_ordr_obj->get_billing_state();
	}
	$rtwcpiglw_data['shipping_postcode'] = $rtwcpiglw_ordr_obj->get_shipping_postcode();
	if( $rtwcpiglw_data['shipping_postcode'] == '' )
	{
		$rtwcpiglw_data['shipping_postcode'] = $rtwcpiglw_ordr_obj->get_billing_postcode();
	}
	$rtwcpiglw_data['shipping_country'] = $rtwcpiglw_ordr_obj->get_shipping_country();
	if( $rtwcpiglw_data['shipping_country'] == '' )
	{
		$rtwcpiglw_data['shipping_country'] = $rtwcpiglw_ordr_obj->get_billing_country();
	}
	
	$rtwcpiglw_data['billing_first_name'] = $rtwcpiglw_ordr_obj->get_billing_first_name();
	$rtwcpiglw_data['billing_last_name'] = $rtwcpiglw_ordr_obj->get_billing_last_name();
	$rtwcpiglw_data['billing_address_1'] = $rtwcpiglw_ordr_obj->get_billing_address_1();
	$rtwcpiglw_data['billing_address_2'] = $rtwcpiglw_ordr_obj->get_billing_address_2();
	$rtwcpiglw_data['billing_city'] = $rtwcpiglw_ordr_obj->get_billing_city();
	$rtwcpiglw_data['billing_state'] = $rtwcpiglw_ordr_obj->get_billing_state();
	$rtwcpiglw_data['billing_postcode'] = $rtwcpiglw_ordr_obj->get_billing_postcode();
	$rtwcpiglw_data['billing_email'] = $rtwcpiglw_ordr_obj->get_billing_email();
	$rtwcpiglw_data['billing_phone'] = $rtwcpiglw_ordr_obj->get_billing_phone();
	$rtwcpiglw_data['billing_country'] = $rtwcpiglw_ordr_obj->get_billing_country();
	$rtwcpiglw_data['order_amount'] = $rtwcpiglw_ordr_obj->get_total();
	$rtwcpiglw_data['customer_note'] = $rtwcpiglw_ordr_obj->get_customer_note();
	$rtwcpiglw_data['payment_method'] = $rtwcpiglw_ordr_obj->get_payment_method_title();
	
	$rtwcpiglw_data['total_amnt_in_words'] = rtwcpiglw_convert_amount_in_words($rtwcpiglw_ordr_obj->get_total())."Only";

	$rtwcpiglw_shpng_total  = $rtwcpiglw_ordr_obj->get_shipping_total();
	
	if ( $rtwcpiglw_shpng_total == '' ) {
		$rtwcpiglw_shpng_total = 0.00;
	}
	$rtwcpiglw_shipping_tax = $rtwcpiglw_order->get_shipping_tax();
	if ( $rtwcpiglw_shipping_tax == '' ) {
		$rtwcpiglw_shipping_tax = 0.00;
	}
	$rtwcpiglw_shpng_amnt   = ( $rtwcpiglw_shpng_total + $rtwcpiglw_shipping_tax );
	if ( $rtwcpiglw_ordr_obj->get_total_tax() == '' ) {
		$get_total_tax = 0.00;
	}else{
		$get_total_tax = $rtwcpiglw_ordr_obj->get_total_tax();
	}
	$rtwcpiglw_data['subtotal_amount'] = ( (int)$rtwcpiglw_ordr_obj->get_total() - (int)($rtwcpiglw_shpng_amnt + $get_total_tax) );
	$rtwcpiglw_order = wc_get_order( $rtwcpiglw_ordr_no );
	$rtwcpiglw_order_data = $rtwcpiglw_order->get_data();
	$rtwcpiglw_data['order_date'] = $rtwcpiglw_order_data['date_created']->date('d-m-Y H:i:s');
	if(rtwcpiglw_woo_seq_order_no_compatibility()) {
		$rtwcpiglw_data['order_id'] = (string) apply_filters( 'woocommerce_order_number', $rtwcpiglw_ordr_no , $rtwcpiglw_ordr_obj);
	}else{
		$rtwcpiglw_data['order_id'] = $rtwcpiglw_ordr_no;
	}
	$rtwcpiglw_data['total_items'] = $rtwcpiglw_order->get_item_count();
	$rtwcpiglw_data['total_qty'] = $total_qty;
	$rtwcpiglw_data['total_products'] = count(WC()->cart->get_cart());

	$rtwcpiglw_pckng_slp_formt = stripslashes($rtwcpiglw_pckng_slp_formt);

	if($rtwcpiglw_pckng_slp_formt != '')
	{	
		foreach ($rtwcpiglw_data as $rtwcpiglw_k => $rtwcpiglw_v) 
		{
			if ($rtwcpiglw_k == 'order_amount' ) 
			{
				$rtwcpiglw_v = $rtwcpiglw_currency_symbol.' '.($rtwcpiglw_v);
				$rtwcpiglw_pckng_slp_formt = str_replace('['.$rtwcpiglw_k.']', $rtwcpiglw_v, $rtwcpiglw_pckng_slp_formt);
			}
			$rtwcpiglw_pckng_slp_formt = str_replace('['.$rtwcpiglw_k.']', $rtwcpiglw_v, $rtwcpiglw_pckng_slp_formt);
		}
	}
	if (! class_exists ( 'simple_html_dom_node' )) 
	{
		require_once (RTWCPIGLW_DIR .'/includes/simplehtmldom/simple_html_dom.php');
	}

	$rtwcpiglw_pckng_slp_formt = htmlspecialchars_decode ( htmlentities ( $rtwcpiglw_pckng_slp_formt, ENT_NOQUOTES, 'UTF-8', false ), ENT_NOQUOTES );
	$rtwcpiglw_count = 0;
	$line_numb = 1;
	$rtwcpiglw_string2 = '';
	$rtwcpiglw_dom = new simple_html_dom ();
	$rtwcpiglw_dom->load ( $rtwcpiglw_pckng_slp_formt );
	$rtwcpiglw_prod_tr = '';
	$rtwcpiglw_count = 0;
	foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody tr') as $val) 
	{
		$rtwcpiglw_prod_tr = $val->outertext;
	}
	$rtwcpiglw_prod_tr_final = '';

	$rtwcpiglw_count = 0; 
	$line_numb = 1 ; 

	if ($rtwcpiglw_product_qty != '') 
	{
		foreach ($rtwcpiglw_product_qty as $key => $value) 
		{
			$rtwcpiglw_prod_tr_final .= str_replace(array('[line_number]','[product_sku]','[product_name]','[product_price]','[tax_amount]','[product_qty]','[line_total]'), array($line_numb,$rtwcpiglw_sku[$rtwcpiglw_count],$key,$rtwcpiglw_currency_symbol.' '.wc_format_decimal($rtwcpiglw_prodct_price[$rtwcpiglw_count],2),$rtwcpiglw_total_tax[$rtwcpiglw_count],$value,$rtwcpiglw_currency_symbol.' '.wc_format_decimal(($rtwcpiglw_prodct_price[$rtwcpiglw_count] * $value),2)), $rtwcpiglw_prod_tr);
			$rtwcpiglw_count = ++$rtwcpiglw_count;
			$line_numb = ++$line_numb;
		}
	}

	$rtwcpiglw_dom = new simple_html_dom ();
	$rtwcpiglw_dom->load ( $rtwcpiglw_pckng_slp_formt );
	foreach ($rtwcpiglw_dom->find('#rtwcpiglw_prod_table tbody') as $val) 
	{
		$val->outertext = $rtwcpiglw_prod_tr_final;
	}

	$rtwcpiglw_pckng_slp_formt = $rtwcpiglw_dom->save();
	$rtwcpiglw_pdf_pckngslp = rtwcpiglw_convert_pckng_slp_to_pdf($rtwcpiglw_pckng_slp_formt, $rtwcpiglw_ordr_no);
}

/**
 * function for create pdf for paking slip.
 *
 * @since    1.0.0
 */
function rtwcpiglw_convert_pckng_slp_to_pdf($rtwcpiglw_pdf_html, $rtwcpiglw_ordr_id)
{
	$rtwcpiglw_file_path = RTWCPIGLW_PDF_PCKNGSLP_DIR . '/rtwcpiglw_'.$rtwcpiglw_ordr_id.'.pdf';
	$rtwcpiglw_pdf_html .= '<style>';
	
	if (get_option('rtwcpiglw_pckngslp_pdf_css') != '')
	{
		$rtwcpiglw_pdf_html .= get_option('rtwcpiglw_pckngslp_pdf_css');
	}
	$rtwcpiglw_pdf_html .= '</style>';
	
	if( get_option('rtwcpiglw_pckngslp_css_setting_opt') != '')
	{ 
		$rtwcpiglw_page = get_option('rtwcpiglw_pckngslp_css_setting_opt');
		$rtwcpiglw_page_size = $rtwcpiglw_page['rtwcpiglw_pdf_page_size'];
	}
	else
	{
		$rtwcpiglw_page_size = serialize(array(210,297));
	}
	if( get_option('rtwcpiglw_pckngslp_page_orien') != '' ) {
		$rtwcpiglw_page_orientation = get_option('rtwcpiglw_pckngslp_page_orien');
	} else {
		$rtwcpiglw_page_orientation = 'P';
	}
	if( get_option('rtwcpiglw_pckngslp_body_left_margin') !='' ) {
		$rtwcpiglw_lft_marg = get_option('rtwcpiglw_pckngslp_body_left_margin');	
	} else {
		$rtwcpiglw_lft_marg = 15;
	}
	if( get_option('rtwcpiglw_pckngslp_body_right_margin') !='' ) {
		$rtwcpiglw_rgt_marg = get_option('rtwcpiglw_pckngslp_body_right_margin');	
	} else {
		$rtwcpiglw_rgt_marg = 15;
	}
	if( get_option('rtwcpiglw_pckngslp_body_top_margin') !='' ) {
		$rtwcpiglw_top_marg = get_option('rtwcpiglw_pckngslp_body_top_margin');	
	} else {
		$rtwcpiglw_top_marg = 15;
	}
	if( get_option('rtwcpiglw_pckngslp_header_top_margin') !='' ) {
		$rtwcpiglw_hdr_top_marg = get_option('rtwcpiglw_pckngslp_header_top_margin');	
	} else {
		$rtwcpiglw_hdr_top_marg = 7;
	}
	/*PDF footer top margin*/
	if( get_option('rtwcpiglw_pckngslp_footer_top_margin') !='' ) {
		$rtwcpiglw_foo_top_marg = get_option('rtwcpiglw_pckngslp_footer_top_margin');	
	} else {
		$rtwcpiglw_foo_top_marg = 15;
	}
	if( get_option('rtwcpiglw_pckngslp_body_font_family') !='' ) {
		$rtwcpiglw_body_font_family = get_option('rtwcpiglw_pckngslp_body_font_family');
	} else{
		$rtwcpiglw_body_font_family = "dejavusanscondensed";
	}
	if(get_option('rtwcpiglw_pckngslp_body_font_size') !='' ) {
		$rtwcpiglw_body_font_size = get_option('rtwcpiglw_pckngslp_body_font_size');
	} else{
		$rtwcpiglw_body_font_size = 10;
	}
	include(RTWCPIGLW_DIR ."includes/mpdf/autoload.php"); 
	$rtwcpiglw_mpdf = new \Mpdf\Mpdf( ['mode' => 'utf-8', 'format' => unserialize( $rtwcpiglw_page_size ), 'default_font_size' => $rtwcpiglw_body_font_size, 'default_font' => $rtwcpiglw_body_font_family, 'margin_left' => $rtwcpiglw_lft_marg, 'margin_right' => $rtwcpiglw_rgt_marg, 'margin_top' => $rtwcpiglw_top_marg, 'margin_bottom' => '20', 'margin_header' => $rtwcpiglw_hdr_top_marg, 'margin_footer' => $rtwcpiglw_foo_top_marg, 'orientation' => $rtwcpiglw_page_orientation ]);
	$rtwcpiglw_mpdf->setAutoTopMargin = 'stretch';
	$rtwcpiglw_mpdf->setAutoBottomMargin = 'stretch';
	$rtwcpiglw_mpdf->SetDisplayMode('fullpage');
	if( get_option('rtwcpiglw_pkngslp_header_font_size') !='' ) {
		$rtwcpiglw_hdr_font_size = get_option('rtwcpiglw_pkngslp_header_font_size');
	} else {
		$rtwcpiglw_hdr_font_size = 20;
	}
	if( get_option('rtwcpiglw_pkngslp_header_font') !='' ) {
		$rtwcpiglw_hdr_font_family = get_option('rtwcpiglw_pkngslp_header_font');
	} else{
		$rtwcpiglw_hdr_font_family = 'sans-serif';
	}
	$rtwcpiglw_mpdf->defaultheaderfontsize = $rtwcpiglw_hdr_font_size;
	$rtwcpiglw_mpdf->defaultheaderfontstyle = $rtwcpiglw_hdr_font_family;
	$rtwcpiglw_mpdf->defaultheaderline = 1;
	$rtwcpiglw_site_name=get_bloginfo ( 'name' );
	$rtwcpiglw_site_desc=get_bloginfo ( 'description' );
	$rtwcpiglw_site_url=home_url();

	//***$rtwcpiglw_stng['rtw_header_html'] this variable is used for HTML***//

	if(get_option('rtwcpiglw_pkngslp_header_stng_opt') != '')
	{
		$rtwcpiglw_hedr = get_option('rtwcpiglw_pkngslp_header_stng_opt');
		$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.$rtwcpiglw_hedr['rtw_header_html'].'</h2></div>', 'O' );
		$rtwcpiglw_mpdf->SetHTMLHeader('<div style="border-bottom: 2px solid #000000;padding-bottom:12px"><h2 style="margin-top:'.esc_attr($rtwcpiglw_hdr_top_marg).';padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.$rtwcpiglw_stng['rtw_header_html'].'</h2></div>', 'E');
	}
	else
	{
		$rtwcpiglw_mpdf->SetHTMLHeader('<div style="width:100%;height:70px;border-bottom: 2px solid #000000;"><div style="float:left;"><h2 style="margin:0px;padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.$rtwcpiglw_site_name.'</h2><p style="margin:0px;padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.esc_html__($rtwcpiglw_site_desc, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce').'</p><p style="margin:0px;padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.$rtwcpiglw_site_url.'</p></div></div>','O');
		$rtwcpiglw_mpdf->SetHTMLHeader('<div style="width:100%;height:70px;border-bottom: 2px solid #000000;"><div style="float:left;"><h2 style="margin:0px;padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.$rtwcpiglw_site_name.'</h2><p style="margin:0px;padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.esc_html__($rtwcpiglw_site_desc, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce').'</p><p style="margin:0px;padding:0px;font-size:'.esc_attr($rtwcpiglw_hdr_font_size).'px;font-family:'.esc_attr($rtwcpiglw_hdr_font_family).';">'.$rtwcpiglw_site_url.'</p></div></div>','E');
	}
	if( get_option('rtwcpiglw_pckngslp_footer_font_size') !='' ) {
		$rtwcpiglw_foo_font_size = get_option('rtwcpiglw_pckngslp_footer_font_size');
	} else {
		$rtwcpiglw_foo_font_size = 10;
	}
	if(get_option('rtwcpiglw_pckngslp_footer_font_family') !='' ) {
		$rtwcpiglw_foo_family = get_option('rtwcpiglw_pckngslp_footer_font_family');
	} else {
		$rtwcpiglw_foo_family = 'sans-serif';
	}
	$rtwcpiglw_mpdf->defaultfooterfontsize = $rtwcpiglw_foo_font_size;	/* in pts */
	$rtwcpiglw_mpdf->defaultfooterfontstyle = $rtwcpiglw_foo_family;	/* blank, B, I, or BI */
	$rtwcpiglw_mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */
	if( get_option('rtwcpiglw_pckngslp_footer_setting_opt') != '') {
		$rtwcpiglw_footer = get_option('rtwcpiglw_pckngslp_footer_setting_opt');
		$rtwcpiglw_footer_txt = $rtwcpiglw_footer['rtw_footer_html'];
	} else {
		$rtwcpiglw_footer_txt = '';
	}
	if (get_option('rtwcpiglw_pkng_slp_page_no') !='' && get_option('rtwcpiglw_pkng_slp_page_no') == 'yes' ) 
	{
		$rtwcpiglw_page_no = '' ;
	}
	else
	{
		$rtwcpiglw_page_no = '{PAGENO}/{nbpg}';
	}
	//***  $rtwcpiglw_footer_txt this variable is used for HTML ***//
	$rtwcpiglw_mpdf->SetHTMLFooter( '<div style="width:100%;margin:0px;padding:0px;border-top: 2px solid #000000;"><div style="width: 92%;margin-top:'.esc_attr($rtwcpiglw_foo_top_marg).';font-size:'.esc_attr($rtwcpiglw_foo_font_size).';font-family:'.esc_attr($rtwcpiglw_foo_family).'">'.$rtwcpiglw_footer_txt.'</div><div style="width: ;margin:0px;padding:0px;float:;text-align:;">'.$rtwcpiglw_page_no.'</div>', 'O' );
	$rtwcpiglw_mpdf->SetHTMLFooter( '<div style="width:100%;margin:0px;padding:0px;margin-top:2px;border-top: 2px solid #000000;padding-top:10px"><div style="width: 92%;margin-top:'.esc_attr($rtwcpiglw_foo_top_marg).';font-size:'.esc_attr($rtwcpiglw_foo_font_size).'">'.$rtwcpiglw_footer_txt.'</div><div style="width: 8%;margin:0px;padding:0px;float:;text-align:;">'.$rtwcpiglw_page_no.'</div>', 'E' );
	$pckngslp_watrmrk = get_option('rtwcpiglw_pckngslp_watermark_setting_opt');
	if( isset($pckngslp_watrmrk['rtwcpiglw_enable_pckngslp_text_watermark']) )
	{
		if( $pckngslp_watrmrk['rtwcpiglw_watermark_text'] != '' )
		{
			$rtwcpiglw_alpha = 0.2;
			$rtwcpiglw_mpdf->SetWatermarkText( trim($pckngslp_watrmrk['rtwcpiglw_watermark_text']),$rtwcpiglw_alpha );
			$rtwcpiglw_mpdf->showWatermarkText = true;
		}	
	}
	if( isset($pckngslp_watrmrk['rtwcpiglw_enable_pckngslp_text_watermark']) )
	{
		if( $pckngslp_watrmrk['rtwcpiglw_watermark_img_url'] != '' )
		{
			$rtwcpiglw_alpha = 0.2;
			$rtwcpiglw_mpdf->SetWatermarkImage( trim($pckngslp_watrmrk['rtwcpiglw_watermark_img_url']),$rtwcpiglw_alpha );
			$rtwcpiglw_mpdf->showWatermarkImage = true;
		}	
	}
	if( get_option('rtwcpiglw_pkng_slp_rtl') != '' && get_option('rtwcpiglw_pkng_slp_rtl') == 'yes')
	{
		$rtwcpiglw_mpdf->SetDirectionality('rtl');
	}
	else
	{
		$rtwcpiglw_mpdf->SetDirectionality('ltr');
	}
	//$rtwcpiglw_mpdf->showImageErrors = true;
	if ( !is_dir ( RTWCPIGLW_PDF_PCKNGSLP_DIR ) ) 
	{
		mkdir ( RTWCPIGLW_PDF_PCKNGSLP_DIR, 0755, true );
	}
	$rtwcpiglw_bck_img = get_option('rtwcpiglw_pkngslp_basic_stng_opt');
	$rtwcpiglw_bck_img_url = $rtwcpiglw_bck_img['bck_img_url'];
	$rtwcpiglw_bck_color = $rtwcpiglw_bck_img['back_color'];
	try
	{ 
		$rtwcpiglw_mpdf->SetDefaultBodyCSS('background', "url(".$rtwcpiglw_bck_img_url.")");
		$rtwcpiglw_mpdf->autoScriptToLang = true;
		$rtwcpiglw_mpdf->autoLangToFont = true;
		$rtwcpiglw_mpdf->SetDefaultBodyCSS('background-image-resize', 6);
		$rtwcpiglw_mpdf->SetDefaultBodyCSS('background-color', $rtwcpiglw_bck_color);
		$rtwcpiglw_pdf_html = do_shortcode( $rtwcpiglw_pdf_html );
		$rtwcpiglw_mpdf->WriteHTML($rtwcpiglw_pdf_html);
		$rtwcpiglw_mpdf->Output($rtwcpiglw_file_path,'F');	
	}
	catch( Exception $rtwcpiglw_excptn)
	{
		print_r($rtwcpiglw_excptn);
	}
	$rtwcpiglw_Dir_path = RTWCPIGLW_PDF_PCKNGSLP_DIR . '/packing_slip/rtwcpiglw_'.$rtwcpiglw_ordr_id.'.pdf';
	$rtwcpiglw_file_url = RTWCPIGLW_PDF_PCKNGSLP_URL . '/packing_slip/rtwcpiglw_'.$rtwcpiglw_ordr_id.'.pdf';
	$rtwcpiglw_pdf_file_name = 'rtwcpiglw_'.$rtwcpiglw_ordr_id.'.pdf';
	$rtwcpiglw_pdf_1 = array('dir_path' => $rtwcpiglw_Dir_path, 'file_url' => $rtwcpiglw_file_url);
	return $rtwcpiglw_pdf_1;
}

//Convert Number to Indian Currency Format
if(!class_exists('IndianCurrency'))
{
	class IndianCurrency
	{

	public function __construct($amount){
		$this->amount=$amount;
		$this->hasPaisa=false;
		$arr=explode(".",$this->amount);
		$this->rupees=$arr[0];
		if(isset($arr[1])&&((int)$arr[1])>0){
		if(strlen($arr[1])>2){
			$arr[1]=substr($arr[1],0,2);
		}
		$this->hasPaisa=true;
		$this->paisa=$arr[1];
		}
	}
	
	public function get_words(){
		$w="";
		$crore=(int)($this->rupees/10000000);
		$this->rupees=$this->rupees%10000000;
		$w.=$this->single_word($crore,"Cror ");
		$lakh=(int)($this->rupees/100000);
		$this->rupees=$this->rupees%100000;
		$w.=$this->single_word($lakh,"Lakh ");
		$thousand=(int)($this->rupees/1000);
		$this->rupees=$this->rupees%1000;
		$w.=$this->single_word($thousand,"Thousand  ");
		$hundred=(int)($this->rupees/100);
		$w.=$this->single_word($hundred,"Hundred ");
		$ten=$this->rupees%100;
		$w.=$this->single_word($ten,"");
		$w.="Rupees ";
		if($this->hasPaisa){
		if($this->paisa[0]=="0"){
			$this->paisa=(int)$this->paisa;
		}
		else if(strlen($this->paisa)==1){
			$this->paisa=$this->paisa*10;
		}
		$w.=" and ".$this->single_word($this->paisa," Paisa");
		}
		return $w." Only";
	}

	private function single_word($n,$txt){
		$t="";
		if($n<=19){
		$t=$this->words_array($n);
		}else{
		$a=$n-($n%10);
		$b=$n%10;
		$t=$this->words_array($a)." ".$this->words_array($b);
		}
		if($n==0){
		$txt="";
		}
		return $t." ".$txt;
	}

	private function words_array($num){
		$n=[0=>"", 1=>"One", 2=>"Two", 3=>"Three", 4=>"Four", 5=>"Five", 6=>"Six", 7=>"Seven", 8=>"Eight", 9=>"Nine", 10=>"Ten", 11=>"Eleven", 12=>"Twelve", 13=>"Thirteen", 14=>"Fourteen", 15=>"Fifteen", 16=>"Sixteen", 17=>"Seventeen", 18=>"Eighteen", 19=>"Nineteen", 20=>"Twenty", 30=>"Thirty", 40=>"Forty", 50=>"Fifty", 60=>"Sixty", 70=>"Seventy", 80=>"Eighty", 90=>"Ninety", 100=>"Hundred",];
		return $n[$num];
	}
	}
}

?>