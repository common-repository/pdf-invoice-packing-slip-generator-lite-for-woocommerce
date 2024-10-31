<?php
use Automattic\WooCommerce\Utilities\OrderUtil;
if(OrderUtil::custom_orders_table_usage_is_enabled()){
	$rtwcpiglw_order_id = $post->get_id();

	$rtwcpiglw_url = RTWCPIGLW_PDF_URL.'/rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_order_id.'.pdf';
		$rtwcpiglw_dir = RTWCPIGLW_PDF_DIR.'/rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_order_id.'.pdf';

	if (file_exists($rtwcpiglw_dir)) 
		{
			?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_btn button button-primary" id="rtwcpiglw_shiping_lbl" target="_blank" href="<?php echo esc_url($rtwcpiglw_url); ?>" download><?php esc_html_e('Download Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>

					<a class="rtwcpiglw_display_none button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_shipping_lbl" href="javascript:void(0);" data-order_id="<?php echo esc_attr($rtwcpiglw_order_id); ?>" ><?php esc_html_e('Generate Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>

			<?php 
		}
		else
		{
			?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_display_none rtwcpiglw_btn button button-primary" id="rtwcpiglw_shiping_lbl" target="_blank" href="<?php echo esc_url($rtwcpiglw_url); ?>"><?php esc_html_e('Download Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>

					<a class="button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_shipping_lbl" href="javascript:void(0);" data-order_id="<?php echo esc_attr($rtwcpiglw_order_id); ?>"><?php esc_html_e('Generate Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>

			<?php 
		}

}else
{


	global $post;

	if( $post->ID )
	{
		$rtwcpiglw_order_id = $post->ID;

		$rtwcpiglw_url = RTWCPIGLW_PDF_URL.'/rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_order_id.'.pdf';
		$rtwcpiglw_dir = RTWCPIGLW_PDF_DIR.'/rtwcpiglw_shipping_label/rtwcpiglw_shiping_lbl_'.$rtwcpiglw_order_id.'.pdf';

		if (file_exists($rtwcpiglw_dir)) 
		{
			?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_btn button button-primary" id="rtwcpiglw_shiping_lbl" target="_blank" href="<?php echo esc_url($rtwcpiglw_url); ?>" download><?php esc_html_e('Download Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>

					<a class="rtwcpiglw_display_none button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_shipping_lbl" href="javascript:void(0);" data-order_id="<?php echo esc_attr($post->ID); ?>" ><?php esc_html_e('Generate Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>

			<?php 
		}
		else
		{
			?>
				
				<div class="rtwcpiglw_btn_wrap">

					<a class="rtwcpiglw_display_none rtwcpiglw_btn button button-primary" id="rtwcpiglw_shiping_lbl" target="_blank" href="<?php echo esc_url($rtwcpiglw_url); ?>"><?php esc_html_e('Download Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>

					<a class="button button-primary rtwcpiglw_btn" id="rtwcpiglw_regnrt_shipping_lbl" href="javascript:void(0);" data-order_id="<?php echo esc_attr($post->ID); ?>"><?php esc_html_e('Generate Shipping Label', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></a>
				</div>

			<?php 
		}
	}
}
?>