<?php


foreach ($rtwcpiglw_fonts as $rtwcpiglw_key => $rtwcpiglw_value) 
{
	$rtwcpiglw_credit_note_font_array[$rtwcpiglw_key] = $rtwcpiglw_value ;
}

global $rtwcpiglw_watermark_size_array ;
$rtwcpiglw_watermark_size_array = array('D'=>'Original size of image','P'=>'Resize to fit the full page size, keeping aspect ratio','F'=>'Resize to fit the print-area (frame) respecting current page margins, keeping aspect ratio','INT'=>'Resize to full page size minus a margin set by this integer, keeping aspect ratio','array'=>'Specify Width and Height');
global $rtwcpiglw_watermark_pos ;
$rtwcpiglw_watermark_pos = array('P'=>'Centred on the whole page area','F'=>'Centred on the page print-area (frame) respecting page margins','arrays'=>'Specify a position');
?>

<div class="rtwcpiglw_tab_div">
	<?php woocommerce_admin_fields(rtwcpiglw_creditnote_watermak_settings()); ?> 
</div>

<input type="hidden" id="credi_note_show_wtrmrk_txt" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_txt); ?>">
<input type="hidden" id="credi_note_show_wtrmrk_img" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_img); ?>">
<input type="hidden" id="credi_note_wtrmrk_img_dim" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_img_dim); ?>">
<input type="hidden" id="credi_note_wtrmrk_img_pos" value="<?php echo esc_attr($rtwcpiglw_wtrmrk_img_pos); ?>">
<!-- Image watermark -->
<table id="rtwcpiglw_creditnote_add_watermark_img" class="wp-list-table form-table rtw-table">
	<tr>
		<th class="descr"><?php esc_html_e('Watermark Image:', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
		<td>
			<?php $src_watermark = isset($rtwcpiglw_get_setting['rtwcpiglw_watermark_img_url'] ) ? $rtwcpiglw_get_setting['rtwcpiglw_watermark_img_url'] : '';?>
			<div id="rtwcpiglw_watermark_img_backgrnd">
				
				<img id="rtwcpiglw_watermark_img" src="<?php echo esc_url($src_watermark); ?>" />
				
			</div>
			<div id="rtwcpiglw_wtrmrk_img" >
				<input type="hidden" id="rtwcpiglw_watermark_img_url"
				name=""
				value="<?php echo esc_attr($src_watermark); ?>" />
				<button type="button" class="rtwcpiglw_watermark_img_upload button"><?php esc_html_e( 'Upload/Add image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button><br>
				<?php if($src_watermark != '') { ?>
					<button type="button" class="rtwcpiglw_watermark_remove_img button"><?php esc_html_e( 'Remove image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button>
				<?php } ?>
			</div>
			<div class="descr"><?php esc_html_e('Choose your Watermark Image which you want to show on pdf.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
		</td>
	</tr>
</table>
<?php

/**
* function for display WooCommerce settings.
*
* @since    1.0.0
*/
function rtwcpiglw_creditnote_watermak_settings()
{
	global $rtwcpiglw_watermark_pos;
	global $rtwcpiglw_watermark_size_array ;
	global $rtwcpiglw_credit_note_font_array;
	$settings =	array(
		'section_title' => array(
			'name'     => '',
			'type'     => 'title',
			'desc'     => '',
			'id'       => ''
		),
		array(
			'name' 		=> esc_html__( 'Show Watermark Text', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'checkbox',
			'desc' 		=> esc_html__( 'Check it if you want to show Watermark text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc_tip' =>  true,
			'id'   		=> 'rtwcpiglw_enable_creditnote_text_watermark',
			'class'    => 'rtwcpiglw_credinote_wtrmrk'
		),
		array(
			'id'          => 'rtwcpiglw_creditnote_watermark_font',
			'class'       => 'rtwcpiglw_creditnote_text_add_watermark',
			'option_key'  => 'watermark_font',
			'name'       => esc_html__( 'Watermark Text', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc' => esc_html__( 'Choose the font family of Watermark text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type'        => 'select',
			'options'     => $rtwcpiglw_credit_note_font_array,
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Watermark Rotation', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Enter your required rotation(in degree) for Watermark text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_pckngslp_watermark_rotation',
			'class'       => 'rtwcpiglw_creditnote_text_add_watermark',
			'default'	=> '15',
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Watermark Text:', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'textarea',
			'desc' 		=> esc_html__( 'Enter Watermark Text which you want to show on PDF.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_creditnote_watermark_text',
			'class'       => 'rtwcpiglw_creditnote_text_add_watermark',
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Text Transparency', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Enter the text Transparency of Watermark.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_credit_watermark_text_trans',
			'class'       => 'rtwcpiglw_creditnote_text_add_watermark',
			'default'	=> '0.1',
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Watermark Image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'checkbox',
			'desc' 		=> esc_html__( 'Check it if you want to show Watermark image.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc_tip' =>  true,
			'id'   		=> 'rtwcpiglw_enable_creditnote_image_watermark',
			'class'    => 'rtwcpiglw_creditnote_imgwtrmk'
		),
		array(
			'name' 		=> esc_html__( 'Image Transparency', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Enter the image transparency of Watermark.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_creditnote_watermark_image_trans',
			'class'     => 'rtwcpiglw_creditnote_add_watermark_image',
			'default'	=> '0.1',
			'desc_tip' =>  true,
		),
		array(
			'id'          => 'rtwcpiglw_creditnote_watermark_img_dim',
			'option_key'  => 'rtwcpiglw_creditnote_watermark_img_dim',
			'name'       => esc_html__( 'Image Dimention', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc' => esc_html__( 'Choose the font family of Watermark text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type'        => 'select',
			'class'     => 'rtwcpiglw_creditnote_add_watermark_image',
			'options'     => $rtwcpiglw_watermark_size_array,
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Integer Value', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Set the integer value for position of Watermark Image.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_creditnote_water_img_dim_int',
			'class'     => 'rtwcpiglw_creditnote_add_watermark_image_dimen_integer',
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Image Width', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Set the Width of Watermark Image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_creditnote_water_img_dim_width',
			'class'     => 'rtwcpiglw_creditnote_add_watermark_image_dimension',
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Image Height', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Set the Height of Watermark Image.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_creditnote_water_img_dim_height',
			'class'     => 'rtwcpiglw_creditnote_add_watermark_image_dimension',
			'desc_tip' =>  true,
		),
		array(
			'id'          => 'rtwcpiglw_creditnote_watermark_img_pos',
			'option_key'  => 'rtwcpiglw_creditnote_watermark_img_pos',
			'name'       => esc_html__( 'Image Position', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc' => esc_html__( 'Choose the font family of Watermark text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type'        => 'select',
			'class'       => 'rtwcpiglw_creditnote_doc-add-watermark-image-pos-select',
			'options'     => $rtwcpiglw_watermark_pos,
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Vertical Position', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Set the vertical position of Watermark Image.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_creditnote_watermark_img_pos_y',
			'class'     => 'rtwcpiglw_creditnote_add_watermark_image_pos',
			'desc_tip' =>  true,
		),
		array(
			'name' 		=> esc_html__( 'Horizontal Position', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'number',
			'desc' 		=> esc_html__( 'Set the horizontal position of Watermark Image.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'id'   		=> 'rtwcpiglw_creditnote_watermark_img_pos_x',
			'class'     => 'rtwcpiglw_creditnote_add_watermark_image_pos',
			'desc_tip' =>  true,
		),

		'section_end' => array(
			'type' => 'sectionend',
			'id' => 'rtwcpiglw_creditnote_watermark_setting_opt'
		)
	);

return $settings;
}
?>
