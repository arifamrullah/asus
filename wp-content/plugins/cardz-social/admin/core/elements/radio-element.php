<?php
/*
 *	Speedo WordPress Framework v1.5
 *
 *	Speedo WordPress Framework is a collection of helper classes for plugins development.
 *
 *	http://www.agapastudio.com/
 *
 *	Copyright (C) 2013-2014 By Agapa Studio.All rights reserved.
 */

/*
 *	RadioElement() - Radio element.
 */
class RadioElement extends BaseElement
{
	public function __construct($attrs = array(), $options = array())
	{
		parent::__construct($attrs, $options);
		
		$this->add_attribute('type', 'radio');
	}
	
	/*
	 *	generate() - Generate the HTML.
	 */
	public function generate()
	{
		/*$this->html_data = '<select';
		
		$i = 0;
		
		$this->generate_attributes();
		$this->html_data .= '>';
		
		$choices = $this->get_option('choices');
		
		foreach ($choices as $key => $label)
		{
			$element = new InputElement($this->attrs);
			echo '<input class="radio' . $fieldClass . '" type="radio" name="' . $field . '" id="' . $field . '" value="' . esc_attr($key) . '" ' . checked($value, $key, false) . '> <label for="' . $field . '">' . $label . '</label>';
					
			if ($i < count($choices) - 1)
			{
				echo '<br />';
			}
					
			$i++;
			
			$this->html_data .= '<option value="' . esc_attr($key) . '"' . selected(get_option('value'), $key, false) . '>' . $label . '</option>';
		}
		
		$this->html_data .= '</select>';
		
		return $this->html_data;*/
	}
}
?>