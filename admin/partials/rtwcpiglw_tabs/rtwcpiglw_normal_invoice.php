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
	update_option( 'rtwcpiglw_normal_inv_setting_opt', sanitize_post($_POST['rtwcpiglw_normal_inv_setting_opt']) );
}

settings_fields('rtwcpiglw_normal_inv_setting');
$rtwcpiglw_get_setting = get_option('rtwcpiglw_normal_inv_setting_opt');

?>

<table class="wp-list-table form-table rtw-table">
	<tr>
		<th class="descr"><?php esc_html_e('Enable Normal Invoicing', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_normal_inv_setting_opt[rtwcpiglw_normal_invoice]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_normal_invoice'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('Normal invoices are gnerated as soon as order are marked as completed.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Download From My Account Page', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_normal_inv_setting_opt[rtwcpiglw_allow_dwnlod_frm_my_acnt]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_allow_dwnlod_frm_my_acnt'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled user will be able to download normal PDF invoice from my account page.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Display Download Button On Order List Table', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<input type="checkbox" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_dwnlod_on_ordr_page'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"> <?php esc_html_e('Display Download Button On Thank you Page', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_normal_inv_setting_opt[rtwcpiglw_dsply_dwnlod_on_ordr_detail_page]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dsply_dwnlod_on_ordr_detail_page'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled user will be able to download PDF invoice from thank you page directly.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Download From Edit Order Page', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_normal_inv_setting_opt[rtwcpiglw_dwnld_edit_ordr_page]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_dwnld_edit_ordr_page'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled admin will be able to download PDF invoice from edit order page directly.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Attached to Order Email', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" name="rtwcpiglw_normal_inv_setting_opt[rtwcpiglw_atchd_ordr_mail]" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_atchd_ordr_mail'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="descr"><?php esc_html_e('If enabled PDF invoice is send along with order complition mail to the user.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Numbering Method', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<select>
				<option value="intrnl_suf_pre"><?php esc_html_e('Internal Sequence No Plus Suffix/Prefix', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option value="ordr_suf_pre"><?php esc_html_e('Order Number Plus Suffix/Prefix', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
				<option value="ordr_nmbr"><?php esc_html_e('Order Number', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			</select>
			<div class="descr"><?php esc_html_e('Choose the method for PDF Invoice number on the PDF invoice.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Internal Sequence No.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td>
			<input disabled="disabled" type="number" name="" value="<?php echo esc_attr((isset ( $rtwcpiglw_normal_inv_setting_opt['rtwcpiglw_nxt_nmbr'] )) ? $rtwcpiglw_normal_inv_setting_opt['rtwcpiglw_nxt_nmbr'] : ''); ?>">
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Prefix', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input disabled="disabled" type="text" name="" value="<?php echo esc_attr((isset ( $rtwcpiglw_normal_inv_setting_opt['rtwcpiglw_prefix'] )) ? $rtwcpiglw_normal_inv_setting_opt['rtwcpiglw_prefix'] : ''); ?>">
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Suffix', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input disabled="disabled" type="text" name="" value="<?php echo esc_attr((isset ( $rtwcpiglw_normal_inv_setting_opt['rtwcpiglw_suffix'] )) ? $rtwcpiglw_normal_inv_setting_opt['rtwcpiglw_suffix'] : ''); ?>">
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Allow admin For Delete Normal Invoice', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td class="descr_2">
			<input type="checkbox" value='1'<?php if(isset($rtwcpiglw_get_setting['rtwcpiglw_admin_delete_normal_invoice'])) { echo esc_html('checked = "checked"'); } ?> />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
</table>