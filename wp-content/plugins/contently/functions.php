<?php
function make_curlrequest($url, $requestType, $data){

	$apiKey = get_option('contently_apiKey');
	$ch = curl_init($url);
	
	if($requestType=='PUT')
	{
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER , TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'User-Agent: v1', 'Contently-Api-Key:'.$apiKey, 'Content-Length: '.strlen($data).'  ')
		);
		curl_getinfo($ch, CURLINFO_HTTP_CODE);
	}
	else
	{
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(      
			'Content-Type: Content-Type', 'Contently-Api-Key:'.$apiKey)
		);
	}
	
	$result = curl_exec($ch);
	$result = json_decode($result);
	return $result;
}

function get_activated_plugin_torf($opt_id,$rvalue){
	
	 if ( is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) 
	 {
		 $plugin_version = 'paid';
		 $fields = acf_get_fields( $opt_id );
	 }
	 elseif ( is_plugin_active( 'advanced-custom-fields/acf.php' ) ) 
	 {
		 $plugin_version = 'free';		 
		 $fields = apply_filters('acf/field_group/get_fields', array(), $opt_id); 
	 }
	 if($rvalue==1)
	 {
	 	return $plugin_version;
	 }
	 else
	 {
		return $fields;
	 }
}

function assign_category($term_c, $post_id, $ct_p_taxonomy)
{
	$brt = explode(',', $term_c);
	
	foreach($brt as $brt1)
	{
		if(!empty($brt1))
		{
			$check_term = term_exists( $brt1, $ct_p_taxonomy );
			if($check_term)
			{
				$term_id = $check_term['term_id'];
			}
			else
			{
				$insert_id	= wp_insert_term( $brt1, $ct_p_taxonomy);
				$term_id	= $insert_id['term_id'];
			}
			
			
			$assign_it[] = intval($term_id);
		}
	}
	
	$taxonomy = $ct_p_taxonomy;

	wp_set_post_terms( $post_id, $assign_it, $taxonomy );
}

function check_existing_user($data){
		
		$data = explode('@@', $data);
		$fName = $data[0];
		$lName = $data[1];
		$email = $data[2];
		
		$chkUser = get_user_by( 'email', $email );
		if(!empty($chkUser))
		{
			$user_id = $chkUser->ID;
		}
		else
		{
			
			$userdata = array(
			'user_login'  =>  $fName.$lName,
			'first_name'  => $fName,
			'last_name'   =>  $lName,
			'user_pass'   =>  'contently_'.$fName,  
			'user_email'  => $email,
			);
			$user_id = wp_insert_user( $userdata ) ;
		}
		
		return $user_id ;
	}
function get_mapped_value($variable, $fieldmap){
		//echo $variable;
		$content = get_option('cl_data');
		$value='';
		//$content->title;
		$variable_break = explode('_', $variable);
		if($variable_break[0]=='cm')
		{
			if($variable_break[1]=='creator')
			{
				$first_name = $content->creator->first_name;
				$last_name	= $content->creator->last_name;
				$email		= $content->creator->email;
				
				$value = $first_name.'@@'.$last_name.'@@'.$email;
			}
			else if($variable_break[1]=='contributors')
			{
				/// gettting the first contrubutor only
				$first_name = $content->contributors[0]->first_name;
				$last_name	= $content->contributors[0]->last_name;
				$email		= $content->contributors[0]->email;
				
				$value = $first_name.'@@'.$last_name.'@@'.$email;
			}
			else
			{
				$value = $content->$variable_break[1];
			}
			
		}
		else if($variable_break[0]=='sf')
		{
			foreach($content->story_fields as $stfields)
			{
				if($stfields->name==$variable_break[1])
				{
					if($fieldmap=='featured_img')
					{
						$value = $stfields->asset_url;
					}
					else
					{
						$value = $stfields->content;
					}
				}
			}
		}
		else if($variable_break[0]=='attr')
		{
			$i=0;
			foreach($content->story_attributes as $attrfields)
			{
				if($attrfields->name==$variable_break[1])
					{
						$value = $attrfields->values[0]->name;
					}
				/*if($variable_break[1]=='Tags' || $variable_break[1]=='Category')
				{
					
					$value = $attrfields->values[0]->name.",".$attrfields->values[1]->name.",".$attrfields->values[2]->name.",".$attrfields->values[3]->name; 
				}
				else
				{
					if($attrfields->name==$variable_break[1])
					{
						$value = $attrfields->values[0]->name;
					}
				}*/
			
			$i++;
			
			}
		}
		
		return $value;
}

function get_mapped_value_cat($variable, $fieldmap){
		//echo $variable;
		$content = get_option('cl_data');
		$value='';
		//$content->title;
		$variable_break = explode('_', $variable);
		if($variable_break[0]=='cm')
		{
			if($variable_break[1]=='creator')
			{
				$first_name = $content->creator->first_name;
				$last_name	= $content->creator->last_name;
				$email		= $content->creator->email;
				
				$value = $first_name.'@@'.$last_name.'@@'.$email;
			}
			else if($variable_break[1]=='contributors')
			{
				/// gettting the first contrubutor only
				$first_name = $content->contributors[0]->first_name;
				$last_name	= $content->contributors[0]->last_name;
				$email		= $content->contributors[0]->email;
				
				$value = $first_name.'@@'.$last_name.'@@'.$email;
			}
			else
			{
				$value = $content->$variable_break[1];
			}
			
		}
		else if($variable_break[0]=='sf')
		{
			foreach($content->story_fields as $stfields)
			{
				if($stfields->name==$variable_break[1])
				{
					if($fieldmap=='featured_img')
					{
						$value = $stfields->asset_url;
					}
					else
					{
						$value = $stfields->content;
					}
				}
			}
		}
		else if($variable_break[0]=='attr')
		{
			$i=0;
			foreach($content->story_attributes as $attrfields)
			{
				if($attrfields->name==$variable_break[1])
					{
						//$value = $attrfields->values[0]->name;
						foreach($attrfields->values as $tt)
						{
							$value.= $tt->name.",";
						}
						//$value = implode(",",$attrfields->values);
					}
				/*if($variable_break[1]=='Tags' || $variable_break[1]=='Category')
				{
					
					$value = $attrfields->values[0]->name.",".$attrfields->values[1]->name.",".$attrfields->values[2]->name.",".$attrfields->values[3]->name; 
				}
				else
				{
					if($attrfields->name==$variable_break[1])
					{
						$value = $attrfields->values[0]->name;
					}
				}*/
			
			$i++;
			
			}
		}
		
		return $value;
}

function get_dropdown_list($fieldname, $contently_author_attributes){
	$contently_story_fields = $contently_author_attributes->publication_story_fields;
	$contently_story_attributes = $contently_author_attributes->publication_story_attributes;
	
	//$result = array_merge($contently_story_fields, $contently_story_attributes);
	
	$mapping_array = get_option('mapping_array');
	
	$array_constants = array('title'=>'Title', 'content'=>'Content', 'creator'=>'Creator', 'contributors'=>'Contributors');
	
	$selected_value = $mapping_array[$fieldname];
	$selected='';
?>
<select class="form-select" name="contently_mapping_fields[<?php echo $fieldname; ?>]" >
  		  <option value="">select</option>
          <?php
                foreach($array_constants as $key=>$array_constantss){
					
				if($selected_value=="cm_".$key) { 
					$selected = 'selected="selected"';
				}else { $selected = ''; }
            ?>
          <option value="<?php echo "cm_".$key; ?>" <?php echo $selected; ?>><?php echo $array_constantss; ?></option>
          <?php } 
		  echo '<optgroup label="Story Fields">';
                foreach($contently_story_fields as $story_fields){
					
				if($selected_value=='sf_'.$story_fields->name) { 
					$selected = 'selected="selected"';
				}else { $selected = ''; }
            ?>
            <option value="<?php echo 'sf_'.$story_fields->name; ?>" <?php echo $selected; ?>><?php echo $story_fields->name; ?></option>
            <?php }
			
			echo ' </optgroup>
			<optgroup label="Attributes">';
		  
                foreach($contently_story_attributes as $attributes_values){
				
				if($selected_value=='attr_'.$attributes_values->name) { 
					$selected = 'selected="selected"';
				}else { $selected = ''; }
			?>
                <option value="<?php echo 'attr_'.$attributes_values->name; ?>" <?php echo $selected; ?>><?php echo $attributes_values->name; ?></option>
                <?php } ?>
          </optgroup>
  </select>
<?php	
}

function get_dropdown_list_acf($fieldname, $contently_author_attributes){
	//echo $fieldname;
	$contently_story_fields = $contently_author_attributes->publication_story_fields;
	$contently_story_attributes = $contently_author_attributes->publication_story_attributes;
	
	//$result = array_merge($contently_story_fields, $contently_story_attributes);
	$mapping_array = get_option('mapping_array_acf');
	
	$array_constants = array('title'=>'Title', 'content'=>'Content', 'creator'=>'Creator', 'contributors'=>'Contributors');
	if(!empty($mapping_array))
	{
		$selected_value = $mapping_array[$fieldname];
	}
	$selected='';
?>
<select class="form-select" name="contently_mapping_fields_acf[<?php echo $fieldname; ?>]">
  		  <option value="">select</option>
          <?php
                foreach($array_constants as $key=>$array_constantss){
				if($selected_value=="cm_".$key) { 
					$selected = 'selected="selected"';
				}else { $selected = ''; }
            ?>
          <option value="<?php echo "cm_".$key; ?>" <?php echo $selected; ?>><?php echo $array_constantss; ?></option>
          <?php }
		  echo '<optgroup label="Story Fields">';
                foreach($contently_story_fields as $story_fields){
				if($selected_value=='sf_'.$story_fields->name) { 
					$selected = 'selected="selected"';
				}else { $selected = ''; }
            ?>

<option value="<?php echo 'sf_'.$story_fields->name; ?>" <?php echo $selected; ?>><?php echo $story_fields->name; ?></option>
            <?php }

			echo ' </optgroup>
			<optgroup label="Attributes">';
                foreach($contently_story_attributes as $attributes_values){
				if($selected_value=='attr_'.$attributes_values->name) { 
					$selected = 'selected="selected"';
				}else { $selected = ''; }
			?>
                <option value="<?php echo 'attr_'.$attributes_values->name; ?>" <?php echo $selected; ?>><?php echo $attributes_values->name; ?></option>
                <?php } ?>
          </optgroup>
  </select>
<?php	
}

function get_image_byurl($inPath,$outPath)
{
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$imagename = explode("/",$inPath);
		$filename =  end($imagename);

		$in = fopen($inPath, "rb");
		$out = fopen($outPath, "wb");

		while($chunk = fread($in,8192))
		{
			fwrite($out, $chunk, 8192);
		}

		fclose($in);
		fclose($out);
		
		$wp_filetype = wp_check_filetype(basename($outPath), null );
		
		$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => $filename,
		'post_content' => '',
		'post_status' => 'inherit'
		);
		
		$attach_id = wp_insert_attachment( $attachment, $uploadfile );
		$imagenew = get_post( $attach_id );
		$fullsizepath = get_attached_file( $imagenew->ID );
		
		$attach_data = wp_generate_attachment_metadata( $attach_id, $outPath );
		
		$attach_data['file'];
		update_post_meta($attach_id,'_wp_attached_file', $attach_data['file']);
		wp_update_attachment_metadata( $attach_id, $attach_data );
		
		return $attach_id;
		
	}	

function find_replace_externalurls($content)
{
		$content = str_replace('https','http',$content);
		preg_match_all('/<img[^>]+>/i',$content, $imgTags);	
		foreach($imgTags[0] as $imgTags1)
		{
			preg_match('/src="([^"]+)/i',$imgTags1, $imgage);
			$matches_urls[] = str_ireplace( 'src="', '',  $imgage[0]);
		}
		
		$wp_upload_dir = wp_upload_dir();
		//$matches_urls = $matches[1];
	
		if(!empty($matches_urls)){
			foreach($matches_urls as $matches_urls_single)
			{
				$matches_urls_single = strtok($matches_urls_single, '?');
				$url_old 		= $matches_urls_single;
				$url_old_br 	= explode("/",$url_old);
				$filename 		= end($url_old_br);
				$uploadfile_img = $wp_upload_dir['path'] . '/' .$filename;
				$attachment_id 	= get_image_byurl($url_old, $uploadfile_img);
				$grabbed_img_wpurl	= wp_get_attachment_url( $attachment_id ); 
				$con_new 		= str_replace($url_old, $grabbed_img_wpurl, $content);
				$content 		= $con_new;
			}
		}
		else
		{
				$content = $content;
		}
		
		return $content;
	}