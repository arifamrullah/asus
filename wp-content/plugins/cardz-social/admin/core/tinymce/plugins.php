<?php
/*
 *	Register tinymce plugins.
 */
function speedo_social_stream_register_plugins()
{
	if (current_user_can('edit_posts') && current_user_can('edit_pages'))  
	{  
		add_filter('mce_external_plugins', 'speedo_social_stream_add_plugins');  
		add_filter('mce_buttons_3', 'speedo_social_stream_register_buttons');  
	}  
}

function speedo_social_stream_register_buttons($buttons)
{  
	array_push($buttons, 'speedo_social_stream');
	
	return $buttons;  
}  

function speedo_social_stream_add_plugins($plugin_array)
{  
	$plugin_array['speedo_social_stream'] = SS_PURL.'/admin/core/tinymce/codes.js';
	
	return $plugin_array;  
}

add_action('init', 'speedo_social_stream_register_plugins');
?>