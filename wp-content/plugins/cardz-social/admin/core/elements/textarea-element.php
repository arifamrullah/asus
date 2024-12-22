<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Textarea element.
 *
 *	@since 3.0.1
 */
class SS_Textarea_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set options.
	 *
	 *	@param $options	Optional. Element options.
	 */
	public function __construct($attrs = array())
	{
		parent::__construct($attrs);
	}
	
	/**
	 *	Set value.
	 *
	 *	@param $value	The value to set.
	 */
	public function set_value($value)
	{
		$this->add_option('value', $value);
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		$this->html = '<textarea';
		
		$this->generate_attributes();

		$this->html .= '>' . ((isset($this->options['value'])) ? $this->options['value'] : '') . '</textarea>';
		
		return $this->html;
	}
	
}