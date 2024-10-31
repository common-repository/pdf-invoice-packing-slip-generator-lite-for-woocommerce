<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.redefiningtheweb.com
 * @since      1.4.0
 *
 * @package    rtwcpiglw_WooCommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_WooCommerce_Pdf_Invoice_Generator/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

global $rtwcpiglw_credit_note_font_array;
global $rtwcpiglw_page_size;

$rtwcpiglw_basic_active = '';
$rtwcpiglw_header_active = '';
$rtwcpiglw_footer_active = '';
$rtwcpiglw_css_active = '';
$rtwcpiglw_watermark_active = '';
$rtwcpiglw_credit_note_format_active = '';

$rtwcpiglw_custom_fonts = get_option('rtwcpiglw_custom_fonts', array());
if(!class_exists('mPDF'))
{	
	include(RTWCPIGLW_DIR ."includes/mpdf/autoload.php");
}
$rtwcpiglw_mpdf = new \Mpdf\Mpdf();
$rtwcpiglw_merge_font = array();

if( !empty( $rtwcpiglw_custom_fonts ) ) 
{
	foreach( $rtwcpiglw_custom_fonts as $key=> $value )
	{
		$rtwcpiglw_merge_font[$key] = $key;
	}
}

foreach ($rtwcpiglw_mpdf->fontdata as $rtwcpiglw_key=> $rtwcpiglw_value)
{
	$rtwcpiglw_mpdf_font[$rtwcpiglw_key] = $rtwcpiglw_key;
}
$rtwcpiglw_fonts = array_merge( $rtwcpiglw_mpdf_font, $rtwcpiglw_merge_font );

if (isset(($_GET['rtwcpiglw_tab']))) 
{
	if (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_basic") 
	{
		$rtwcpiglw_basic_active = "nav-tab-active";
	}
	if(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_header")
	{
		$rtwcpiglw_header_active = "nav-tab-active";
	}
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_footer") 
	{
		$rtwcpiglw_footer_active = "nav-tab-active";
	}
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_css") 
	{
		$rtwcpiglw_css_active = "nav-tab-active";
	}
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_watermark") 
	{
		$rtwcpiglw_watermark_active = "nav-tab-active";
	}
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_credit_note_format") 
	{
		$rtwcpiglw_credit_note_format_active = "nav-tab-active";
	}
}
else
{
	$rtwcpiglw_basic_active = "nav-tab-active";
} 

?>

<div class="main-wrapper">
	<div class="rtwcpiglw_admin_wrapper">
		<div class="rotated_text">
			<h2 style=""><?php echo esc_html__('These features are available in Pro','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></h2>
		</div>
		<h2 class="rtw-main-heading">
			<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/Plugin_icon.png' ); ?>" alt="">
			<span><?php echo esc_html__('PDF Invoice & Packing Slip Generator Lite For WooCommerce','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span>
		</h2>
		<nav class="<?php echo esc_attr( 'rtw-navigation-wrapper nav-tab-wrapper' ); ?>">
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo  esc_attr($rtwcpiglw_basic_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-credit-note-settings&rtwcpiglw_tab=rtwcpiglw_basic');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/basic.png' ); ?>" alt="">
					</div><?php echo esc_html__('Credit Note Basic','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
				</a>
				<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_header_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-credit-note-settings&rtwcpiglw_tab=rtwcpiglw_header');?>"><div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/header.png' ); ?>" alt="">
					</div><?php echo esc_html__('Credit Note Header','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
				</a>
				<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_footer_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-credit-note-settings&rtwcpiglw_tab=rtwcpiglw_footer');?>"><div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/footer.png' ); ?>" alt="">
					</div><?php echo esc_html__('Credit Note Footer','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
				</a>
				<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_css_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-credit-note-settings&rtwcpiglw_tab=rtwcpiglw_css');?>">
					<div class="rtwcpiglw_tab_icon">
						<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/css.png' ); ?>" alt="">
						</div><?php echo esc_html__('Credit Note CSS','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
					</a>
					<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_watermark_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-credit-note-settings&rtwcpiglw_tab=rtwcpiglw_watermark');?>"><div class="rtwcpiglw_tab_icon">
						<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/watermark.png' ); ?>" alt="">
						</div><?php echo esc_html__('Credit Note WaterMark','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
					</a>
					<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_credit_note_format_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-credit-note-settings&rtwcpiglw_tab=rtwcpiglw_credit_note_format');?>">
						<div class="rtwcpiglw_tab_icon">
							<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/Packing-Slip-format.png' ); ?>" alt="">
							</div><?php echo esc_html__('Credit Note Format','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
						</a>
					</nav>
					<?php 
					settings_errors();
					?>

					
					<form enctype="multipart/form-data" action=" "  method="post" />
					<?php
					if(isset(($_GET['rtwcpiglw_tab'])))
					{
						if(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_basic")
						{
							include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_basic_setting.php');
						}
						elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_header")
						{
							include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_header_setting.php');
						}
						elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_footer") 
						{
							include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_footer_setting.php');
						}
						elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_css") 
						{
							include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_css_setting.php');
						}
						elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_watermark") 
						{
							include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_watermark_setting.php');
						}
						elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_credit_note_format")
						{
							include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_format.php');
						}
						elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_credit_note_help_section")
						{
							include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_help.php');
						}
					}
					else
					{
						include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_credit_note_tabs/rtwcpiglw_credit_note_basic_setting.php');
					}
					if(!isset(($_GET['rtwcpiglw_tab'])) || sanitize_text_field($_GET['rtwcpiglw_tab']) != "rtwcpiglw_credit_note_help_section"){
						?>
						<p class="submit">
							<input type="submit" value="<?php esc_attr_e('Save changes','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>" class="rtw-button" name="rtwcpiglw_submit">
						</p>
					</form>
				<?php } ?>
			</div>
		</div>

		<footer class="rtwcpiglw-footer">
			<p>
				<span>
					<?php esc_html_e( 'WooCommerce PDF Invoice & Packing Slip Generator By', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?>
				</span>
				<a href="<?php echo esc_url( 'https://www.codecanyon.net/user/redefiningtheweb/portfolio' ); ?>" target="_blank">
					<?php esc_html_e( 'RedefiningTheWeb', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?>
				</a>
			</p>
			<a href="<?php echo esc_url( "https://redefiningtheweb.com/docs/woocommerce-pdf-invoice-generator/overview/" ) ?>" target="_blank" class="rtwcpiglw-button">
				<?php esc_html_e( 'Documentation', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?>
			</a>
			<a href="<?php echo esc_url( "https://codecanyon.net/item/woocommerce-pdf-invoice-packing-slip-generator/reviews/24179339" ); ?>" class="rtwcpiglw-button">
				<?php esc_html_e( '5-Stars Rating', 'rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce' ); ?>
			</a>
		</footer>