<?php
/*
Plugin Name: Contently
Description: This plugin integrates with Contently
Version: 1.0.2
Author: Contently
Author URI: http://www.contently.com
License: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

define('CONTENTLY_DIR_PATH', plugin_dir_path(__FILE__));
define('CONTENTLY_URL_PATH', plugins_url('', __FILE__).'/');
define('CONTENTLY_API_URL', 'https://api.contently.com/v1/');

$plugin_slug = basename(dirname(__FILE__));

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = PucFactory::buildUpdateChecker(
    'http://integrations.contently.com/wordpress/release.json',
    __FILE__
);

/*require CONTENTLY_DIR_PATH.'includes/plugin-updates/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker(
    'http://test.sportwithoutlimits.com/metadata.json',
    __FILE__,
    'contently'
);*/

function cl_activate()
{
		update_option('contently_apiKey',	'');
		update_option('ct_p_type',		'post');
		update_option('ct_p_taxonomy',	'category');
		update_option('ct_p_tags',		'post_tag');

	$story_publishing_settings['is_planned']	 = 0;
    $story_publishing_settings['is_not_planned'] = 1;
    $story_publishing_settings['save_as_draft']  = 1;

	update_option('publishing_settings', $story_publishing_settings);
}
register_activation_hook( __FILE__, 'cl_activate' );

include('functions.php');
//Registering Admin Menus
function contently_admin_menu()
{
	add_menu_page('Contently Settings', 'Contently Settings', 'activate_plugins', 'contently_setting', 'contently_setting');

	$apiKey	= get_option('contently_apiKey');
	if(!empty($apiKey)) {
	add_submenu_page("contently_setting", "Fields Mapping", "Fields Mapping", 'activate_plugins', "fields_mapping", "fields_mapping");
	}
}
add_action('admin_menu', 'contently_admin_menu');

function pushurl_tocontently($post_ID)  {

	$post_id = $post_ID->ID;
	$published_url = get_permalink($post_id);
	$data_string = 'published_to_url='.$published_url;
	$story_id = get_post_meta($post_id,'ct_story_id', true);
	$sent_url = CONTENTLY_API_URL.'/stories/'.$story_id.'/mark_published';
	make_curlrequest($sent_url,'PUT', $data_string);

}

//add_action('draft_to_publish','pushurl_tocontently');

add_action('new_to_publish', 'pushurl_tocontently', 10, 1);
add_action('future_to_publish', 'pushurl_tocontently', 10, 1);
add_action('draft_to_publish', 'pushurl_tocontently', 10, 1);
add_action('publish_post', 'pushurl_tocontently', 10, 1);


/////////////////////////

function fields_mapping(){
	global $wpdb;

	/*echo "<br><br><br>";
	$gmtOffset=get_option('gmt_offset');
	echo $date2 = date('Y-m-d H:i:s', $_GET['ttt'] + $gmtOffset*60*60);

	echo "<br><br><br>";

	$my_unix_timestamp = $_GET['ttt'];
	echo $post_publish_date	= get_date_from_gmt( date( 'Y-m-d H:i:s', $my_unix_timestamp ), 'Y-m-d H:i:s' );

	date_default_timezone_set('America/New_York');*/

	/*//date_default_timezone_set(get_option('timezone_string'));
	$date_format = get_option( 'date_format' );
    $time_format = get_option( 'time_format' );
    //echo date( "{$date_format} {$time_format}", current_time( 'timestamp' ) );
	echo date_i18n( get_option( 'date_format' ), 1441749600 );
	echo "<br>";
	echo date('Y-m-d H:i:s',1441749600);
	echo "<br>";
	echo date( 'Y-m-d H:i:s', current_time( 1441749600 ) );*/

	//$mapping_array		= get_option('mapping_array_acf'); /// FIELDS MAPPING ARRAY
	//echo "<pre>"; print_r($mapping_array);
	/*
	echo $title_field		= get_mapped_value($mapping_array['title'],'title');
	echo $featured_img_field = get_mapped_value($mapping_array['featured_img'], 'featured_img');*/

	//// get attributes on pageload
	$url = CONTENTLY_API_URL.'/taxonomy';
	$data ='';
	$get_author_attributes = make_curlrequest($url,'GET', $data);
	update_option('contently_author_attributes', $get_author_attributes);
	error_reporting(0);
	$contently_author_attributes = get_option("contently_author_attributes");
	$get_act_plg_vn = get_activated_plugin_torf($opt_id='',1);

	if(isset($_POST['save_mappings']))
	{
		update_option('mapping_array', ($_POST['contently_mapping_fields']));
		update_option('mapping_array_acf', ($_POST['contently_mapping_fields_acf']));

		update_option('ct_p_type',		($_POST['ct_p_type']));
		update_option('ct_p_taxonomy',	($_POST['ct_p_taxonomy']));
		update_option('ct_p_tags',		($_POST['ct_p_tags']));
		update_option('acffieldgroup',	($_POST['acffieldgroup']));

		echo '<div class="updated below-h2" id="message"><p>Updated Successfully.</p></div>';
		echo '<script type="text/javascript">window.location="?page=fields_mapping"</script>';
	}
?>
<script type="text/javascript">
jQuery(document).ready(function($) {

	jQuery('.chooseposttype').change(function(e) {

	var data = {
		'action': 'get_post_taxonomy',
		'post_type': jQuery(this).val()
	};

	 jQuery('#loader_div').show();
	 jQuery.ajax({
			url: '<?php echo admin_url() ?>/admin-ajax.php',
			type: 'POST',
			data: data,
			success:function(data) {
			//	alert(data);
			if(data==''){
				//jQuery('#loader_div').hide();
				}else{

				jQuery('.hide_it').show();
				jQuery('.embedoptionshere').html(data);
			  }
			  jQuery('#loader_div').hide();

			},
			error: function(errorThrown){
				console.log(errorThrown);
			}
		});

    });

});
</script>
<link rel="stylesheet" href="<?php echo CONTENTLY_URL_PATH ?>/css/style.css" type="text/css"/>
<div class="wrap">
	<h2>Contently Fields Mapping</h2>
</div>

<form action="" method="post">
<div class="postbox">
		<h3 class="hndle container_box" style="">
			<span style="">Post Type Mapping </span>
        </h3>
        <div class="inside">
         Map all Contently story types to one specific Wordpress Post Type
         <br /><br />
         <span style="width:175px; float:left;">Post Type: </span> <select name="ct_p_type" class="chooseposttype">
         	<option value="">Select Post Type</option>
            <?php

			$ct_p_type		= get_option('ct_p_type');
			$ct_p_taxonomy	= get_option('ct_p_taxonomy');
			$ct_p_tags		= get_option('ct_p_tags');

			$post_types = get_post_types();
			$exlude_posttypes = array('attachment','revision','nav_menu_item','acf');
			foreach($post_types as $key=>$all_post_type)
			{
				if(!in_array($key, $exlude_posttypes)) {
				if($ct_p_type==$key) {
					$selected = 'selected="selected"';
				}else { $selected = ''; }
			?>
            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
            <?php
				}
			}
			?>
         </select><img src="<?php echo admin_url() ?>/images/wpspin_light-2x.gif" style="width: 2%; padding-left: 5px; display:none;" id="loader_div">
		 <div style="clear:both;">&nbsp;</div>
         <div class="hide_it" <?php if(empty($ct_p_taxonomy)) { ?>style="display:none;" <?php } ?>><span style="width:175px; float:left;">Post Taxonomy:</span>
         <select class="embedoptionshere" name="ct_p_taxonomy">
         <?php

	$taxonomy_objects = get_object_taxonomies( $ct_p_type, 'objects' );
	if(!empty($taxonomy_objects))
	{
		foreach($taxonomy_objects as $key=>$taxonomy_object)
		{
			if(trim($taxonomy_object->labels->name)!='Format') {
			?>
			<option value="<?php echo $key; ?>" <?php if($ct_p_taxonomy==$key) { echo 'selected="selected"'; } ?> ><?php echo $taxonomy_object->labels->name ?></option>
			<?php
			}
		}
	}
		 ?>
         </select> </div> <div style="clear:both;">&nbsp;</div>
         <div class="hide_it" <?php if(empty($ct_p_taxonomy)) { ?>style="display:none;" <?php } ?>><span style="width:175px; float:left;">Post Tags:</span>
         <select class="embedoptionshere" name="ct_p_tags">
         <?php
         $taxonomy_objects = get_object_taxonomies( $ct_p_type, 'objects' );
		if(!empty($taxonomy_objects))
		{
			foreach($taxonomy_objects as $key=>$taxonomy_object)
			{
				if(trim($taxonomy_object->labels->name)!='Format') {
				?>
					<option value="<?php echo $key; ?>" <?php if($ct_p_tags==$key) { echo 'selected="selected"'; } ?> ><?php echo $taxonomy_object->labels->name ?></option>
				<?php
				}
			}
		}
		 ?>
         </select> </div><div style="clear:both;">&nbsp;</div>
         <?php
        if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ||  is_plugin_active( 'advanced-custom-fields/acf.php' )  )
		{
		?>
         <div>
         	<span style="width:175px; float:left;">Select ACF Field Group:</span> 		<select name="acffieldgroup">
            <option value="">select</option>
            <?php
			$selected_acffield = get_option("acffieldgroup");

			if($get_act_plg_vn=='paid')
			{
				$post_type_acf = 'acf-field-group';
			}
			else if($get_act_plg_vn=='free')
			{
				$post_type_acf = 'acf';
			}

			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => $post_type_acf,
				'post_status'      => 'publish'
			);

			$posts_array = get_posts( $args );
			foreach($posts_array as $post_array)
			{

				?>
				<option value="<?php echo $post_array->ID; ?>" <?php if($selected_acffield==$post_array->ID) { echo 'selected="selected"'; } ?> ><?php echo $post_array->post_title; ?></option>
				<?php
			}
			?>
            </select>
         </div>
         <?php } ?>
        </div>
</div>

<div class="postbox">
		<h3 class="hndle container_box" style="">
			<span style="">Contently Fields Mapping</span>
        </h3>
        <div class="inside">

                	<table>
                    		<tr>
                            	<td width="165">Title:</td>
                                <td> <?php get_dropdown_list('title', $contently_author_attributes); ?> </td>
                            </tr>
                            <tr>
                            	<td>Body:</td>
                                 <td> <?php get_dropdown_list('body', $contently_author_attributes); ?> </td>
                            </tr>
                            <tr>
                            	<td>Categories:</td>
                                 <td> <?php get_dropdown_list('category', $contently_author_attributes); ?> </td>
                            </tr>

                            <tr>
                            	<td>Tags:</td>
                                 <td> <?php get_dropdown_list('ptags', $contently_author_attributes); ?> </td>
                            </tr>

                            <tr>
                            	<td>Author:</td>
                                 <td> <?php get_dropdown_list('author', $contently_author_attributes); ?> </td>
                            </tr>

                            <tr>
                            	<td>Post Excerpt:</td>
                                 <td> <?php get_dropdown_list('excerpt', $contently_author_attributes); ?> </td>
                            </tr>

                            <tr>
                            	<td>Featured Image:</td>
                                 <td> <?php get_dropdown_list('featured_img', $contently_author_attributes); ?> </td>
                            </tr>

                    </table>
         <?php
         if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ||  is_plugin_active( 'advanced-custom-fields/acf.php' )  ) {
		 ?>
        <div style="clear:both; height:20px;"></div>
        <h3 class="hndle container_box" style="">
			<span style=""><strong>Advance Custom Fields Plugin Fields</strong></span>
        </h3>

               <table>
				<?php

				//$fields = acf_get_fields( 59 );
				//echo "<pre>"; print_r($fields);
				$selected_acffield	= get_option("acffieldgroup");

				if(!empty($selected_acffield))
				{
					$fields		= get_activated_plugin_torf($selected_acffield,2);
					if(!empty($fields)) {
					foreach($fields as $field)
                {

					if($field['type']!='image') {
                ?>
                <tr>
                    <td width="165"><?php echo $field['label']; ?>:</td>
                    <td><?php get_dropdown_list_acf($field['name'], $contently_author_attributes); ?></td>
                </tr>
                <?php } } } else { echo "<tr><td colspan='2'>No Fields Found.</td></tr>"; } } ?>
                </table>

        <?php } ?>
        <div style="clear:both; height:20px;"></div>
        <h3 class="hndle container_box" style="">
			<span style=""><strong>SEO Yoast Plugin Fields</strong></span>
        </h3>

               <table>

                <tr>
                    <td width="165">Focus Keyword:</td>
                    <td><?php get_dropdown_list_acf('_yoast_wpseo_focuskw', $contently_author_attributes); ?></td>
                </tr>

                <tr>
                    <td>SEO Title:</td>
                    <td><?php get_dropdown_list_acf('_yoast_wpseo_title', $contently_author_attributes); ?></td>
                </tr>

                <tr>
                    <td>Meta description:</td>
                    <td><?php get_dropdown_list_acf('_yoast_wpseo_metadesc', $contently_author_attributes); ?></td>
                </tr>


                </table>


                <table> <tr><td><br /><input type="submit" value="Update" name="save_mappings" class="button button-primary button-large"/></td></tr></table>
        	</div>
        </div></form>
<?php
}

//// settings page function
function contently_setting(){

	/*$content = get_option('cl_data');

	$mapping_array			= get_option('mapping_array'); /// FIELDS MAPPING ARRAY
	echo $category_field	= get_mapped_value_cat($mapping_array['category'], 'category');
	echo "<br>";echo "<br>";
	echo $ptags_field = get_mapped_value_cat($mapping_array['ptags'], 'ptags');

	echo "<br>";echo "<br>";echo "<br>";echo "<br>";
	echo "<pre>"; print_r($content);
	//echo assign_category($category_field, $post_id, $ct_p_taxonomy);
	exit;
	//global $wpdb;*/
	global $wpdb;
	error_reporting(0);
?>
<link rel="stylesheet" href="<?php echo CONTENTLY_URL_PATH ?>/css/style.css" type="text/css"/>

<div class="wrap">
<h2>Contently Settings</h2>
</div>

<?php
		///saving key into DB
		if(isset($_POST['save_key']))
		{
			//// update api key and get attributes
			update_option('contently_apiKey', ($_POST['api_key'])); // saving key

			$url = CONTENTLY_API_URL.'/taxonomy';
			$data ='';
			$get_author_attributes = make_curlrequest($url,'GET', $data);
			update_option('contently_author_attributes', $get_author_attributes);

			//// update webhook url

			$encoded_hash = base64_encode($_POST['api_key']);
			$webhook_url  = home_url('/?contently_push='.$encoded_hash);

			$data_string	= 'webhook_url='.$webhook_url;
			$sent_url		= CONTENTLY_API_URL.'/set_webhook';
			make_curlrequest($sent_url,'PUT', $data_string);


			echo '<div class="updated below-h2" id="message"><p>Updated Successfully.</p></div>';
			echo '<script type="text/javascript">window.location="?page=contently_setting"</script>';
		}

		///saving key into DB

		if(isset($_POST['save_publishoptions']))
		{
			//echo "<pre>"; print_r($_POST);
			update_option('publishing_settings', ($_POST['publishing_settings'])); // saving key
			echo '<div class="updated below-h2" id="message"><p>Updated Successfully.</p></div>';
			echo '<script type="text/javascript">window.location="?page=contently_setting"</script>';
		}

		$apiKey				 = get_option('contently_apiKey');
		$publishing_settings = get_option('publishing_settings');

		//echo "<pre>"; print_r($publishing_settings);

		$is_planned 	= $publishing_settings['is_planned'];
		$is_not_planned = $publishing_settings['is_not_planned'];
		$save_as_draft	= $publishing_settings['save_as_draft'];
?>

<div class="postbox">
		<h3 class="hndle container_box" style="">
			<span style="">Contently API Key</span>
        </h3>
        <div class="inside">
				<form action="" method="post">
                	<table>
                    		<tr><td>API Key</td><td><input value="<?php echo $apiKey; ?>" type="text" name="api_key" style="width: 300px;" /></td></tr>
                            <tr><td><br /><input type="submit" value="Update" name="save_key" class="button button-primary button-large"/></td></tr>
                    </table>
                </form>
        	</div>
        </div>
<?php
if(!empty($apiKey))
{
$encoded_hash = base64_encode($apiKey);
?>

<div class="postbox">
		<h3 class="hndle container_box">
			<span style="">Contently Webhook URL</span>
        </h3>
          <div class="inside">

          	<a target="_blank" href="<?php echo home_url('/?contently_push='.$encoded_hash) ?>"><?php echo home_url('/?contently_push='.$encoded_hash) ?></a>

            	<!--<a target="_blank" href="< ?php echo home_url('/contently_push/push?token='.$encoded_hash) ?>">< ?php echo home_url('/contently/push?token=='.$encoded_hash) ?></a>-->

          </div>
      </div>


      <div class="postbox">
		<h3 class="hndle container_box">
			<span style="">Publishing options</span>
        </h3>
          <div class="inside">
          <form action="" method="post">
            <div style="height:30px;">Set how a story is published between Contently and Wordpress.</div>
            <div class="">
            <label for=""><strong>When a planned publish date is set</strong> </label>
             <!--
            	1 => scheduled it
                0 => draft
            -->
            <div>
            <div class="">
            <input type="radio" <?php if($is_planned==1) { ?> checked="checked"<?php } ?> value="1" name="publishing_settings[is_planned]">
            <label for="">Publish story on the planned publish date/time - it can be edited or rescheduled before it's published. </label>
            </div>
            <div class="">
            <input type="radio" class="form-radio" <?php if($is_planned==0) { ?> checked="checked"<?php } ?>  value="0" name="publishing_settings[is_planned]">
            <label>Ignore publish date and save story as a draft - will be manually published. </label>
            </div>
            </div>
            </div>

            <div style="clear:both; height:20px;"><br /></div>

            <div>
            <!--
            	1 => save story as draft
                0 => publish it
            -->
	<div>
    	 <label><strong>When a planned publish date is not set</strong> </label></div>
         <input type="radio" class="form-radio" <?php if($is_not_planned==1) { ?> checked="checked"<?php } ?> value="1" name="publishing_settings[is_not_planned]">
         <label>Save story as a draft - will be manually published. </label>
    </div>

    <div>
         <input type="radio" class="form-radio" <?php if($is_not_planned==0) { ?> checked="checked"<?php } ?>  value="0" name="publishing_settings[is_not_planned]">
         <label>Publish to live site immediately once the story is approved on Contently.</label>
    </div>


     <div style="clear:both; height:20px;"><br /></div>


     <div>
 <label><strong>When revisions are made to an existing story </strong></label><br />
 <input type="radio" class="form-radio" <?php if($save_as_draft==1) { ?> checked="checked"<?php } ?> value="1" name="publishing_settings[save_as_draft]">
 <label>Revisions are saved as a draft and need to be manually republished.</label>
</div>

<div>
 <input type="radio" class="form-radio" <?php if($save_as_draft==0) { ?> checked="checked"<?php } ?>  value="0" name="publishing_settings[save_as_draft]">
 <label>Save and republish the revisions automatically. </label>
</div>

    <div style="margin-top:20px;">
    		<input type="submit" value="Update" name="save_publishoptions" class="button button-primary button-large"/>
    </div>

            </form>

          </div>
      </div>

<?php	}
}

function get_contently_webhook_response() {
    //// HOOK TO GET AND SAVE DATA
	global $wpdb;

	$apiKey			= get_option('contently_apiKey');
	$encoded_hash	= base64_encode($apiKey);
	//$encoded_hash   ='true';
	//exit;
	if(isset($_GET['contently_push']) && $_GET['contently_push']==$encoded_hash)
	{
		$contently_story = json_decode(file_get_contents('php://input'));

		if(!empty($contently_story))
		{
			update_option('cl_data',$contently_story);

			$ct_p_type			 = get_option('ct_p_type');
			$publishing_settings = get_option('publishing_settings');
			$is_planned 	= $publishing_settings['is_planned'];
			$is_not_planned = $publishing_settings['is_not_planned'];
			$save_as_draft	= $publishing_settings['save_as_draft'];

			if(empty($ct_p_type))
			{
				$ct_p_type='post';
			}

			$story_title 	= $contently_story->title;
			$story_content	= $contently_story->content;

			$story_id		= $contently_story->id;
			$publish_at		= $contently_story->publish_at;

			$post_status='';
			if(!empty($publish_at))
			{
				if($is_planned==1)
				{
					$post_status		= 'future';
					//$my_unix_timestamp = $publish_at;
					$post_publish_date	= get_date_from_gmt( date( 'Y-m-d H:i:s', $publish_at ), 'Y-m-d H:i:s' );
					//$post_publish_date	= date('Y-m-d H:i:s', $publish_at);
				}
				else if($is_planned==0)
				{
					$post_status = 'draft';
				}
			}
			else
			{
				if($is_not_planned==1)
				{
					$post_status		= 'draft';
				}
				else if($is_not_planned==0)
				{
					$post_status		= 'publish';
				}
			}

			$mapping_array	= get_option('mapping_array'); /// FIELDS MAPPING ARRAY

			$ct_p_type		= get_option('ct_p_type');
			if(empty($ct_p_type))
			{
				$ct_p_type='post';
			}

			$mapping_array		= get_option('mapping_array'); /// FIELDS MAPPING ARRAY
			$title_field		= get_mapped_value($mapping_array['title'],'title');
			$body_field			= get_mapped_value($mapping_array['body'], 'body');
			$category_field		= get_mapped_value_cat($mapping_array['category'], 'category');
			$author_field		= get_mapped_value($mapping_array['author'], 'author');
			$featured_img_field = get_mapped_value($mapping_array['featured_img'], 'featured_img');
			$post_xcerpt = get_mapped_value($mapping_array['excerpt'], 'excerpt');

			$ptags_field = get_mapped_value_cat($mapping_array['ptags'], 'ptags');

			$author_field_br = explode('@@', $author_field);
			$author_id = check_existing_user($author_field);
			$story_content = find_replace_externalurls($body_field);
			//$author_id = 1;

			$story_external_link = "<div style='padding-bottom: 10px;'><a target='_blank' href='https://contently.com/stories/".$story_id."'>https://contently.com/stories/".$story_id."</a></div>";

			$chkexisting = $wpdb->get_row("SELECT * FROM wp_postmeta WHERE meta_key = 'ct_story_id' AND meta_value = ".$story_id." ");

			$existing_postid = $chkexisting->post_id;
			if(!empty($existing_postid))
			{

				if($save_as_draft==1)
				{
					$post_status = 'draft';
				}
				else
				{
					$post_status = 'publish';
				}

				$my_post = array(
				  'ID'            => $existing_postid,
				  'post_title'    => $title_field,
				  'post_content'  => $story_content,
				  'post_status'   => $post_status,
				  'post_author'   => $author_id ,
				  'post_type'     => $ct_p_type,
				  'post_excerpt'  => $post_xcerpt
				);

				wp_update_post( $my_post );

				$post_id = $existing_postid;

			}
			else
			{

				$my_post = array(
				  'post_title'    => $title_field,
				  'post_content'  => $story_content,
				  'post_status'   => $post_status,
				  'post_author'   => $author_id ,
				  'post_type'     => $ct_p_type,
				  'post_excerpt'  => $post_xcerpt
				);

				if($post_status == 'future')
				{

					//$my_unix_timestamp = $post_publish_date;
					$post_publish_date = get_date_from_gmt( date( 'Y-m-d H:i:s', $publish_at ), 'Y-m-d H:i:s' );


					$my_post['post_date']	  = $post_publish_date;
					$my_post['post_date_gmt'] = $post_publish_date;
				}
			update_option('ttttt', $my_post);
				//// saving the content / author as a post
				$post_id = wp_insert_post($my_post);
			}

			update_post_meta($post_id,'storycontently_data', $contently_story);
			update_post_meta($post_id,'ct_story_id', $story_id);

			///// getting and updating the ACF Mapped field
			$contently_mapping_fields_acf = get_option("mapping_array_acf");
			foreach($contently_mapping_fields_acf as $key=>$contently_mapping_fields_acf1)
			{

			$field_value = get_mapped_value($contently_mapping_fields_acf1,$contently_mapping_fields_acf1);
			update_post_meta($post_id,$key, $field_value);

			}

			$cur_date		= date("Y-m-d");
			$planned_date	= date('Y-m-d',$publish_at);

			if($planned_date < $cur_date )
			{
				if($is_planned==0)
				{
					$post_status = 'draft';

					$my_post = array(
					  'ID'            => $post_id,
					  'post_status'   => $post_status,
					);

				}
				else
				{
					$post_status = 'publish';

					$my_post = array(
					  'ID'            => $post_id,
					  'post_status'   => $post_status,
					);

				}

				wp_update_post( $my_post );
			}


			if($post_status=='publish')
			{
				$published_url	= get_permalink($post_id);
				$data_string	= 'published_to_url='.$published_url;
				$story_id		= get_post_meta($post_id,'ct_story_id', true);
				$sent_url		= CONTENTLY_API_URL.'stories/'.$story_id.'/mark_published';
				make_curlrequest($sent_url,'PUT', $data_string);

			}

			//// Setting the featured image
			if(!empty($featured_img_field))
			{
				$wp_upload_dir = wp_upload_dir();
				$matches_urls_single = strtok($featured_img_field, '?');
				$url_old 		= $matches_urls_single;
				$url_old_br 	= explode("/",$url_old);
				$filename 		= end($url_old_br);
				$uploadfile_img = $wp_upload_dir['path'] . '/' .$filename;
				$attachment_id 	= get_image_byurl($url_old, $uploadfile_img);
				set_post_thumbnail( $post_id, $attachment_id );
			}

			$ct_p_taxonomy	= get_option("ct_p_taxonomy");
			$ct_p_tags		= get_option('ct_p_tags');

			echo assign_category($category_field, $post_id, $ct_p_taxonomy);
			echo assign_category($ptags_field, $post_id, $ct_p_tags);

		}
		exit;
	}

}
add_action( 'wp_head', 'get_contently_webhook_response' );
////// ajax script
add_action( 'wp_ajax_get_post_taxonomy', 'get_post_taxonomy' );

function get_post_taxonomy() {
	//print_r($_REQUEST);
	$post_type = $_POST['post_type'];
	$taxonomy_objects = get_object_taxonomies( $post_type, 'objects' );
	if(!empty($taxonomy_objects))
	{
		foreach($taxonomy_objects as $key=>$taxonomy_object)
		{
			if(trim($taxonomy_object->labels->name)!='Format')
			{
			?>
			<option value="<?php echo $key; ?>"><?php echo $taxonomy_object->labels->name ?></option>
			<?php
			}
		}
	}
	else
	{
		echo '<option value="">select</option>';
	}

	die();
}
