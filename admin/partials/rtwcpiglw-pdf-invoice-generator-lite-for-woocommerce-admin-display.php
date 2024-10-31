<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    rtwcpiglw_WooCommerce_Pdf_Invoice_Generator
 * @subpackage rtwcpiglw_WooCommerce_Pdf_Invoice_Generator/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

global $rtwcpiglw_font_array ;
global $rtwcpiglw_page_size ;

$rtwcpiglw_basic_active = '';
$rtwcpiglw_header_active = '';
$rtwcpiglw_footer_active = '';
$rtwcpiglw_css_active = '';
$rtwcpiglw_watermark_active = '';
$rtwcpiglw_normal_invoice_active = '';
$rtwcpiglw_proforma_invoice_active = '';
$rtwcpiglw_product_and_tax_active = '';
$rtwcpiglw_pdf_invoice_format_active = '';
$rtwcpiglw_pdf_invoice_help_active = '';
$rtwcpiglw_pdf_invoice_comparision_active = '';

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
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_normal_invoice") 
	{
		$rtwcpiglw_normal_invoice_active = "nav-tab-active";
	}
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_proforma_invoice") 
	{
		$rtwcpiglw_proforma_invoice_active = "nav-tab-active";
	}
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_product_and_tax") 
	{
		$rtwcpiglw_product_and_tax_active = "nav-tab-active";
	}
	elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_pdf_invoice_format") 
	{
		$rtwcpiglw_pdf_invoice_format_active = "nav-tab-active";
	}
	elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_pdf_invoice_help_section")
	{
		$rtwcpiglw_pdf_invoice_help_active = "nav-tab-active";
	}
	elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_pdf_invoice_comparision_section")
	{
		$rtwcpiglw_pdf_invoice_comparision_active = "nav-tab-active";
	}
}
else
{
	$rtwcpiglw_normal_invoice_active = "nav-tab-active";
} 

?>

<!-- <div class="rtw_sb_popup">
	<div class="rtw_sb_card">
		<div class="rtw_sb_card_label">
			<label>Limited Period Offer</label>
		</div>
		<div class="rtw_sb_card_body">
			<div class="rtw_sb_close_popup">
				<div class="rtw_sb_close_icon"></div>
			</div>
			<h2><c?php echo esc_html__('Get PRO @ 20% Off','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></h2>
			<a class="rtw_sb_link" href="https://codecanyon.net/item/woocommerce-pdf-invoice-packing-slip-generator/24179339" target="_blank"> <button id="rtw_sb_banner_button">< ?php echo esc_html__('Buy Now','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></button></a>
			<p class="rtw_popper"><img src="< ?php echo RTWCPIGLW_URL.'/assets/party-popper.png'?>" alt="offer popper image"></p>
			<p class="rtw_sb_price">< ?php echo esc_html__('Just in','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?><span><strike>$29</strike></span><span>$23</span></p>
			<p class="rtw_sb_bottom_text">< ?php echo esc_html__('* Hurry up offer valid till','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?><span class="rtw_sb_date">< ?php echo esc_html__('18th August','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span></p>
		</div>
	</div>
</div> -->

<div class="main-wrapper">
	<div class="rtwcpiglw_admin_wrapper">
		<h2 class="rtw-main-heading">
			<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/Plugin_icon.png' ); ?>" alt="">
			<span><?php echo esc_html__('PDF Invoice & Packing Slip Generator Lite For WooCommerce','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?></span>
		</h2>
		<nav class="<?php echo esc_attr( 'rtw-navigation-wrapper nav-tab-wrapper' ); ?>">
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo  esc_attr($rtwcpiglw_normal_invoice_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_normal_invoice');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/Normal-Invoice-settings.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('Normal Invoice','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo  esc_attr($rtwcpiglw_proforma_invoice_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_proforma_invoice');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/Proforma-Invoice-settings.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('Proforma Invoice','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo  esc_attr($rtwcpiglw_product_and_tax_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_product_and_tax');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/Tax-settings.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('Product & Tax','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo  esc_attr($rtwcpiglw_basic_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_basic');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/basic.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('PDF Basic','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_header_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_header');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/header.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('PDF Header','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_footer_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_footer');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/footer.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('PDF Footer','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_css_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_css');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/css.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('PDF CSS','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_watermark_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_watermark');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/watermark.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('PDF WaterMark','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_pdf_invoice_format_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_pdf_invoice_format');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/Packing-Slip-format.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('Invoice Format','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_pdf_invoice_help_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_pdf_invoice_help_section');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/help.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('Help Desk','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
			</a>
			<a class="<?php echo esc_attr( 'nav-tab' ); ?> <?php echo esc_attr($rtwcpiglw_pdf_invoice_comparision_active);?>" href="<?php echo esc_url(get_admin_url().'admin.php?page=rtwcpiglw-pdf-invoice-settings&rtwcpiglw_tab=rtwcpiglw_pdf_invoice_comparision_section');?>">
				<div class="rtwcpiglw_tab_icon">
					<img src="<?php echo esc_url( RTWCPIGLW_URL.'assets/compare.png' ); ?>" alt="">
				</div>
				<?php echo esc_html__('Compare With Pro','rtwcpiglw-pdf-invoice-generator-lite-for-woocommerce');?>
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
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_basic.php');
				}
				elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_header")
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_header.php');
				}
				elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_footer") 
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_footer.php');
				}
				elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_css") 
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_css.php');
				}
				elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_watermark") 
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_watermark.php');
				}
				elseif (sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_normal_invoice")
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_normal_invoice.php');
				}
				elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_proforma_invoice")
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_proforma_invoice.php');
				}
				elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_product_and_tax")
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_product_and_tax.php');
				}
				elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_pdf_invoice_format")
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_pdf_invoice_format.php');
				}
				elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_pdf_invoice_help_section")
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_pdf_invoice_helpdesk.php');
				}
				elseif(sanitize_text_field($_GET['rtwcpiglw_tab']) == "rtwcpiglw_pdf_invoice_comparision_section")
				{
					include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_pdf_invoice_comparision_section.php');
				}
			}
			else
			{
				include_once(RTWCPIGLW_DIR.'/admin/partials/rtwcpiglw_tabs/rtwcpiglw_normal_invoice.php');
			}
			if(isset(($_GET['rtwcpiglw_tab'])) && (sanitize_text_field($_GET['rtwcpiglw_tab']) != "rtwcpiglw_pdf_invoice_help_section") && (sanitize_text_field($_GET['rtwcpiglw_tab']) != "rtwcpiglw_pdf_invoice_comparision_section"))
			{
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
