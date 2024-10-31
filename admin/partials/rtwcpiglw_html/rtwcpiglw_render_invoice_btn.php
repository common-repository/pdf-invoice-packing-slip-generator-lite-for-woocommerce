<?php

use Automattic\WooCommerce\Utilities\OrderUtil;
		$pdf_name_option = get_option( 'rtwcpiglw_basic_setting_opt' );
		if ( isset($pdf_name_option) && $pdf_name_option['rtwcpiglw_custm_pdf_name'] != '') {
			$pdf_name = $pdf_name_option['rtwcpiglw_custm_pdf_name'];
		}else{
			$pdf_name = 'rtwcpiglw_';
		}
if(OrderUtil::custom_orders_table_usage_is_enabled()){
	$rtwcpiglw_order = wc_get_order( $post->get_id() );
	$rtwcpiglw_order_id = $rtwcpiglw_order->get_id();
	$rtw_permalink = get_admin_url().'post.php?post='.$rtwcpiglw_order_id.'&action=edit&rtwcpiglw_order_id='.$rtwcpiglw_order_id;

		$rtwcpiglw_url = RTWCPIGLW_PDF_URL.$pdf_name.$rtwcpiglw_order_id.'.pdf';
		$rtwcpiglw_dir = RTWCPIGLW_PDF_DIR.$pdf_name.$rtwcpiglw_order_id.'.pdf';
		$rtwcpiglw_order = wc_get_order( $rtwcpiglw_order_id );
		$rtwcpiglw_order_status = $rtwcpiglw_order->get_status(); // Get the order status
		
		
		if (file_exists($rtwcpiglw_dir)) 
		{
			
			if ( $rtwcpiglw_order_status == 'completed' ) 
			{
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Normal Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_btn button button-primary" id="rtwcpiglw_nrml_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>



				<?php 
			}
			else
			{
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Proforma Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				if( get_option('rtwcpiglw_allow_proforma_dwnlod') == 'yes' ){
				?>
					<div class="rtwcpiglw_btn_wrap">
						<a class="rtwcpiglw_btn button button-primary" id="rtwcpiglw_prfrm_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?>	
						</a>	
				<?php
				} 				
			}
		}
		else
		{
			$rtwcpiglw_get_setting = get_option('rtwcpiglw_normal_inv_setting_opt');
			if ( $rtwcpiglw_order_status == 'completed' && isset($rtwcpiglw_get_setting['rtwcpiglw_dwnld_edit_ordr_page']) &&  $rtwcpiglw_get_setting['rtwcpiglw_dwnld_edit_ordr_page'] == '1' ) 
		
			{
				
				
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Proforma Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_display_none rtwcpiglw_btn button button-primary" id="rtwcpiglw_nrml_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				
					<a class="button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_invoice" href="javascript:void(0);" data-order_id="<?php echo esc_attr($rtwcpiglw_order_id); ?>" data-order_status="<?php echo esc_attr($rtwcpiglw_order_status); ?>"><?php esc_html_e('Regenerate '.$other_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>



				<?php 
				
			}
			else
			{
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Proforma Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				$option = get_option('rtwcpiglw_proforma_setting_opt');
			
				if( isset($option['rtwcpiglw_allow_proforma_dwnlod']) && $option['rtwcpiglw_allow_proforma_dwnlod'] == '1' ){
				
				?>
					<div class="rtwcpiglw_btn_wrap">
						<a class="rtwcpiglw_display_none rtwcpiglw_btn button button-primary" id="rtwcpiglw_prfrm_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
						
						<a class="button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_invoice" href="javascript:void(0);" data-order_id="<?php echo esc_attr($rtwcpiglw_order_id); ?>" data-order_status="<?php echo esc_attr($rtwcpiglw_order_status); ?>"><?php esc_html_e('Regenerate '.$other_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
					</div>
				<?php
				}			
			}
		}

}else
{
	global $post;

	if( $post->ID )
	{
		
		$rtwcpiglw_order = wc_get_order( $post->ID );
		$rtwcpiglw_order_id = $rtwcpiglw_order->get_id();
		$rtw_permalink = get_admin_url().'post.php?post='.$rtwcpiglw_order_id.'&action=edit&rtwcpiglw_order_id='.$rtwcpiglw_order_id;

		$rtwcpiglw_url = RTWCPIGLW_PDF_URL.$pdf_name.$rtwcpiglw_order_id.'.pdf';
		$rtwcpiglw_dir = RTWCPIGLW_PDF_DIR.$pdf_name.$rtwcpiglw_order_id.'.pdf';
		
		$rtwcpiglw_order_status = $rtwcpiglw_order->get_status(); // Get the order status
		
		
		if (file_exists($rtwcpiglw_dir)) 
		{
			
			if ( $rtwcpiglw_order_status == 'completed' ) 
			{
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Normal Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_btn button button-primary" id="rtwcpiglw_nrml_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>



				<?php 
			}
			else
			{
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Proforma Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				if( get_option('rtwcpiglw_allow_proforma_dwnlod') == 'yes' ){
				?>
					<div class="rtwcpiglw_btn_wrap">
						<a class="rtwcpiglw_btn button button-primary" id="rtwcpiglw_prfrm_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?>	
						</a>	
				<?php
				} 				
			}
		}
		else
		{
			$rtwcpiglw_get_setting = get_option('rtwcpiglw_normal_inv_setting_opt');
			if ( $rtwcpiglw_order_status == 'completed' && isset($rtwcpiglw_get_setting['rtwcpiglw_dwnld_edit_ordr_page']) &&  $rtwcpiglw_get_setting['rtwcpiglw_dwnld_edit_ordr_page'] == '1' ) 
		
			{
				
				
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Proforma Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_display_none rtwcpiglw_btn button button-primary" id="rtwcpiglw_nrml_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				
					<a class="button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_invoice" href="javascript:void(0);" data-order_id="<?php echo esc_attr($post->ID); ?>" data-order_status="<?php echo esc_attr($rtwcpiglw_order_status); ?>"><?php esc_html_e('Regenerate '.$other_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>



				<?php 
				
			}
			else
			{
				$btn_txt = get_option( 'rtwcpiglw_custm_btn_txt' );
				if ( $btn_txt == '' ) {
					$btn_txt = 'Download Proforma Invoice';
					$other_txt = 'Invoice';
				}else{
					$other_txt = 'License';
				}
				$option = get_option('rtwcpiglw_proforma_setting_opt');
			
				if( isset($option['rtwcpiglw_allow_proforma_dwnlod']) && $option['rtwcpiglw_allow_proforma_dwnlod'] == '1' ){
				
				?>
					<div class="rtwcpiglw_btn_wrap">
						<a class="rtwcpiglw_display_none rtwcpiglw_btn button button-primary" id="rtwcpiglw_prfrm_btn" target="_blank" href="<?php echo esc_url($rtw_permalink); ?>" download><?php esc_html_e($btn_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
						
						<a class="button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_invoice" href="javascript:void(0);" data-order_id="<?php echo esc_attr($post->ID); ?>" data-order_status="<?php echo esc_attr($rtwcpiglw_order_status); ?>"><?php esc_html_e('Regenerate '.$other_txt, 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
					</div>
				<?php
				}			
			}
		}
	}
}
?>