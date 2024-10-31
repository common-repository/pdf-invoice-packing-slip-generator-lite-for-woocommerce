<div class="rtwcpiglw_tab_div">
	<?php woocommerce_admin_fields(rtwcpiglw_credit_note_basics_settings()); ?> 
</div>

<table class="wp-list-table form-table rtw-table">
	<tbody>
		<tr>
			<th class="descr"><?php esc_html_e('Set background Image for Credit Note PDF', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
			<td>
				<?php $rtwcpiglw_src_img = isset($rtwcpiglw_get_setting['bck_img_url'] ) ? $rtwcpiglw_get_setting['bck_img_url'] : '';?>
				<div id="rtwcpiglw_credit_note_bckgrnd_img">
					<img id="rtwcpiglw_credit_note_bckgrnd_img_btn" src="<?php echo esc_url($rtwcpiglw_src_img); ?>"/>
				</div>
				<div id="rtwcpiglw_bck_img">
					<input type="hidden" id="rtwcpiglw_credit_note_bck_img_url"
					name=""
					value="<?php echo esc_attr($rtwcpiglw_src_img); ?>" />
					<button type="button" class="rtwcpiglw_credit_note_bckgrnd_img_upload button"><?php esc_html_e( 'Upload/Add image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button><br>
					<?php if($rtwcpiglw_src_img != ''){ ?>
						<button type="button" class="rtwcpiglw_btn_remove_credit_note_bckgrnd_img button"><?php esc_html_e( 'Remove image', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></button>
					<?php } ?>
				</div>
				<div class="descr"><?php esc_html_e('Choose your Image which you want to show as background image in generated PDF Invoice.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
			</td>
		</tr>
		<tr>
			<th class="descr"><?php esc_html_e('Select Background color For Credit Note PDF', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
			<td>
				<?php $rtwcpiglw_back_color = isset($rtwcpiglw_get_setting['back_color'] ) ? $rtwcpiglw_get_setting['back_color'] : ''; ?>
				<div class="wp-picker-container">
					<input class="color-field" type="text" name="" value="<?php echo esc_attr($rtwcpiglw_back_color); ?>" />
				</div>
				<div class="descr"><?php esc_html_e('Choose the color for your Credit Note pdf background.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></div>
			</td>
		</tr>
	</tbody>
</table>
<?php 

/**
* function for display woocommerce settings.
*
* @since    1.0.0
*/

function rtwcpiglw_credit_note_basics_settings()
{
	$settings =	array(
		'section_title' => array(
			'name'     => '',
			'type'     => 'title',
			'desc'     => '',
			'id'       => ''
		),
		array(
			'name' 		=> esc_html__( 'Enable Credit Note', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'checkbox',
			'desc' 		=> esc_html__( 'Check it if you want generate Credit Note for orders.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc_tip'  =>  true,
			'id'   		=> 'rtwcpiglw_enable_credit_note',
		),
		array(
			'name' 		=> esc_html__( 'Download Credit Note', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'checkbox',
			'desc' 		=> esc_html__( 'Check it if you want to download Credit Note of an order  from Order List Page', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc_tip'  =>  true,
			'id'   		=> 'rtwcpiglw_download_credit_note',
		),
		array(
			'name' 		=> esc_html__( 'Rtl Support', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'checkbox',
			'desc' 		=> esc_html__( 'Check it if you want generate Credit Note in Arabic or languages which start from right align.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc_tip'  =>  true,
			'id'   		=> 'rtwcpiglw_credit_note_rtl',
		),
		array(
			'name' 		=> esc_html__( 'Hide Page No.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'type' 		=> 'checkbox',
			'desc' 		=> esc_html__( 'Check it if you want Hide Credit Note page no.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
			'desc_tip'  =>  true,
			'id'   		=> 'rtwcpiglw_credit_note_page_no'
		),
		'section_end' => array(
			'type' => 'sectionend',
			'id' => 'rtwcpiglw_credit_note_basic_stng_opt'
		)
	);

	return $settings;
}
?>
