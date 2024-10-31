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
		
		update_option( 'rtwcpiglw_shipping_format', sanitize_post($_POST['rtwcpiglw_shipping_format']));
		// update_option( 'rtwcpiglw_qr_code_content', sanitize_post($_POST['rtwcpiglw_qr_code_content']));
		// update_option( 'rtwcpiglw_bar_code_content', sanitize_post($_POST['rtwcpiglw_bar_code_content']));
	}

	$rtwcpiglw_get_shpng_lbl_format = get_option('rtwcpiglw_shipping_format');
	$rtwcpiglw_qr_cntnt = get_option('rtwcpiglw_qr_code_content');
	$rtwcpiglw_barcode_cntnt = get_option('rtwcpiglw_bar_code_content');

	if( $rtwcpiglw_get_shpng_lbl_format == '' )
	{
		$rtwcpiglw_get_shpng_lbl_format = '
		<div style="max-width: 1170px; margin: 0 auto; padding: 30px 0; box-sizing: border-box;">
			<table style="width: 650px; border-collapse: collapse; margin: 0 auto; font-family: Helvetica; border: 1px solid #dddddd; box-sizing: border-box;">
				<thead>
					<tr>
						<th style="border: 1px solid #dddddd; width: 100px; box-sizing: border-box;" rowspan="3"> </th>
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
						<td style="border: 1px solid #dddddd; padding: 20px; box-sizing: border-box;">
							<div style="margin: 0; line-height: 22px; font-size: 19px; font-weight: bold; box-sizing: border-box;">Shipping Customer Address</div>
							<div style="font-size: 13px; margin: 0; line-height: 22px box-sizing: border-box;">[shipping_first_name] [shipping_last_name]</div>
							<div style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">[shipping_address_1] , [shipping_address_2]</div>
							<div style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">[shipping_city] , [shipping_state]</div>
							<div style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">[shipping_postcode] , [shipping_country]</div>
						</td>
						<td style="border: 1px solid #dddddd; width: 50%; padding: 20px; box-sizing: border-box;">
							<p style="font-size: 25px; font-weight: bold; margin: 0; line-height: 22px; padding-bottom: 10px; box-sizing: border-box;">Return Address</p>
							<p style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">RedefiningTheWeb 100 MAIN ST. SEATTLE WA,98104, USA</p>
							<p style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">Phone: 987-654-032</p>
							<p style="font-size: 13px; margin: 0; line-height: 22px; box-sizing: border-box;">E-mail: developer@redefiningtheweb.com</p>
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

	?>

	<table class="wp-list-table form-table rtw-table">
		<tbody>
			<tr>
				<th><h3><?php esc_html_e('Macros','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></h3></th>
				<td>
					<p><?php esc_html_e('You can use these macros for shipping label.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></p>
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
								<li><strong>[line_number]</strong></li>
								<li><strong>[customer_note]</strong></li>
								<li><strong>[product_img]</strong></li>
								<li><strong>[payment_method]</strong></li>
								<li><strong>[seller_name]</strong></li>
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
								<li><strong>[barcode_img]</strong></li>
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
								<li><strong>[qr_code_img]</strong></li>
							</ul>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('QR Code Content','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></span></th>
				<td>
					<textarea rows="3" cols="50"><?php echo esc_html($rtwcpiglw_qr_cntnt); ?></textarea>
					<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
				</td>
			</tr>
			<tr>
				<th><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('BarCode Content','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></span></th>
				<td>
					<textarea rows="5" cols="50"><?php echo esc_html($rtwcpiglw_barcode_cntnt); ?></textarea>
					<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
				</td>
			</tr>

		</tbody>
	</table>

	<table class="wp-list-table form-table rtw-table">
		<tbody> 
			<tr>
				<th class="descr"><?php esc_html_e('Shipping Label Format', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
				<td>
					<?php
					if ( !empty($rtwcpiglw_get_shpng_lbl_format)) 
					{
						$rtwcpiglw_shpng_lbl_cntnt = $rtwcpiglw_get_shpng_lbl_format ;
					}
					
					$rtwcpiglw_shpng_lbl_cntnt = html_entity_decode( $rtwcpiglw_shpng_lbl_cntnt );
					$rtwcpiglw_shpng_lbl_cntnt = stripslashes( $rtwcpiglw_shpng_lbl_cntnt );
					$rtwcpiglw_shpng_label_setting = array(
						'wpautop' => false,
						'media_buttons' => true,
						'textarea_name' => 'rtwcpiglw_shipping_format',
						'textarea_rows' => 10,
						'textarea_cols' => 30,
					);
					wp_editor($rtwcpiglw_shpng_lbl_cntnt, 'rtwcpiglw_pckng_slp_html' , $rtwcpiglw_shpng_label_setting );
					?>
				</td>
			</tr>
		</tbody>
	</table>