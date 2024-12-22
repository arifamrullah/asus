<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Description element.
 *
 *	@since 3.0.1
 */
class SS_Description_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set options.
	 */
	public function __construct($options = array())
	{
		parent::__construct(array(), $options);
	}
	
	/**
	 *	Set the value of the element.
	 *
	 *	@param $value	The value to set.
	 */
	public function set_value($value)
	{
		$this->set_option('value', $value);
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		$this->html = '<br /><span class="description" style="display: block; margin: 10px 0px 10px;">' . ((isset($this->options['value'])) ? $this->options['value'] : '') . '</span>';
		
		return $this->html;
	}
}