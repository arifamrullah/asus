<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Select element.
 *
 *	@since 3.0.1
 */
class SS_Select_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set options and attributes.
	 *
	 *	@param $attrs	Optional. Element attributes.
	 *	@param $options	Optional. Element options.
	 */
	public function __construct($attrs = array(), $options = array())
	{
		parent::__construct($attrs, $options);
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		$this->html = '<select';
		
		$this->generate_attributes();
		$this->html .= '>';
		
		$choices = $this->get_option('choices');
		
		foreach ($choices as $key => $label)
		{
			$this->html .= '<option value="' . esc_attr($key) . '"' . selected($this->get_option('value'), $key, false) . '>' . $label . '</option>';
		}
		
		$this->html .= '</select>';
		
		return $this->html;
	}
}