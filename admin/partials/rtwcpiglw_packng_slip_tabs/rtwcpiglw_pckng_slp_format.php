<?php

if(isset(($_POST['rtwcpiglw_submit']))) 
	{ ?>
		<div class="notice notice-success is-dismissible">
			<p><strong><?php esc_html_e('Settings saved.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></strong></p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text"><?php esc_html_e('Dismiss this notices.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></span>
			</button>
		</div>
		<?php
		
		update_option( 'pckng_slp_format', sanitize_post($_POST['pckng_slp_format']));
	}

	$rtwcpiglw_get_pkngslp_format = get_option('pckng_slp_format');

	$rtwcpiglw_pkng_slp = '
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
	<th style="width: 200px; padding: 15px 10px; text-align: left; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Product SKU</th>
	<th style="width: 100px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Product</th>
	<th style="width: 100px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Price</th>
	<th style="width: 100px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Quantity</th>
	<th style="width: 100px; font-size: 15px; text-align: center; padding: 15px 10px; border-bottom: 1px solid #b08c77; border-top: 1px solid #b08c77; background-color: #5ee3b6; color: #000000;">Line Total</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td style="padding: 10px; border-bottom: 2px solid #dddddd; text-align: left; color: #444444;">[line_number]</td>
	<td style="padding: 10px; border-bottom: 2px solid #dddddd; text-align: left; color: #444444;">[product_sku]</td>
	<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[product_name]</td>
	<td style="text-align: center; padding: 10px; border-bottom: 2px solid #dddddd; color: #444444;">[product_price]</td>
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

	?>

	<table class="wp-list-table form-table rtw-table">
		<tbody>
			<tr>
				<th><h3><?php esc_html_e('Macros','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></h3></th>
				<td>
					<p><?php esc_html_e('You can use these macros for packing slip .', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></p>
					<div class=rtwcpiglw_macros>
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
								<li><strong>[billing_company]</strong></li>
							</ul>
						</div>
						<div class="rtwcpiglw_macros_2">
							<ul>
								<li><strong>[line_number]</strong></li>
								<li><strong>[subtotal_amount]</strong></li>
								<li><strong>[tax_rate]</strong></li>
								<li><strong>[tax_amount]</strong></li>
								<li><strong>[customer_note]</strong></li>
								<li><strong>[payment_method]</strong></li>
								<li><strong>[shipping_first_name]</strong></li>
								<li><strong>[shipping_last_name]</strong></li>
								<li><strong>[shipping_company]</strong></li>
							</ul>
						</div>
						<div class="rtwcpiglw_macros_3">
							<ul>
								<li><strong>[shipping_address_1]</strong></li>
								<li><strong>[shipping_address_2]</strong></li>
								<li><strong>[shipping_city]</strong></li>
								<li><strong>[shipping_charges]</strong></li>
								<li><strong>[shipping_method]</strong></li>
								<li><strong>[shipping_postcode]</strong></li>
								<li><strong>[shipping_country]</strong></li>
								<li><strong>[shipping_state]</strong></li>
								<li><strong>[billing_first_name]</strong></li>
							</ul>
						</div>
						<div class="rtwcpiglw_macros_4">
							<ul>
								<li><strong>[billing_last_name]</strong></li>
								<li><strong>[billing_address_1]</strong></li>
								<li><strong>[billing_address_2]</strong></li>
								<li><strong>[billing_city]</strong></li>
								<li><strong>[billing_phone]</strong></li>
								<li><strong>[billing_state]</strong></li>
								<li><strong>[billing_postcode]</strong></li>
								<li><strong>[billing_country]</strong></li>
								<li><strong>[billing_email]</strong></li>
							</ul>
						</div>
					</div>
				</td>
			</tr> 
		</tbody>
	</table>

	<table class="wp-list-table form-table rtw-table">
		<tbody> 
			<tr>
				<th class="descr"><?php esc_html_e('Packing_Slip Format', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
				<td>
					<?php
					if ( !empty($rtwcpiglw_get_pkngslp_format)) 
					{
						$rtwcpiglw_pckng_slp_cntnt = $rtwcpiglw_get_pkngslp_format ;
					}
					else
					{
						$rtwcpiglw_pckng_slp_cntnt = $rtwcpiglw_pkng_slp;
					}
					$rtwcpiglw_pckng_slp_cntnt = html_entity_decode( $rtwcpiglw_pckng_slp_cntnt );
					$rtwcpiglw_pckng_slp_cntnt = stripslashes( $rtwcpiglw_pckng_slp_cntnt );
					$rtwcpiglw_pack_slip_setting = array(
						'wpautop' => false,
						'media_buttons' => true,
						'textarea_name' => 'pckng_slp_format',
						'textarea_rows' => 20,
						'textarea_cols' => 30,
					);
					wp_editor($rtwcpiglw_pckng_slp_cntnt, 'rtwcpiglw_pckng_slp_html' , $rtwcpiglw_pack_slip_setting );
					?>
				</td>
			</tr>
		</tbody>
	</table>
