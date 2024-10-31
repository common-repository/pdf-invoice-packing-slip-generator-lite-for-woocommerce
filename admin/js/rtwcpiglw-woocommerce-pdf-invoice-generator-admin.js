(function( $ ) {
	'use strict';

	
	 jQuery(document).ready(function() {
	 	var rtwcpiglw_val = jQuery('#pswrd_enable_val').val();
	 	var rtwcpiglw_val_2 = jQuery('#show_wtrmrk_txt').val();
	 	var rtwcpiglw_val_3 = jQuery('#show_wtrmrk_img').val();
	 	var rtwcpiglw_val_4 = jQuery('#wtrmrk_img_dim').val();
	 	var rtwcpiglw_val_5 = jQuery('#wtrmrk_img_pos').val();
	 	var rtwcpiglw_val_6 = jQuery('#pckngslp_show_wtrmrk_txt').val();
	 	var rtwcpiglw_val_7 = jQuery('#pckngslp_show_wtrmrk_img').val();
	 	var rtwcpiglw_val_8 = jQuery('#pckngslp_wtrmrk_img_dim').val();
	 	var rtwcpiglw_val_9 = jQuery('#pckngslp_wtrmrk_img_pos').val();
	 	var rtwcpiglw_val_10 = jQuery('#credi_note_show_wtrmrk_txt').val();
	 	var rtwcpiglw_val_11 = jQuery('#credi_note_show_wtrmrk_img').val();
	 	var rtwcpiglw_val_12 = jQuery('#credi_note_wtrmrk_img_dim').val();
	 	var rtwcpiglw_val_13 = jQuery('#credi_note_wtrmrk_img_pos').val();

	 	if (rtwcpiglw_val != 'yes') 
	 	{
	 		jQuery(".rtwcpiglw_add_pswrd_protctn").closest('tr').hide();
	 		jQuery("#admin_pswrd").closest('tr').hide();
	 	}
	 	if(rtwcpiglw_val_4 != 'INT')
	 	{
	 		jQuery(".rtwcpiglw_add_watermark_image_dimen_integer").closest('tr').hide();
	 	}
	 	if(rtwcpiglw_val_4 != 'array')
	 	{
	 		jQuery(".rtwcpiglw_add_watermark_image_dimension").closest('tr').hide();
	 	}
	 	if(rtwcpiglw_val_5 != 'arrays')
	 	{
	 		jQuery("#rtwcpiglw_watermark_img_pos_y").closest('tr').hide();
	 		jQuery("#rtwcpiglw_watermark_img_pos_x").closest('tr').hide();
	 	}
	 	if (rtwcpiglw_val_2 != 'yes') 
	 	{
	 		jQuery(".rtwcpiglw_text_add_watermark").closest('tr').hide();
	 	}
	 	if (rtwcpiglw_val_3 != 'yes') 
	 	{
	 		jQuery(".rtwcpiglw_add_watermark_image").closest('tr').hide();
	 		jQuery(".rtwcpiglw_add_watermark_image_dimen_integer").closest('tr').hide();
	 		jQuery(".rtwcpiglw_add_watermark_image_dimension").closest('tr').hide();
	 		jQuery(".rtwcpiglw_doc-add-watermark-image-pos-select").closest('tr').hide();
	 		jQuery(".rtwcpiglw_add_watermark_image_pos").closest('tr').hide();
	 		jQuery("#rtwcpiglw_add_watermark_img").hide();
	 	}
	 	if(rtwcpiglw_val_8 != 'INT')
	 	{
	 		jQuery(".rtwcpiglw_pckngslp_add_watermark_image_dimen_integer").closest('tr').hide();
	 	}
	 	if(rtwcpiglw_val_8 != 'array')
	 	{
	 		jQuery(".rtwcpiglw_pckngslp_add_watermark_image_dimension").closest('tr').hide();
	 	}
	 	if(rtwcpiglw_val_12 != 'array')
	 	{
	 		jQuery(".rtwcpiglw_creditnote_add_watermark_image_dimension").closest('tr').hide();
	 	}
	 	if(rtwcpiglw_val_9 != 'arrays')
	 	{
	 		jQuery("#rtwcpiglw_pckngslp_watermark_img_pos_y").closest('tr').hide();
	 		jQuery("#rtwcpiglw_pckngslp_watermark_img_pos_x").closest('tr').hide();
	 	}
	 	if(rtwcpiglw_val_13 != 'arrays')
	 	{
	 		jQuery("#rtwcpiglw_creditnote_watermark_img_pos_y").closest('tr').hide();
	 		jQuery("#rtwcpiglw_creditnote_watermark_img_pos_x").closest('tr').hide();
	 	}
	 	if (rtwcpiglw_val_6 != 'yes') 
	 	{
	 		jQuery(".rtwcpiglw_pckngslp_text_add_watermark").closest('tr').hide();
	 	}
	 	if (rtwcpiglw_val_10 != 'yes') 
	 	{
	 		jQuery(".rtwcpiglw_creditnote_text_add_watermark").closest('tr').hide();
	 	}
	 	if (rtwcpiglw_val_7 != 'yes') 
	 	{
	 		jQuery(".rtwcpiglw_pckngslp_add_watermark_image").closest('tr').hide();
	 		jQuery(".rtwcpiglw_pckngslp_add_watermark_image_dimen_integer").closest('tr').hide();
	 		jQuery(".rtwcpiglw_pckngslp_add_watermark_image_dimension").closest('tr').hide();
	 		jQuery(".rtwcpiglw_pckngslp_doc-add-watermark-image-pos-select").closest('tr').hide();
	 		jQuery(".rtwcpiglw_pckngslp_add_watermark_image_pos").closest('tr').hide();
	 		jQuery("#rtwcpiglw_pckngslp_add_watermark_img").hide();
	 	}
	 	if (rtwcpiglw_val_11 != 'yes') 
	 	{
	 		jQuery(".rtwcpiglw_creditnote_add_watermark_image").closest('tr').hide();
	 		jQuery(".rtwcpiglw_creditnote_add_watermark_image_dimen_integer").closest('tr').hide();
	 		jQuery(".rtwcpiglw_creditnote_add_watermark_image_dimension").closest('tr').hide();
	 		jQuery(".rtwcpiglw_creditnote_doc-add-watermark-image-pos-select").closest('tr').hide();
	 		jQuery(".rtwcpiglw_creditnote_add_watermark_image_pos").closest('tr').hide();
	 		jQuery("#rtwcpiglw_creditnote_add_watermark_img").hide();
	 	}
	 	jQuery('.rtwcpiglw_watermark_img_upload').on('click',function(){
	 		var rtwcpiglw_inputField = jQuery(this).parent('div');
	 		tb_show('watermark', 'media-upload.php?TB_iframe=true');
	 		window.send_to_editor = function(html)
	 		{  
	 			var rtwcpiglw_url = jQuery(html).find('img').attr('src');
	 			if(typeof rtwcpiglw_url == 'undefined')
	 				rtwcpiglw_url = jQuery(html).attr('src');	
	 			jQuery( '#rtwcpiglw_watermark_img_url' ).val( rtwcpiglw_url );
	 			jQuery( '#rtwcpiglw_watermark_img_backgrnd' ).find( 'img' ).attr( 'src', rtwcpiglw_url );
	 			jQuery( '.rtwcpiglw_watermark_remove_img' ).show();
	 			jQuery( '#rtwcpiglw_watermark_img_backgrnd' ).show();
	 			jQuery( '#rtwcpiglw_watermark_img' ).show();
	 			tb_remove();
	 		};
	 		return false;
	 	});
	 	jQuery( document ).on( 'click', '.rtwcpiglw_watermark_remove_img', function() {
	 		jQuery('#rtwcpiglw_watermark_img_url').val('');
	 		jQuery('#rtwcpiglw_watermark_img').attr('src', '');
	 		jQuery(this).hide();
	 		jQuery( '#rtwcpiglw_watermark_img' ).hide();
	 		return false;
	 	}); 

	 	jQuery('.rtwcpiglw_btn_img_upload').on('click',function(){
	 		var rtwcpiglw_inputField = jQuery(this).parent('div');
	 		tb_show('Button_img', 'media-upload.php?TB_iframe=true');
	 		window.send_to_editor = function(html)
	 		{  
	 			var rtwcpiglw_url = jQuery(html).find('img').attr('src');
	 			if(typeof rtwcpiglw_url == 'undefined')
	 				rtwcpiglw_url = jQuery(html).attr('src');	
	 			jQuery( '#rtwcpiglw_img_url' ).val( rtwcpiglw_url );
	 			jQuery( '#rtwcpiglw_btn_img' ).find( 'img' ).attr( 'src', rtwcpiglw_url );
	 			jQuery( '.rtwcpiglw_btn_remove_img' ).show();
	 			jQuery( '#rtwcpiglw_img_btn' ).show();
	 			tb_remove();
	 		};
	 		return false;
	 	});
	 	jQuery( document ).on( 'click', '.rtwcpiglw_btn_remove_img', function() {
	 		jQuery('#rtwcpiglw_img_url').val('');
	 		jQuery('#rtwcpiglw_img_btn').attr('src', '');
	 		jQuery(this).hide();
	 		jQuery( '#rtwcpiglw_img_btn' ).hide();
	 		return false;
	 	});

	 	$(document).on( 'change', '.rtwcpiglw_template_select', function(){
	 		if( $(this).val() == '1' ){
	 			$(document).find( '.rtwcpiglw_template_1' ).show();
	 			$(document).find( '.rtwcpiglw_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_template_6' ).hide();
	 		}
	 		if( $(this).val() == '2' ){
	 			$(document).find( '.rtwcpiglw_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_template_2' ).show();
	 			$(document).find( '.rtwcpiglw_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_template_6' ).hide();
	 		}
	 		if( $(this).val() == '3' ){
	 			$(document).find( '.rtwcpiglw_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_template_3' ).show();
	 			$(document).find( '.rtwcpiglw_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_template_6' ).hide();
	 		}
	 		if( $(this).val() == '4' ){
	 			$(document).find( '.rtwcpiglw_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_template_4' ).show();
	 			$(document).find( '.rtwcpiglw_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_template_6' ).hide();
	 		}
	 		if( $(this).val() == '5' ){
	 			$(document).find( '.rtwcpiglw_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_template_5' ).show();
	 			$(document).find( '.rtwcpiglw_template_6' ).hide();
	 		}
	 		if( $(this).val() == '6' ){
	 			$(document).find( '.rtwcpiglw_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_template_6' ).show();
	 		}
	 	});

	 	$(document).on( 'change', '.rtwcpiglw_credit_note_template_select', function(){
	 		if( $(this).val() == '1' ){
	 			$(document).find( '.rtwcpiglw_credit_note_template_1' ).show();
	 			$(document).find( '.rtwcpiglw_credit_note_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_6' ).hide();
	 		}
	 		if( $(this).val() == '2' ){
	 			$(document).find( '.rtwcpiglw_credit_note_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_2' ).show();
	 			$(document).find( '.rtwcpiglw_credit_note_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_6' ).hide();
	 		}
	 		if( $(this).val() == '3' ){
	 			$(document).find( '.rtwcpiglw_credit_note_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_3' ).show();
	 			$(document).find( '.rtwcpiglw_credit_note_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_6' ).hide();
	 		}
	 		if( $(this).val() == '4' ){
	 			$(document).find( '.rtwcpiglw_credit_note_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_4' ).show();
	 			$(document).find( '.rtwcpiglw_credit_note_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_6' ).hide();
	 		}
	 		if( $(this).val() == '5' ){
	 			$(document).find( '.rtwcpiglw_credit_note_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_5' ).show();
	 			$(document).find( '.rtwcpiglw_credit_note_template_6' ).hide();
	 		}
	 		if( $(this).val() == '6' ){
	 			$(document).find( '.rtwcpiglw_credit_note_template_1' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_2' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_3' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_4' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_5' ).hide();
	 			$(document).find( '.rtwcpiglw_credit_note_template_6' ).show();
	 		}
	 	});

	 	jQuery('.rtwcpiglw_btn_bckgrnd_img_upload').on('click',function(){
	 		var rtwcpiglw_inputField = jQuery(this).parent('div');
	 		tb_show('Background_img', 'media-upload.php?TB_iframe=true');
	 		window.send_to_editor = function(html)
	 		{  
	 			var rtwcpiglw_url = jQuery(html).find('img').attr('src');
	 			if(typeof rtwcpiglw_url == 'undefined')
	 				rtwcpiglw_url = jQuery(html).attr('src');	
	 			jQuery( '#rtwcpiglw_bck_img_url' ).val( rtwcpiglw_url );
	 			jQuery( '#rtwcpiglw_bckgrnd_img' ).find( 'img' ).attr( 'src', rtwcpiglw_url );
	 			jQuery( '.rtwcpiglw_btn_remove_bckgrnd_img' ).show();
	 			jQuery( '#rtwcpiglw_bckgrnd_img_btn' ).show();
	 			tb_remove();
	 		};
	 		return false;
	 	});

	 	jQuery('.rtwcpiglw_credit_note_bckgrnd_img_upload').on('click',function(){
	 		var rtwcpiglw_inputField = jQuery(this).parent('div');
	 		tb_show('Background_img', 'media-upload.php?TB_iframe=true');
	 		window.send_to_editor = function(html)
	 		{  
	 			var rtwcpiglw_credit_note_url = jQuery(html).find('img').attr('src');
	 			if(typeof rtwcpiglw_credit_note_url == 'undefined')
	 				rtwcpiglw_credit_note_url = jQuery(html).attr('src');	
	 			jQuery( '#rtwcpiglw_credit_note_bck_img_url' ).val( rtwcpiglw_credit_note_url );
	 			jQuery( '#rtwcpiglw_credit_note_bckgrnd_img' ).find( 'img' ).attr( 'src', rtwcpiglw_credit_note_url );
	 			jQuery( '.rtwcpiglw_btn_remove_credit_note_bckgrnd_img' ).show();
	 			jQuery( '#rtwcpiglw_credit_note_bckgrnd_img_btn' ).show();
	 			tb_remove();
	 		};
	 		return false;
	 	});

	 	jQuery( document ).on( 'click', '.rtwcpiglw_btn_remove_credit_note_bckgrnd_img', function() {
	 		jQuery('#rtwcpiglw_credit_note_bck_img_url').val('');
	 		jQuery('#rtwcpiglw_credit_note_bckgrnd_img_btn').attr('src', '');
	 		jQuery(this).hide();
	 		jQuery( '#rtwcpiglw_credit_note_bckgrnd_img_btn' ).hide();
	 		return false;
	 	});

	 	jQuery( document ).on( 'click', '.rtwcpiglw_btn_remove_bckgrnd_img', function() {
	 		jQuery('#rtwcpiglw_bck_img_url').val('');
	 		jQuery('#rtwcpiglw_bckgrnd_img_btn').attr('src', '');
	 		jQuery(this).hide();
	 		jQuery( '#rtwcpiglw_bckgrnd_img_btn' ).hide();
	 		return false;
	 	});
	 	jQuery('.woocommerce-help-tip').tipTip({
	 		'attribute': 'data-tip',
	 		'fadeIn': 50,
	 		'fadeOut': 50,
	 		'delay': 200
	 	});

	 	$('.color-field').wpColorPicker(); 
	 	
	 	jQuery(document).on('click', '.rtwcpiglw_wtrmrk', function(){
	 		rtwcpiglw_showHideCheck('rtwcpiglw_text_add_watermark', this);
	 	});

	 	jQuery(document).on('click', '.rtwcpiglw_pckngslp_wtrmrk', function(){
	 		rtwcpiglw_pckngslp_showHideCheck('rtwcpiglw_pckngslp_text_add_watermark', this);
	 	});

	 	jQuery(document).on('click', '.rtwcpiglw_credinote_wtrmrk', function(){
	 		rtwcpiglw_creditnote_showHideCheck('rtwcpiglw_creditnote_text_add_watermark', this);
	 	});

	 	jQuery(document).on('click', '#table_border', function(){
	 		rtwcpiglw_showHideCheck('table_brdr_class', this);
	 	});
	 	jQuery(document).on('click', '#table_th_border', function(){
	 		rtwcpiglw_showHideCheck('table_td_class', this);
	 	});
	 	jQuery(document).on('click', '#table_td_border', function(){
	 		rtwcpiglw_showHideCheck('table_th_class', this);
	 	});
	 	
	 	jQuery(document).on('click', '.rtwcpiglw_imgwtrmk', function(){
	 		rtwcpiglw_imgshowHideCheck('rtwcpiglw_add_watermark_image', this);
	 	});

	 	jQuery(document).on('click', '.rtwcpiglw_pckngslp_imgwtrmk', function(){
	 		rtwcpiglw_pckngslp_imgshowHideCheck('rtwcpiglw_pckngslp_add_watermark_image', this);
	 	});

	 	jQuery(document).on('click', '.rtwcpiglw_creditnote_imgwtrmk', function(){
	 		rtwcpiglw_creditnote_imgshowHideCheck('rtwcpiglw_creditnote_add_watermark_image', this);
	 	}); 
	 	
	 	jQuery(document).on('click', '#rtwcpiglw_enable_paswrd', function(){
	 		rtwcpiglw_addPasswordprotctn('rtwcpiglw_add_pswrd_protctn', this);
	 	});

	 	jQuery(document).on('change', '.rtwcpiglw_doc-add-watermark-image-pos-select', function(){
	 		rtwcpiglw_showHidePos();
	 	});

	 	jQuery(document).on('change', '.rtwcpiglw_creditnote_doc-add-watermark-image-pos-select', function(){
	 		rtwcpiglw_creditnote_showHidePos();
	 	});

	 	jQuery(document).on('change', '.rtwcpiglw_pckngslp_doc-add-watermark-image-pos-select', function(){
	 		rtwcpiglw_pckngslp_showHidePos();
	 	}); 

	 	jQuery(document).on('change', '#rtwcpiglw_watermark_img_dim', function(){
	 		var rtwcpiglw_value=jQuery("#rtwcpiglw_watermark_img_dim").val();
	 		rtwcpiglw_showHideImage(rtwcpiglw_value);
	 	});

	 	jQuery(document).on('change', '#rtwcpiglw_pckngslp_watermark_img_dim', function(){
	 		var rtwcpiglw_v =jQuery("#rtwcpiglw_pckngslp_watermark_img_dim").val();
	 		rtwcpiglw_pckngslp_showHideImage(rtwcpiglw_v);
	 	});

	 	jQuery(document).on('change', '#rtwcpiglw_creditnote_watermark_img_dim', function(){
	 		var rtwcpiglw_v =jQuery("#rtwcpiglw_creditnote_watermark_img_dim").val();
	 		rtwcpiglw_creditnote_showHideImage(rtwcpiglw_v);
	 	});

	 	jQuery(document).on('click', '#enable_packing_slip', function(){
	 		$('#rtwcpiglw_pkng_slp_frmt').toggle();
	 	});

	 	jQuery(document).on('click', '#rtwcpiglw_dlt_profrma', function(){
	 		var order_id = jQuery("#rtwcpiglw_dlt_profrma").attr('data-order_id');
	 		var rtwcpiglw_data = {
	 			action 			: 'rtwcpiglw_delete_invoice',
	 			order_id 		: order_id,
	 			rtwcpiglw_security_check	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
	 		};
	 		$.blockUI({ message: '' });
	 		$.ajax({
	 			type: "POST",
	 			url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl,
	 			data: rtwcpiglw_data,
	 			dataType: 'json',
	 			success: function( data ) {
	 				$.unblockUI();
	 				if(data)
	 				{
	 					$('#rtwcpiglw_dlt_profrma').hide();
	 					$('#rtwcpiglw_prfrm_btn').hide();
	 					$('#rtwcpiglw_regnrt_invoice').show();
	 				}
	 				else
	 				{
	 					alert( data.rtwcpiglw_message );
	 				}
	 			}
	 		});
	 	});

	 	$(document).on('click','.rtwwqcp-faq-heading' ,function(){
	 		
	 		if ($(this).next('.rtwwqcp-faq-desc').is(':hidden')){
	 			$('.rtwwqcp-faq-heading').removeClass('active');
	 			$('.rtwwqcp-faq-desc').slideUp("3000");
	 			$(this).addClass('active');
	 			$(this).next('.rtwwqcp-faq-desc').slideToggle("3000");
	 		}
	 		else{
	 			$('.rtwwqcp-faq-heading').removeClass('active');
	 			$('.rtwwqcp-faq-desc').slideUp("3000");
	 		}

	 	});
	 	
	 	jQuery(document).on('click', '#rtwcpiglw_dlt_nrml', function(){
	 		var order_id = jQuery("#rtwcpiglw_dlt_nrml").attr('data-order_id');
	 		var rtwcpiglw_data = {
	 			action 			: 'rtwcpiglw_delete_invoice',
	 			order_id 		: order_id,
	 			rtwcpiglw_security_check	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
	 		};
	 		$.blockUI({ message: '' });
	 		$.ajax({
	 			type: "POST",
	 			url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl,
	 			data: rtwcpiglw_data,
	 			dataType: 'json',
	 			success: function( data ) {
	 				$.unblockUI();
	 				if(data)
	 				{
	 					$('#rtwcpiglw_dlt_nrml').hide();
	 					$('#rtwcpiglw_nrml_btn').hide();
	 					$('#rtwcpiglw_regnrt_invoice').show();
	 				}
	 				else
	 				{
	 					alert( data.rtwcpiglw_message );
	 				}	
	 			}
	 		});
	 	});

	 	jQuery(document).on('click', '#rtwcpiglw_dlt_shiping_lbl', function(){
	 		var order_id = jQuery("#rtwcpiglw_dlt_shiping_lbl").attr('data-order_id');
	 		var rtwcpiglw_data = {
	 			action 			: 'rtwcpiglw_delete_shiping_lbl',
	 			order_id 		: order_id,
	 			rtwcpiglw_security_check	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
	 		};
	 		$.blockUI({ message: '' });
	 		$.ajax({
	 			type: "POST",
	 			url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl,
	 			data: rtwcpiglw_data,
	 			dataType: 'json',
	 			success: function( data ) {
	 				$.unblockUI();
	 				if(data)
	 				{
	 					$('#rtwcpiglw_shiping_lbl').hide();
	 					$('#rtwcpiglw_dlt_shiping_lbl').hide();
	 					$('#rtwcpiglw_regnrt_shipping_lbl').show();
	 				}
	 				else
	 				{
	 					alert( data.rtwcpiglw_message );
	 				}	
	 			}
	 		});
	 	});

	 	jQuery(document).on('click', '#rtwcpiglw_dlt_pckng_slp', function(){
	 		var order_id = jQuery("#rtwcpiglw_dlt_pckng_slp").attr('data-order_id');
	 		var rtwcpiglw_data = {
	 			action 			: 'rtwcpiglw_delete_packng_slp',
	 			order_id 		: order_id,
	 			rtwcpiglw_security_check	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
	 		};
	 		$.blockUI({ message: '' });
	 		$.ajax({
	 			type: "POST",
	 			url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl,
	 			data: rtwcpiglw_data,
	 			dataType: 'json',
	 			success: function( data ) {
	 				$.unblockUI();
	 				if(data)
	 				{
	 					$('#rtwcpiglw_pckng_slp').hide();
	 					$('#rtwcpiglw_dlt_pckng_slp').hide();
	 					$('#rtwcpiglw_regnrt_pckng_slp').show();
	 				}
	 				else
	 				{
	 					alert( data.rtwcpiglw_message );
	 				}	
	 			}
	 		});
	 	});

	 	jQuery(document).on('click', '#rtwcpiglw_regnrt_invoice', function(){
	 		var order_id = jQuery("#rtwcpiglw_regnrt_invoice").attr('data-order_id');
	 		var order_status = jQuery("#rtwcpiglw_regnrt_invoice").attr('data-order_status');
	 		var rtwcpiglw_data = {
	 			action 			: 'rtwcpiglw_regnrate_invoice',
	 			order_id 		: order_id,
	 			order_status    : order_status,
	 			rtwcpiglw_security_check	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
	 		};

	 		$.blockUI({ message: '' });
	 		$.ajax({
	 			type: "POST",
	 			url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl,
	 			data: rtwcpiglw_data,
	 			dataType: 'json',
	 			success: function( data ) {
	 				$.unblockUI();
	 				if( data )
	 				{
	 					if (order_status == 'completed') 
	 					{
	 						$('#rtwcpiglw_dlt_nrml').show();
	 						$('#rtwcpiglw_nrml_btn').show();
	 						$('#rtwcpiglw_regnrt_invoice').hide();
	 					}
	 					else
	 					{
	 						$('#rtwcpiglw_dlt_profrma').show();
	 						$('#rtwcpiglw_prfrm_btn').show();
	 						$('#rtwcpiglw_regnrt_invoice').hide();
	 					}
	 				}
	 				else
	 				{
	 					alert( data.rtwcpiglw_message );
	 				}
	 			}
	 		});
	 	});


	 	jQuery(document).on('click', '#rtwcpiglw_regnrt_shipping_lbl', function(){
	 		var order_id = jQuery("#rtwcpiglw_regnrt_shipping_lbl").attr('data-order_id');
	 		var rtwcpiglw_data = {
	 			action 			: 'rtwcpiglw_regnrate_shipping_lbl',
	 			order_id 		: order_id,
	 			rtwcpiglw_security	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
	 		};

	 		$.blockUI({ message: '' });
	 		$.ajax({
	 			type: "POST",
	 			url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl,
	 			data: rtwcpiglw_data,
	 			dataType: 'json',
	 			success: function( data ) {
	 				$.unblockUI();
	 				if( data )
	 				{
	 					$('#rtwcpiglw_shiping_lbl').show();
	 					$('#rtwcpiglw_dlt_shiping_lbl').show();
	 					$('#rtwcpiglw_regnrt_shipping_lbl').hide();
	 				}
	 				else
	 				{
	 					alert( data.rtwcpiglw_message );
	 				}
	 			}
	 		});
	 	});

	 	jQuery(document).on('click', '#rtwcpiglw_regnrt_pckng_slp', function(){
	 		var order_id = jQuery("#rtwcpiglw_regnrt_pckng_slp").attr('data-order_id');
	 		var rtwcpiglw_data = {
	 			action 			: 'rtwcpiglw_regnrate_packng_slp',
	 			order_id 		: order_id,
	 			rtwcpiglw_security	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
	 		};

	 		$.blockUI({ message: '' });
	 		$.ajax({
	 			type: "POST",
	 			url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl,
	 			data: rtwcpiglw_data,
	 			dataType: 'json',
	 			success: function( data ) {
	 				$.unblockUI();
	 				if( data )
	 				{
	 					$('#rtwcpiglw_pckng_slp').show();
	 					$('#rtwcpiglw_dlt_pckng_slp').show();
	 					$('#rtwcpiglw_regnrt_pckng_slp').hide();
	 				}
	 				else
	 				{
	 					alert( data.rtwcpiglw_message );
	 				}
	 			}
	 		});
	 	});

	 	var rules = {
	        rtwcpiglw_purchase_code 	: { required: true }
	    };
	    var messages = {
	        rtwcpiglw_purchase_code 	: { required: 'Required' }
	    };
	    $(document).find( "#rtwcpiglw_verify" ).validate({
	        rules: rules,
	        messages: messages
		});
		$(document).on('click', '#rtwcpiglw_verify_code', function(){
			if( $(document).find( "#rtwcpiglw_verify" ).valid() )
			{
				var rtwcpiglw_purchase_code = $(document).find('.rtwcpiglw_purchase_code').val();

				var data = {	
					action	  		:'rtwcpiglw_verify_purchase_code',
					purchase_code 	: rtwcpiglw_purchase_code,
					security_check 	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
				};
				$.blockUI({ message: '',
				timeout: 20000000 });
				$.ajax({
					url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl, 
					type: "POST",  
					data: data,
					dataType :'json',	
					success: function(response) 
					{  
						if( response.status )
						{
							$(document).find('.rtwcpiglw_notice_success').removeClass('rtwcpiglw_hide');
							$(document).find('.rtwcpiglw_msg_response').addClass('rtwcpiglw_success');
							$(document).find('.rtwcpiglw_msg_response').html(response.message);
							window.setTimeout(function(){ 
								window.location.reload(true);
							}, 3000);
						}
						else{
							$(document).find('.rtwcpiglw_notice_error').removeClass('rtwcpiglw_hide');
							$(document).find('.rtwcpiglw_msg_response').addClass('rtwcpiglw_failed');
							$(document).find('.rtwcpiglw_msg_response').html(response.message);
						}
						$.unblockUI();
					}
				});
			}
		});
		$(document).on('click', '.notice-dismiss', function(){
			var htmls = '';
			htmls = '<div class="notice notice-error is-dismissible"><p><strong class="rtwcpiglw_msg_response"></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"></span></button></div>';

			$(document).find('.rtwcpiglw_notice_error').html(htmls);
			
			$(document).find('.rtwcpiglw_notice_error').addClass('rtwcpiglw_hide');
		});

		jQuery(document).ready(function () {
          setTimeout(function () {
                jQuery('a[href]#rtwcpiglw_prfrm_btn').each(function () {
                    var href = this.href;
                    jQuery(this).removeAttr('href').css('cursor', 'pointer').click(function () {
                        window.open(href, '_self');
                    });
                });
          	}, 500);
    	});

    	jQuery(document).ready(function () {
          setTimeout(function () {
                jQuery('a[href]#rtwcpiglw_nrml_btn').each(function () {
                    var href = this.href;
                    jQuery(this).removeAttr('href').css('cursor', 'pointer').click(function () {
                        window.open(href, '_self');
                    });
                });
          	}, 500);
    	});

		// bulk action 

		$("#doaction, #doaction2").on('click',function(e){
			var rtwcpiglw_action_selected = $(this).attr("id").substr(2);
	        var rtwcpiglw_action = $('select[name="' + rtwcpiglw_action_selected + '"]').val();
			var rtwcpiglw_check_bulk_action = ['bulk_pdf_invoice_hp'] 
			var hony = 'Please select an order to download Invoice.';
			if($.inArray(rtwcpiglw_action,rtwcpiglw_check_bulk_action) !== -1 ) 
	        {
				e.preventDefault();
	        	var rtwcpiglw_order_check = $('tbody th.check-column input[type="checkbox"]:checked');
				if(0 === rtwcpiglw_order_check.length)
	        	{
	        		alert(hony);
	        		return false;
	        	}else
	        	{
					var rtwcpiglw_arr_order_id = new Array();
	        		rtwcpiglw_order_check.each(function(){
	        			rtwcpiglw_arr_order_id.push($(this).val());
	        		});
				}

				var data = {	
					action	  		:'rtwcpiglw_bulk_action_do',
					rtwcpiglw_action : rtwcpiglw_action,
					rtwcpiglw_arr_order_id : rtwcpiglw_arr_order_id,
					security_check 	: rtwcpiglw_ajax_param.rtwcpiglw_nonce	
				};
				$.blockUI({ message: '',
				timeout: 20000000 });
				$.ajax({
					url: rtwcpiglw_ajax_param.rtwcpiglw_ajaxurl, 
					type: "POST",  
					data: data,
					dataType :'json',	
					success: function(response) 
					{  
						if(response.rtwcpiglw_parmalink!=''){
							window.open(response.rtwcpiglw_parmalink)
						}
						if( rtwcpiglw_action == 'bulk_credit_note'||'bulk_delete_invoice' )
						{ 
							window.location.reload(true);
						}
						$.unblockUI();
					}
				});
			}
		});

		// end bulk action

	});

})( jQuery );

	/**
	 *
	 * @since    1.0.0
	 * for show/hide image.
	 */

	 function rtwcpiglw_showHideCheck(rtwcpiglw_id,rtwcpiglw_check) 
	 { 
	 	if (rtwcpiglw_check.checked) 
	 	{ 
	 		jQuery('.rtwcpiglw_text_add_watermark').closest("tr").show();
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_text_add_watermark').closest("tr").hide();
	 	}
	 }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide invoice.
	 */

	 function rtwcpiglw_pckngslp_showHideCheck(rtwcpiglw_id,rtwcpiglw_check) 
	 { 
	 	if (rtwcpiglw_check.checked) 
	 	{ 
	 		jQuery('.rtwcpiglw_pckngslp_text_add_watermark').closest("tr").show();
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_pckngslp_text_add_watermark').closest("tr").hide();
	 	}
	 }

	 function rtwcpiglw_creditnote_showHideCheck(rtwcpiglw_id,rtwcpiglw_check) 
	 { 
	 	if (rtwcpiglw_check.checked) 
	 	{ 
	 		jQuery('.rtwcpiglw_creditnote_text_add_watermark').closest("tr").show();
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_creditnote_text_add_watermark').closest("tr").hide();
	 	}
	 }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide watermak image.
	 */

	 function rtwcpiglw_imgshowHideCheck(rtwcpiglw_id,rtwcpiglw_check)
	 {
	 	if(rtwcpiglw_check.checked)
	 	{
	 		var rtwcpiglw_value = jQuery("#rtwcpiglw_watermark_img_dim").val();
	 		var rtwcpiglw_value1 = jQuery("#rtwcpiglw_watermark_img_pos").val();			
	 		jQuery('.rtwcpiglw_add_watermark_image').closest("tr").show();
	 		jQuery('.rtwcpiglw_doc-add-watermark-image-pos-select').closest("tr").show();
	 		jQuery('#rtwcpiglw_add_watermark_img').show();
	 		if (rtwcpiglw_value == 'array') 
	 		{
	 			jQuery('.rtwcpiglw_add_watermark_image_dimension').closest("tr").show();
	 		}
	 		if (rtwcpiglw_value == 'INT') 
	 		{
	 			jQuery('.rtwcpiglw_add_watermark_image_dimen_integer').closest("tr").show();
	 		}
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_add_watermark_image').closest("tr").hide();
	 		jQuery('.rtwcpiglw_doc-add-watermark-image-pos-select').closest("tr").hide();
	 		jQuery('#rtwcpiglw_add_watermark_img').hide();
	 		jQuery('.rtwcpiglw_add_watermark_image_dimension').closest("tr").hide();
	 		jQuery('.rtwcpiglw_add_watermark_image_dimen_integer').closest("tr").hide();
	 		jQuery('.rtwcpiglw_add_watermark_image_pos').closest("tr").hide();
	 	}
	 }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide packing slip.
	 */

	 function rtwcpiglw_pckngslp_imgshowHideCheck(rtwcpiglw_id,rtwcpiglw_check)
	 {
	 	if(rtwcpiglw_check.checked)
	 	{
	 		var rtwcpiglw_val = jQuery("#rtwcpiglw_pckngslp_watermark_img_dim").val();
	 		var rtwcpiglw_val1 = jQuery("#rtwcpiglw_pckngslp_watermark_img_pos").val();			
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image').closest("tr").show();
	 		jQuery('.rtwcpiglw_pckngslp_doc-add-watermark-image-pos-select').closest("tr").show();
	 		jQuery('#rtwcpiglw_pckngslp_add_watermark_img').show();
	 		if (rtwcpiglw_val == 'array') 
	 		{
	 			jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimension').closest("tr").show();
	 		}
	 		if (rtwcpiglw_val == 'INT') 
	 		{
	 			jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimen_integer').closest("tr").show();
	 		}
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image').closest("tr").hide();
	 		jQuery('.rtwcpiglw_pckngslp_doc-add-watermark-image-pos-select').closest("tr").hide();
	 		jQuery('#rtwcpiglw_pckngslp_add_watermark_img').hide();
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimension').closest("tr").hide();
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimen_integer').closest("tr").hide();
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_pos').closest("tr").hide();
	 	}
	 }

	 function rtwcpiglw_creditnote_imgshowHideCheck(rtwcpiglw_id,rtwcpiglw_check)
	 {
	 	if(rtwcpiglw_check.checked)
	 	{
	 		var rtwcpiglw_val = jQuery("#rtwcpiglw_creditnote_watermark_img_dim").val();
	 		var rtwcpiglw_val1 = jQuery("#rtwcpiglw_creditnote_watermark_img_pos").val();			
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image').closest("tr").show();
	 		jQuery('.rtwcpiglw_creditnote_doc-add-watermark-image-pos-select').closest("tr").show();
	 		jQuery('#rtwcpiglw_creditnote_add_watermark_img').show();
	 		if (rtwcpiglw_val == 'arrays') 
	 		{
	 			jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimension').closest("tr").show();
	 		}
	 		if (rtwcpiglw_val == 'INT') 
	 		{
	 			jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimen_integer').closest("tr").show();
	 		}
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image').closest("tr").hide();
	 		jQuery('.rtwcpiglw_creditnote_doc-add-watermark-image-pos-select').closest("tr").hide();
	 		jQuery('#rtwcpiglw_creditnote_add_watermark_img').hide();
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimension').closest("tr").hide();
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimen_integer').closest("tr").hide();
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_pos').closest("tr").hide();
	 	}
	 }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide watermak image position.
	 */

	 function rtwcpiglw_showHideImage(rtwcpiglw_value)
	 { 
	 	if(rtwcpiglw_value=='array')
	 	{
	 		jQuery('.rtwcpiglw_add_watermark_image_dimension').closest('tr').show();
	 		jQuery('.rtwcpiglw_add_watermark_image_dimen_integer').closest('tr').hide();
	 	}
	 	if(rtwcpiglw_value=='INT')
	 	{
	 		jQuery('.rtwcpiglw_add_watermark_image_dimen_integer').closest('tr').show();
	 		jQuery('.rtwcpiglw_add_watermark_image_dimension').closest('tr').hide();
	 	}
	 	if(rtwcpiglw_value!='INT' && rtwcpiglw_value!='array')
	 	{
	 		jQuery('.rtwcpiglw_add_watermark_image_dimension').closest('tr').hide();
	 		jQuery('.rtwcpiglw_add_watermark_image_dimen_integer').closest('tr').hide();
	 	}
	 }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide packing slip watermark image position.
	 */

	 function rtwcpiglw_pckngslp_showHideImage(rtwcpiglw_v)
	 { 
	 	if(rtwcpiglw_v =='array')
	 	{
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimension').closest('tr').show();
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimen_integer').closest('tr').hide();
	 	}
	 	if(rtwcpiglw_v =='INT')
	 	{
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimen_integer').closest('tr').show();
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimension').closest('tr').hide();
	 	}
	 	if(rtwcpiglw_v !='INT' && rtwcpiglw_v !='array')
	 	{
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimension').closest('tr').hide();
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_dimen_integer').closest('tr').hide();
	 	}
	 }

	 function rtwcpiglw_creditnote_showHideImage(rtwcpiglw_v)
	 { 
	 	if(rtwcpiglw_v =='array')
	 	{
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimension').closest('tr').show();
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimen_integer').closest('tr').hide();
	 	}
	 	if(rtwcpiglw_v =='INT')
	 	{
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimen_integer').closest('tr').show();
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimension').closest('tr').hide();
	 	}
	 	if(rtwcpiglw_v !='INT' && rtwcpiglw_v !='array')
	 	{
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimension').closest('tr').hide();
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_dimen_integer').closest('tr').hide();
	 	}
	 }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide password protection.
	 */

	//  function rtwcpiglw_addPasswordprotctn(rtwcpiglw_id,rtwcpiglw_check){
	 	
	//  	if (rtwcpiglw_check.checked) 
	//  	{
	//  		jQuery("."+rtwcpiglw_id).closest('tr').show();
	//  		jQuery("#admin_pswrd").closest('tr').show();
	 		
	//  	}
	//  	else
	//  	{
	//  		jQuery("."+rtwcpiglw_id).closest('tr').hide();
	//  		jQuery("#admin_pswrd").closest('tr').hide();
	 		
	//  	}
	//  }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide packing slip watermark image position.
	 */


	 function rtwcpiglw_showHidePos() {
	 	var rtwcpiglw_value=jQuery(".rtwcpiglw_doc-add-watermark-image-pos-select").val();
	 	if(rtwcpiglw_value=='arrays')
	 	{
	 		jQuery('.rtwcpiglw_add_watermark_image_pos').closest('tr').show();
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_add_watermark_image_pos').closest('tr').hide();
	 	}
	 }
	 
	  function rtwcpiglw_creditnote_showHidePos() {
	 	var rtwcpiglw_value=jQuery(".rtwcpiglw_creditnote_doc-add-watermark-image-pos-select").val();
	 	if(rtwcpiglw_value=='arrays')
	 	{
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_pos').closest('tr').show();
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_creditnote_add_watermark_image_pos').closest('tr').hide();
	 	}
	 }

	/**
	 *
	 * @since    1.0.0
	 * for show/hide packing slip in table.
	 */

	 function rtwcpiglw_pckngslp_showHidePos() {
	 	var rtwcpiglw_val=jQuery(".rtwcpiglw_pckngslp_doc-add-watermark-image-pos-select").val();
	 	if(rtwcpiglw_val =='arrays')
	 	{
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_pos').closest('tr').show();
	 	}
	 	else
	 	{
	 		jQuery('.rtwcpiglw_pckngslp_add_watermark_image_pos').closest('tr').hide();
	 	}
	 }

	//  / hide offer banner /
	

	jQuery(document).on("click",".rtw_sb_close_popup",function(){
		jQuery(".rtw_sb_popup").fadeOut();
	});

	
		// / hide offer banner /
