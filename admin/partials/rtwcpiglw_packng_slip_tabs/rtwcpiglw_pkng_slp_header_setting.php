<?php

	foreach ($rtwcpiglw_fonts as $rtwcpiglw_key => $rtwcpiglw_value) 
	{
		$rtwcpiglw_pkngslp_font_array[$rtwcpiglw_key] = $rtwcpiglw_value ;
	}

	if(isset(($_POST['rtwcpiglw_submit']))) {
		?>
		<div class="notice notice-success is-dismissible">
			<p><strong><?php esc_html_e('Settings saved.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></strong></p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text"><?php esc_html_e('Dismiss this notices.','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce'); ?></span>
			</button>
			</div><?php
			
			update_option( 'rtwcpiglw_pkngslp_header_stng_opt', sanitize_post($_POST['rtwcpiglw_pkngslp_header_stng_opt']) );
			woocommerce_update_options( rtwcpiglw_pkngslp_header_settings());
		}
		settings_fields('rtwcpiglw_pckngslp_header_setting');
		$rtwcpiglw_get_setting = get_option('rtwcpiglw_pkngslp_header_stng_opt');
?>

	<div class="rtwcpiglw_tab_div">
		<?php woocommerce_admin_fields(rtwcpiglw_pkngslp_header_settings()); ?> 
	</div>

	<table class="wp-list-table form-table rtw-table">
		<tbody>
			<tr>
				<th><?php esc_html_e('Header Html', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></th>
				<td>
					<?php
					$rtwcpiglw_content = isset( $rtwcpiglw_get_setting['rtw_header_html'] ) ? $rtwcpiglw_get_setting['rtw_header_html'] : '';
					$rtwcpiglw_content = html_entity_decode( $rtwcpiglw_content );
					$rtwcpiglw_content = stripslashes( $rtwcpiglw_content );
					$rtwcpiglw_setting = array(
						'wpautop' => true,
						'media_buttons' => true,
						'textarea_name' => 'rtwcpiglw_pkngslp_header_stng_opt[rtw_header_html]',
						'textarea_rows' => 7
					);
					wp_editor($rtwcpiglw_content, 'rtwcpiglw_header_editor', $rtwcpiglw_setting );
					?>
				</td>
			</tr> 
		</tbody>	
	</table>
<?php 
/**
* function for display WooCommerce settings.
*
* @since    1.0.0
*/
function rtwcpiglw_pkngslp_header_settings()
{
global $rtwcpiglw_pkngslp_font_array;
$settings =	array(
	'section_title' => array(
		'name'     => '',
		'type'     => 'title',
		'desc'     => '',
		'id'       => 'rtwcpiglw_pkngslp_header_stng_optn'
	),
	array(
		'name' 		=> esc_html__( 'Header Top Margin', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'type' 		=> 'number',
		'desc' 		=> esc_html__( 'Enter your required top margin (By default 7)', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'id'   		=> 'rtwcpiglw_pkngslp_header_top_margin',
		'default'	=> '7',
		'desc_tip' =>  true,
	),
	array(
		'id'          => 'rtwcpiglw_pkngslp_header_font',
		'option_key'  => 'rtwcpiglw_pkngslp_header_font',
		'name'       => esc_html__( 'Header Section Font', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'desc' => esc_html__( 'Select Font type for Header section text.', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'type'        => 'select',
		'options'     => $rtwcpiglw_pkngslp_font_array,
		'desc_tip' =>  true,
	),
	array(
		'name' 		=> esc_html__( 'Header Section Font Size', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'type' 		=> 'number',
		'desc' 		=> esc_html__( 'Enter your required font size for Pdf Header(By default 15)', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ),
		'id'   		=> 'rtwcpiglw_pkngslp_header_font_size',
		'default'	=> '15',
		'desc_tip' =>  true,
	),
	'section_end' => array(
		'type' => 'sectionend',
		'id' => 'rtwcpiglw_pkngslp_header_stng_optn'
	)
);

return $settings;
}
?>