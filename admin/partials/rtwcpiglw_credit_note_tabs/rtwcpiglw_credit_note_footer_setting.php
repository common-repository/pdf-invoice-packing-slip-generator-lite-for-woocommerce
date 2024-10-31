<?php

	foreach ($rtwcpiglw_fonts as $rtwcpiglw_key => $rtwcpiglw_value) 
	{
		$rtwcpiglw_credit_note_font_array[$rtwcpiglw_key] = $rtwcpiglw_value ;
	}
 
?>

	<div class="rtwcpiglw_tab_div">
		<?php woocommerce_admin_fields(rtwcpiglw_credit_note_footer_settings()); ?> 
	</div>

	<table class="wp-list-table form-table rtw-table">
		<tbody>
			<tr>
				<th><?php esc_html_e('Footer Html', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
				<td>
					<?php
					$rtwcpiglw_content = isset( $rtwcpiglw_get_setting['rtw_footer_html'] ) ? $rtwcpiglw_get_setting['rtw_footer_html'] : '';
					$rtwcpiglw_content = html_entity_decode( $rtwcpiglw_content );
					$rtwcpiglw_content = stripslashes( $rtwcpiglw_content );
					$rtwcpiglw_setting = array(
						'wpautop' => true,
						'media_buttons' => true,
						'textarea_name' => 'rtwcpiglw_credit_note_footer_setting_opt[rtw_footer_html]',
						'textarea_rows' => 7
					);
					wp_editor($rtwcpiglw_content, 'rtw_wcfp_footer_editor', $rtwcpiglw_setting );
					?>
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
function rtwcpiglw_credit_note_footer_settings()
{
global $rtwcpiglw_credit_note_font_array;
$settings =	array(
	'section_title' => array(
		'name'     => '',
		'type'     => 'title',
		'desc'     => '',
		'id'       => ''
	),
	array(
		'name' 		=> esc_html__( 'Footer Top Margin', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'type' 		=> 'number',
		'desc' 		=> esc_html__( 'Enter your required top margin (By default 15)', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'id'   		=> 'rtwcpiglw_credit_note_footer_top_margin',
		'default'   => '15',
		'desc_tip' =>  true,
	),
	array(
		'name' 		=> esc_html__( 'Footer Section Font Size', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'type' 		=> 'number',
		'desc' 		=> esc_html__( 'Enter your required font size for Pdf Footer(By default 15)', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'id'   		=> 'rtwcpiglw_credit_note_footer_font_size',
		'default'   => '15',
		'desc_tip' =>  true,
	),
	array(
		'id'          => 'rtwcpiglw_credit_note_footer_font_family',
		'option_key'  => 'rtwcpiglw_pckngslp_footer_font_family',
		'name'       => esc_html__( 'Footer Section Font', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'desc' => esc_html__( 'Select Font type for footer section text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'type'        => 'select',
		'options'     => $rtwcpiglw_credit_note_font_array,
		'desc_tip' =>  true,
	),

	'section_end' => array(
		'type' => 'sectionend',
		'id' => 'rtwcpiglw_credit_note_footer_setting_optn'
	)
);

return $settings;
}
?>