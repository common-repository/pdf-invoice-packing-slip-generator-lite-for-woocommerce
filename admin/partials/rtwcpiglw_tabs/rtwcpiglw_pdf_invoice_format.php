<?php
if(isset(($_POST['rtwcpiglw_submit']))) 
{ 
	?>
	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e('Settings saved.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></strong></p>
		<button type="button" class="notice-dismiss">
			<span class="screen-reader-text"><?php esc_html_e('Dismiss this notices.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></span>
		</button>
	</div>
	<?php
	update_option( 'rtwcpiglw_invoice_format_setting_opt', sanitize_post($_POST['rtwcpiglw_invoice_format_setting_opt']));
}
settings_fields('rtwcpiglw_invoice_format_setting');
$rtwcpiglw_get_setting 			= get_option('rtwcpiglw_invoice_format_setting_opt');
$rtwcpiglw_template_selected 	= isset( $rtwcpiglw_get_setting[ 'invoice_format_4' ] ) ? $rtwcpiglw_get_setting[ 'invoice_format_4' ] : '4';
$rtwcpiglw_get_pkngslp_format = get_option('pckng_slp_format');

$rtwcpiglw_content_html_4 = '
<table class="invhead" style="width: 100%; font-size: 14px; border: none;">
<tbody>
<tr>
<td style="width: 40%; border: none;">
<div class="rtwcpig-logo" style="width: 29%; display: inline-block;"><img class="alignnone" style="margin-bottom: 15px;" src="" alt="shop logo" width="100" height="100" />
</div>
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
<div> </div>
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

?>
<table class="wp-list-table form-table rtw-table">
	<tbody>
		<tr>
			<th><h3><?php esc_html_e('Macros','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></h3></th>
			<td>
				<p><?php esc_html_e('Use following macros for PDF invoice','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></p>
				<div class="rtwcpiglw_macros">
					<div class="rtwcpiglw_macros_1">
						<ul>
							<li><strong>[order_id]</strong></li>
							<li><strong>[order_date]</strong></li>
							<li><strong>[order_amount]</strong></li>
							<li><strong>[total_amnt_in_words]</strong></li>
							<li><strong>[line_total]</strong></li>
							<li><strong>[product_name]</strong></li>
							<li><strong>[product_qty]</strong></li>
							<li><strong>[product_price]</strong></li>
							<li><strong>[customer_id]</strong></li>
						</ul>
					</div>
					<div class="rtwcpiglw_macros_2">
						<ul>
							<li><strong>[line_number]</strong></li>
							<li><strong>[row_tax_amount]</strong></li>
							<li><strong>[subtotal_amount]</strong></li>
							<li><strong>[tax_rate]</strong></li>
							<li><strong>[tax_amount]</strong></li>
							<li><strong>[row_tax_amount]</strong></li>
							<li><strong>[customer_note]</strong></li>
							<li><strong>[product_img]</strong></li>
							<li><strong>[payment_method]</strong></li>
						</ul>
					</div>
					<div class="rtwcpiglw_macros_3">
						<ul>
							<li><strong>[shipping_first_name]</strong></li>
							<li><strong>[shipping_last_name]</strong></li>
							<li><strong>[shipping_company]</strong></li>
							<li><strong>[shipping_address_1]</strong></li>
							<li><strong>[shipping_address_2]</strong></li>
							<li><strong>[shipping_city]</strong></li>
							<li><strong>[shipping_charges]</strong></li>
							<li><strong>[shipping_method]</strong></li>
							<li><strong>[shipping_postcode]</strong></li>
							<li><strong>[shipping_country]</strong></li>
							<li><strong>[shipping_state]</strong></li>
						</ul>
					</div>
					<div class="rtwcpiglw_macros_4">
						<ul>
							<li><strong>[billing_first_name]</strong></li>
							<li><strong>[billing_last_name]</strong></li>
							<li><strong>[billing_address_1]</strong></li>
							<li><strong>[billing_address_2]</strong></li>
							<li><strong>[billing_city]</strong></li>
							<li><strong>[billing_phone]</strong></li>
							<li><strong>[billing_state]</strong></li>
							<li><strong>[billing_postcode]</strong></li>
							<li><strong>[billing_country]</strong></li>
							<li><strong>[billing_email]</strong></li>
							<li><strong>[billing_company]</strong></li>
						</ul>
					</div>
					<?php 
					$shortcode_array = array();
					$shortcode_array = apply_filters('rtwcpiglw_shortcode_array', $shortcode_array);
					
					if( isset($shortcode_array) && is_array($shortcode_array) && !empty($shortcode_array) )
					{
						?>
						<div class="rtwcpiglw_macros_5">
							<ul>
								<?php 
								foreach ($shortcode_array as $short_code => $code) {
									echo '<li><strong>['.esc_html($code).']</strong></li>';
								}
								?>
							</ul>
						</div>
						<?php
					}
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th><h3><?php esc_html_e('PDF Invoice Layout', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></h3></th>
			<td>
				<p class="rtwcpiglw_cmnt"><?php esc_html_e('Please do not remove id=rtwcpiglw_prod_table.If you add your custom format then must add this id in your table.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></p>
				<?php
				if ( !empty($rtwcpiglw_get_setting['invoice_format_4'])) 
				{
					$rtwcpiglw_cntnt = $rtwcpiglw_get_setting['invoice_format_4'] ;
				}
				else
				{
					$rtwcpiglw_cntnt = $rtwcpiglw_content_html_4;
				}
				$rtwcpiglw_cntnt = html_entity_decode( $rtwcpiglw_cntnt );
				$rtwcpiglw_cntnt = stripslashes( $rtwcpiglw_cntnt );
				$rtwcpiglw_setting = array(
					'wpautop' => false,
					'media_buttons' => true,
					'textarea_name' => 'rtwcpiglw_invoice_format_setting_opt[invoice_format_4]',
					'textarea_rows' => 40,
					'textarea_cols' => 30,
				);
				wp_editor($rtwcpiglw_cntnt, 'rtwcpiglw_pdf_invoice_html_4' , $rtwcpiglw_setting );
				?>
			</td>
		</tr>
	</tbody>
</table>