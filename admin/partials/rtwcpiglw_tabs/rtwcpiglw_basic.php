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
		update_option( 'rtwcpiglw_basic_setting_opt', sanitize_post($_POST['rtwcpiglw_basic_setting_opt']) );
	}
	$rtwcpiglw_get_setting = get_option('rtwcpiglw_basic_setting_opt');
	$rtwcpiglw_get_wc_sttng = get_option('rtwcpiglw_enable_paswrd'); 

	?>

	<input type="hidden" id="pswrd_enable_val" value="<?php echo esc_attr($rtwcpiglw_get_wc_sttng); ?>">
	<table class="wp-list-table form-table rtw-table">
		<tbody>
			<tr>
				<th class="descr"><?php esc_html_e( 'Rtl Support', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?></th>
				<td class="descr_2">
					<input type="checkbox" name="rtwcpiglw_basic_setting_opt[rtwcpiglw_rtl]" value="1" <?php echo isset( $rtwcpiglw_get_setting['rtwcpiglw_rtl'] ) && $rtwcpiglw_get_setting['rtwcpiglw_rtl'] == 1 ? esc_html('checked="checked"') : ''; ?> />
					<div class="descr"><?php esc_html_e( 'Check it if you want generate pdf in Arabic or languages which start from right align.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' );?></div>
				</td>
			</tr>
			<!-- 
			 -->
			<tr>
				<th class="descr"><?php esc_html_e( 'Name of the PDF Invoice', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?></th>
				<td class="descr_2">
					<input type="text" name="rtwcpiglw_basic_setting_opt[rtwcpiglw_custm_pdf_name]" value="<?php echo isset( $rtwcpiglw_get_setting['rtwcpiglw_custm_pdf_name'] ) ? $rtwcpiglw_get_setting['rtwcpiglw_custm_pdf_name'] : ''; ?>"  />
					<div class="descr"><?php esc_html_e( 'You can set the name of the Generated Invoice.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' );?></div>
				</td>
			</tr>
			<!--  -->
			<tr>
				<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e( 'Enable Password Protection', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?></span></th>
				<td class="descr_2">
					<input type="checkbox" name="" />
					<div class="rtwcpiglw_pro_descr"><?php esc_html_e( 'This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' );?></div>
				</td>
			</tr>
			<tr>
				<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('For User Password', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
				<td class="descr_2">
					<select disabled="disabled">
						<option value=""><?php esc_html_e('Order ID', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
					</option>
					<option value=""><?php esc_html_e('E-mail', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
				</option>
			</select>
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e( 'Admin Password', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?></span></th>
		<td>
			<input type="text" />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Image For Button:', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td>
			<?php $rtwcpiglw_image_url = isset($rtwcpiglw_get_setting['img_url'] ) ? $rtwcpiglw_get_setting['img_url'] : '';?>
			<div id="rtwcpiglw_btn_img">
				<img id="rtwcpiglw_img_btn" src="<?php echo esc_url($rtwcpiglw_image_url); ?>" />
			</div>
			<div id="rtwcpiglw_image_url" >
				<input type="hidden" id="rtwcpiglw_img_url"
				name="rtwcpiglw_basic_setting_opt[img_url]"
				value="<?php echo esc_attr($rtwcpiglw_image_url); ?>" />
				<button type="button" class="rtwcpiglw_btn_img_upload button"><?php esc_html_e( 'Upload/Add image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button><br>
				<?php if($rtwcpiglw_image_url != ''){ ?>
					<button type="button" class="rtwcpiglw_btn_remove_img button"><?php esc_html_e( 'Remove image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button>
				<?php } ?>
			</div>
			<div class="descr"><?php esc_html_e('Choose your Image which you want to show on `Download PDF Invoice` Button in Order Edit Page.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Height For Button:', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td>
			<input type="text" />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Width For Button:', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td>
			<input type="text" />
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Set background Image for PDF', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
		<td>
			<?php $rtwcpiglw_src_img = isset($rtwcpiglw_get_setting['bck_img_url'] ) ? $rtwcpiglw_get_setting['bck_img_url'] : '';?>
			<div id="rtwcpiglw_bckgrnd_img">
				
				<img id="rtwcpiglw_bckgrnd_img_btn" src="<?php echo esc_url($rtwcpiglw_src_img); ?>"/>
				
			</div>
			<div id="rtwcpiglw_bck_img">
				<input type="hidden" id="rtwcpiglw_bck_img_url"
				name="rtwcpiglw_basic_setting_opt[bck_img_url]"
				value="<?php echo esc_attr($rtwcpiglw_src_img); ?>" />
				<button disabled="disabled" type="button" class="rtwcpiglw_btn_bckgrnd_img_upload button"><?php esc_html_e( 'Upload/Add image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button><br>
				<?php if($rtwcpiglw_src_img != ''){ ?>
					<button type="button" class="rtwcpiglw_btn_remove_bckgrnd_img button"><?php esc_html_e( 'Remove image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button>
				<?php } ?>
			</div>
			<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Select Background color For PDF', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td>
			<?php $rtwcpiglw_back_color = isset($rtwcpiglw_get_setting['back_color'] ) ? $rtwcpiglw_get_setting['back_color'] : ''; ?>
			<div class="wp-picker-container">
				<input class="color-field" type="text" name="rtwcpiglw_basic_setting_opt[back_color]" value="<?php echo esc_attr($rtwcpiglw_back_color); ?>" />
			</div>
			<div class="descr"><?php esc_html_e('Choose the color for your pdf background.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr> 
</tbody>
</table>