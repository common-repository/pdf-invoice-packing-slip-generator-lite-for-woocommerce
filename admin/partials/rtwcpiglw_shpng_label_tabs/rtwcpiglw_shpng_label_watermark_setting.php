<?php

foreach ($rtwcpiglw_fonts as $rtwcpiglw_key => $rtwcpiglw_value) 
{
	$rtwcpiglw_shpng_lable_font_array[$rtwcpiglw_key] = $rtwcpiglw_value ;
}

global $rtwcpiglw_watermark_size_array ;
$rtwcpiglw_watermark_size_array = array('D'=>'Original size of image','P'=>'Resize to fit the full page size, keeping aspect ratio','F'=>'Resize to fit the print-area (frame) respecting current page margins, keeping aspect ratio','INT'=>'Resize to full page size minus a margin set by this integer, keeping aspect ratio','array'=>'Specify Width and Height');
global $rtwcpiglw_watermark_pos ;
$rtwcpiglw_watermark_pos = array('P'=>'Centred on the whole page area','F'=>'Centred on the page print-area (frame) respecting page margins','arrays'=>'Specify a position');

if(isset(($_POST['rtwcpiglw_submit']))) { ?>

	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e('Settings saved.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></strong></p>
		<button type="button" class="notice-dismiss">
			<span class="screen-reader-text"><?php esc_html_e('Dismiss this notices.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></span>
		</button>
	</div> 
	<?php

	update_option( 'rtwcpiglw_shpng_lbl_watermark_setting_opt', sanitize_post($_POST['rtwcpiglw_shpng_lbl_watermark_setting_opt']) );

}

$rtwcpiglw_get_setting = get_option('rtwcpiglw_shpng_lbl_watermark_setting_opt'); 

$rtwcpiglw_wtrmrk_txt = get_option('rtwcpiglw_enable_shpng_lbl_text_watermark');
$rtwcpiglw_wtrmrk_img = get_option('rtwcpiglw_enable_shpng_lbl_image_watermark');
$rtwcpiglw_wtrmrk_img_dim = get_option('rtwcpiglw_shpng_lbl_watermark_img_dim');
$rtwcpiglw_wtrmrk_img_pos = get_option('rtwcpiglw_shpng_lbl_watermark_img_pos');

?>

<input type="hidden" id="pckngslp_show_wtrmrk_txt" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_txt); ?>">
<input type="hidden" id="pckngslp_show_wtrmrk_img" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_img); ?>">
<input type="hidden" id="pckngslp_wtrmrk_img_dim" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_img_dim); ?>">
<input type="hidden" id="pckngslp_wtrmrk_img_pos" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_img_pos); ?>">
<!-- Image watermark -->
<table class="wp-list-table form-table rtw-table">
	<tr>
		<th class="descr"><?php esc_html_e('Show Watermark Text', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<input type="checkbox" id="rtwwpcfp_wtrmrk"
			name="rtwcpiglw_shpng_lbl_watermark_setting_opt[rtwcpiglw_enable_shpng_lbl_text_watermark]" value='1'
			<?php if(isset( $rtwcpiglw_get_setting['rtwcpiglw_enable_shpng_lbl_text_watermark']) && $rtwcpiglw_get_setting['rtwcpiglw_enable_shpng_lbl_text_watermark']==1){ echo 'checked=checked';} ?>  />
			<div class="descr"><?php esc_html_e('Check it if you want to show Watermark text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
	<tr>
		<th class="descr"><?php esc_html_e('Watermark Text', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td class="descr_2">
			<textarea name="rtwcpiglw_shpng_lbl_watermark_setting_opt[rtwcpiglw_shpng_lbl_watermark_font]" rows="4" cols="35"><?php if( isset($rtwcpiglw_get_setting['rtwcpiglw_shpng_lbl_watermark_font'])) { echo esc_html($rtwcpiglw_get_setting['rtwcpiglw_shpng_lbl_watermark_font']); } ?>
		</textarea>
		<div class="descr"><?php esc_html_e('Enter Watermark Text which you want to show on pdf.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Watermark Font Type', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
	<td>
		<select name="">
			<?php
			foreach ( $rtwcpiglw_shpng_lable_font_array as $rtwcpiglw_key => $rtwcpiglw_value ) 
			{
				?>
				<option value="" <?php echo esc_html(isset( $rtwcpiglw_get_setting['rtwcpiglw_text_add_watermark'] ) && $rtwcpiglw_get_setting['rtwcpiglw_text_add_watermark'] == $rtwcpiglw_value ? 'selected="selected"' : '');?>><?php echo esc_html($rtwcpiglw_key);?></option>
				<?php
			}
			?>
		</select>
		<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Watermark Rotation', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
	<td>
		<input type="text" />
		<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Text Transparency', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
	<td class="descr_2">
		<input type="text" name=""
		value="<?php echo esc_attr( isset ( $rtwcpiglw_get_setting['rtwcpiglw_watermark_text_trans'] ) ? $rtwcpiglw_get_setting['rtwcpiglw_watermark_text_trans'] : ''); ?>" />
		<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><?php esc_html_e('Show Watermark Image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
	<td class="descr_2">
		<input type="checkbox" id="rtwwpcfp_wtrmrk"
		name="rtwcpiglw_shpng_lbl_watermark_setting_opt[rtwcpiglw_enable_shpng_lbl_image_watermark]" value='1'
		<?php if(isset( $rtwcpiglw_get_setting['rtwcpiglw_enable_shpng_lbl_image_watermark']) && $rtwcpiglw_get_setting['rtwcpiglw_enable_shpng_lbl_image_watermark']==1){ echo 'checked=checked';} ?> />
		<div class="descr"><?php esc_html_e('Check it if you want to show Watermark image.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><?php esc_html_e('Watermark Image:', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
	<td>
		<?php $src_watermark = isset($rtwcpiglw_get_setting['rtwcpiglw_watermark_img_url'] ) ? $rtwcpiglw_get_setting['rtwcpiglw_watermark_img_url'] : '';?>
		<div id="rtwcpiglw_watermark_img_backgrnd">
			
			<img id="rtwcpiglw_watermark_img" src="<?php echo esc_url($src_watermark); ?>" />
			
		</div>
		<div id="rtwcpiglw_wtrmrk_img" >
			<input type="hidden" id="rtwcpiglw_watermark_img_url"
			name="rtwcpiglw_shpng_lbl_watermark_setting_opt[rtwcpiglw_watermark_img_url]"
			value="<?php echo esc_attr($src_watermark); ?>" />
			<button type="button" class="rtwcpiglw_watermark_img_upload button"><?php esc_html_e( 'Upload/Add image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button><br>
			<?php if($src_watermark != '') { ?>
				<button type="button" class="rtwcpiglw_watermark_remove_img button"><?php esc_html_e( 'Remove image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button>
			<?php } ?>
		</div>
		<div class="descr"><?php esc_html_e('Choose your Watermark Image which you want to show on pdf.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Image Transparency', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
	<td class="descr_2">
		<input type="text" name=""
		value="<?php echo esc_attr( isset ( $rtwcpiglw_get_setting['rtwcpiglw_watermark_image_trans'] ) ? $rtwcpiglw_get_setting['rtwcpiglw_watermark_image_trans'] : ''); ?>" />
		<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Image Dimention', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
	<td class="descr_2">
		<select>
			<option><?php esc_html_e('Original size of image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			<option><?php esc_html_e('Resize to fit the full page size, keeping aspect ratio', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			<option><?php esc_html_e('Resize to fit the print-area (frame) respecting current page margins, keeping aspect ratio', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			<option><?php esc_html_e('Resize to fit the print-area (frame) respecting current page margins, keeping aspect ratio', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			<option><?php esc_html_e('Specify Width and Height', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
		</select>
		<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
<tr>
	<th class="descr"><span class="rtwcpiglw_pro_image"><img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/pro.png' ); ?>" alt="pro_feature"></span><span class="rtwcpiglw_pro_text"><?php esc_html_e('Image Position', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></th>
	<td class="descr_2">
		<select>
			<option><?php esc_html_e('Centred on the whole page area', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			<option><?php esc_html_e('Centred on the page print-area (frame) respecting page margins', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
			<option><?php esc_html_e('Specify a position', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></option>
		</select>
		<div class="rtwcpiglw_pro_descr"><?php esc_html_e('This Feature Is Available in PRO.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
	</td>
</tr>
</table>