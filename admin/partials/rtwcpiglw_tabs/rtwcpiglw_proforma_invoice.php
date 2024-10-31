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
	update_option( 'rtwcpiglw_proforma_setting_opt', sanitize_post($_POST['rtwcpiglw_proforma_setting_opt']) );
} 
settings_fields('rtwcpiglw_prodct_tax_setting');
$rtwcpiglw_get_setting = get_option('rtwcpiglw_proforma_setting_opt');
?>
<table class="wp-list-table form-table rtw-table">
	<tr>
		<th class="descr"><?php esc_html_e('Enable Proforma Invoice', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_proforma_setting_opt[rtwcpiglw_proforma_invoice]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_proforma_invoice'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('Proforma invoices are gnerated as soon as order are marked as Paid.In proforma invoice Order ID is used for invoice numbering method.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Select The Status', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<select name="rtwcpiglw_proforma_setting_opt[rtwcpiglw_when_gnrate_invoice]">
				<option value="on-hold" <?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice']) && $rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice'] == 'on-hold'){ echo "selected=selected"; } ?>><?php esc_html_e('On hold', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option value="cancelled" <?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice']) && $rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice'] == 'cancelled'){ echo "selected=selected"; } ?>><?php esc_html_e('Cancelled', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option value="refunded" <?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice']) && $rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice'] == 'refunded'){ echo "selected=selected"; } ?>><?php esc_html_e('Refunded', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option value="failed" <?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice']) && $rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice'] == 'failed'){ echo "selected=selected"; } ?>><?php esc_html_e('Failed', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option value="processing" <?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice']) && $rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice'] == 'processing'){ echo "selected=selected"; } ?>><?php esc_html_e('Processing', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option value="pending-payment" <?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice']) && $rtwcpiglw_get_setting['rtwcpiglw_when_gnrate_invoice'] == 'pending-payment'){ echo "selected=selected"; } ?>><?php esc_html_e('Pending Payment', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			</select>
			<div class="descr"><?php esc_html_e('Please select the status on which you want to generate Proforma Invoice.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Download From My Account Page', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_proforma_setting_opt[rtwcpiglw_allow_proforma_dwnlod_frm_my_accnt]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_allow_proforma_dwnlod_frm_my_accnt'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled user will be able to download proforma PDF invoice from my account page.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Download From Order List Table', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<input type="checkbox" name="" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dwnld_prfrma_order_list'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Download From Thank you Page', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_proforma_setting_opt[rtwcpiglw_dwnld_prfrma_order_detail]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dwnld_prfrma_order_detail'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled user will be able to download proforma PDF invoice from order thank you page directoly.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Download From Edit Order Page', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_proforma_setting_opt[rtwcpiglw_allow_proforma_dwnlod]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_allow_proforma_dwnlod'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled admin will be able to download proforma PDF invoice from edit order page.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Allow admin For Delete Proforma Invoice', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<input type="checkbox" name="" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_admin_delete_proforma_invoice'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Attached to order Email', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_proforma_setting_opt[rtwcpiglw_attchd_profrma_ordr_mail]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_attchd_profrma_ordr_mail'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled PDF proforma invoice wiil be email to the user with order on-hold email and possibly proccessing order email', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
</table>