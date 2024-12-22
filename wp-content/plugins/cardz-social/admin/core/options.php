<?php if (!defined('ABSPATH')) { exit; }

/**
 *	CardZ Social Stream admin options.
 */
class SS_Admin_Options
{
	/**
	 *	Array of input fields.
	 */
	protected $fields = array();
	
	/**
	 *	Initialize the fields array.
	 *
	 *	@param $fields	An array of input fields.
	 */
	public function set_fields_array($fields)
	{
		if (is_array($fields) && !empty($fields))
		{
			$this->fields = $fields;
		}
	}
	
	/**
	 *	Returns the HTML string of a field using the given properties.
	 *
	 *	@param $value	The value to be set to the element.
	 *	@param $field	Optional. Field key name.
	 *
	 *	@return The HTML string of a field.
	 */
	public function get_field($value, $field = '')
	{
		// Extract the array into variables.
		extract($this->fields[$field]);
		
		if ($value == null || $value == '')
		{
			$value = $default;
		}
        
        $id = (isset($id)) ? $id : $field;
        $name = (isset($name)) ? $name : $field;
		
		$field_class = '';
		
		if (isset($class) && $class != '')
		{
			$field_class = ' ' . $class;
		}
		
		$element = null;
		$returned_html = '';
		
		if (isset($title) && !isset($label) && $type !== 'checkbox')
		{
			$returned_html = '<label>' . $title .'</label>';
		}
		
		switch ($type)
		{
			case 'heading':
				$element = new SS_Heading_Element(array
				(
					'class' => $field_class
				),
				array
				(
					'value' => $value
				));
				break;
			
			case 'checkbox':
				$element = new SS_Checkbox_Element(array(
					'id'		=> $id,
					'class'		=> $field_class,
					'name'		=> $name
				), array('value' => $value, 'label' => $label));
				break;
			
			case 'select':
				$element = new SS_Select_Element(array(
					'id'		=> $id,
					'name'		=> $name,
					'class'		=> $field_class
				), array(
					'choices'	=> $choices,
					'value'		=> $value
				));
				break;
				
			case 'align':
				$element = new SS_Align_Element(array
				(
					'name'	        => $name,
					'value'	        => $value,
                    'horizontal'    => (!empty($horizontal)) ? $horizontal : false
				));
				break;
				
			case 'filters':
				$element = new SS_Filters_Element(array
				(
					'title'		=> $title,
					'name'		=> $name,
					'value'		=> $value
				));
				break;
                
            case 'rect':
                $element = new SS_Rect_Element(array
                (
                    'title'     => $title,
                    'name'      => $name,
                    'value'     => $value
                ));
                break;
                
            case 'networks':
                $element = new SS_Networks_Element(array
                (
                    'title'     => $title,
                    'name'      => $name,
                    'value'     => $value,
                    'networks'  => $networks
                ));
                break;
                
            case 'color':
                $element = new SS_Color_Element(array
                (
                    'title'     => $title,
                    'name'      => $name,
                    'value'     => $value
                ));
                break;
				
			case 'size':
				$attrs = array
				(
					'id'		=> $id,
					'class'		=> $field_class,
					'name'		=> $name,
					'value'		=> esc_attr($value)
				);
				
				(isset($mode)) ? $attrs['mode'] = $mode : '';
				//(isset($mode)) ? $attrs['mode'] = $mode : '';
				
				$element = new SS_Size_Element($attrs);
				break;
			
			case 'text':
			case 'number':
			case 'password':
				$element = new SS_Input_Element(array(
					'id'			=> $id,
					'class'			=> $field_class,
					'type'			=> $type,
					'name'			=> $name,
					'placeholder'	=> $default,
					'value'			=> esc_attr($value)
				));
				break;
			
			case 'button':
			case 'hidden':
			default:
				$element = new SS_Input_Element(array(
					'id'			=> $id,
					'class'			=> $field_class,
					'type'			=> $type,
					'name'			=> $name,
					'placeholder'	=> $default,
					'value'			=> esc_attr($value)
				));
				break;
			
			case 'textarea':
				$element = new SS_Textarea_Element(array(
					'id'			=> $id,
					'class'			=> $field_class,
					'name'			=> $name,
					'placeholder'	=> $default,
					'rows'			=> 5,
					'cols'			=> 30
				));
				
				$element->set_value(wp_htmledit_pre($value));
				break;
			
			case 'upload':
				$element = new SS_Upload_Element(array(
					'id'			=> $id,
					'class'			=> $field_class,
					'name'			=> $name,
					'placeholder'	=> $default,
					'value'			=> $value,
				));
				break;
				
			case 'custom':
				$returned_html = $html;
				break;
		}
		
		if ($element != null)
		{
			$returned_html .= $element->generate();
		}
		
		if (!empty($desc))
		{
			$description = new SS_Description_Element(array('value' => $desc));
					
			$returned_html .= $description->generate();
		}
		
		return $returned_html;
	}
	
	/**
	 *	Render a HTML field using the given properties.
	 *
	 *	@param $value	The value to set to the element.
	 *	@param $field	Optional. Field key name.
	 */
	public function display_field($value, $field = '')
	{	
		echo $this->get_field($value, $field);
	}
	
	/**
	 *	Render the box content.
	 *
	 *	@param $post		The $post obect to which this is attached.
	 *	@param $meta_box	Meta box.
	 */
	public function display($post, $meta_box)
	{
		global $post;
		
		$side_meta = (isset($meta_box['args']['context']) && $meta_box['args']['context'] == 'side');
		
		?>
			<table <?php echo ($side_meta) ? 'class="side-meta"' : ''; ?>>
			<?php
				foreach ($this->fields as $key => $field)
				{	
					if (!$side_meta)
					{
					?>
						<tr>
							<td valign="top" style="padding-right: 10px"><?php echo $field['title']; ?></td>
							<td><?php $this->display_field($post, $key); ?></td>
						</tr>
					<?php
					}
					else
					{
					?>
						<tr>
							<td valign="top" style="padding-right: 10px"><?php echo $field['title']; ?></td>
						</tr>
						<tr>
							<td><?php $this->display_field($post, $key); ?></td>
						</tr>
					<?php
					}
				}
			?>
			</table>
		<?php
	}
	
	/**
	 *	Save page data.
	 *
	 *	@param $post_id	The post ID.
	 */
	public function save_data($post_id)
	{
		if (!current_user_can('edit_page', $post_id))
		{
			return $post_id;
		}
		
		foreach ($this->fields as $key => $field)
		{
			$old = get_post_meta($post_id, $key, true);
			$new = (isset($_POST[$key])) ? $_POST[$key] : ((isset($field['default'])) ? $field['default'] : '');
			
			if ($new != $old)
			{
				update_post_meta($post_id, $key, $new);
			}
			else if ($new == '')
			{
				delete_post_meta($post_id, $key, $old);
			}
		}
	}
}