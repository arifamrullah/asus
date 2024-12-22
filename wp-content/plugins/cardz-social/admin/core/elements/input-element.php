<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Checkbox element.
 *
 *	@since 3.0.1
 */
class SS_Input_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set attributes.
	 *
	 *	@param $attrs	Attributes to add.
	 */
	public function __construct($attrs = array())
	{
		parent::__construct($attrs);
	}
	
	/**
	 *	Set the input type.
	 *
	 *	@param $type	The type of the input element.
	 */
	public function set_type($type)
	{
		$this->add_attribute('type', $type);
	}
	
	/**
	 *	Set the name of the element.
	 *
	 *	@param $name	The name added to the input element.
	 */
	public function set_name($name)
	{
		$this->add_attribute('name', $name);
	}
	
	/**
	 *	Set the value of the element.
	 *
	 *	@param $value	The value to set.
	 */
	public function set_value($value)
	{
		$this->add_attribute('value', $value);
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		$this->html = '<input';
		
		$this->generate_attributes();

		$this->html .= ' />';
		
		return $this->html;
	}
}