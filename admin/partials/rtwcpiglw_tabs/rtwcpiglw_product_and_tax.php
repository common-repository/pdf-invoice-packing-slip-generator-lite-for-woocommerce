<?php

if(isset(($_POST['rtwcpiglw_submit']))) {
	?>
	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e('Settings saved.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></strong></p>
		<button type="button" class="notice-dismiss">
			<span class="screen-reader-text"><?php esc_html_e('Dismiss this notices.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></span>
		</button>
	</div>
	<?php
	update_option( 'rtwcpiglw_prodct_tax_setting_opt', sanitize_post($_POST['rtwcpiglw_prodct_tax_setting_opt']) );
}
settings_fields('rtwcpiglw_prodct_tax_setting');
$rtwcpiglw_get_setting = get_option('rtwcpiglw_prodct_tax_setting_opt');
?>

<table class="wp-list-table form-table rtw-table">
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Display Product ID/SKU', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<select>
				<option><?php esc_html_e('Do Not Display', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option><?php esc_html_e('Display Product ID(WP Post ID)', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option><?php esc_html_e('Display SKU', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			</select>
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Display Product Category', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_prodct_tax_setting_opt[rtwcpiglw_dsply_prdct_cat]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_prdct_cat'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('Check it if you want to show product category.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Display Product Image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" 
			name="rtwcpiglw_prodct_tax_setting_opt[rtwcpiglw_dsply_prdct_img]" value='1'
			<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_prdct_img'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('Check it if you want to show product image on PDF invoice.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Display Currency Symbol', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<input type="checkbox" value='1' <?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_crrncy_smbl'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Display Payment Method', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox"
			name="rtwcpiglw_prodct_tax_setting_opt[rtwcpiglw_dsply_paymnt_mthd]" value='1'
			<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_paymnt_mthd'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled, payment method title will displayed in both types of invoices and also in packing slip', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Display Shipping Amount', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<input type="checkbox" value='1'
			<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_fee_shipng'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Display Amount In Words', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox"
			name="rtwcpiglw_prodct_tax_setting_opt[rtwcpiglw_dsply_amnt_word]" value='1'
			<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_amnt_word'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('Check it if you want to show Amount in words.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('When Personal Data Is Removed', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<select>
				<option><?php esc_html_e('Keep Invoice - will remove manually', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option><?php esc_html_e('Remove Invoice automatically', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			</select>
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
</table>