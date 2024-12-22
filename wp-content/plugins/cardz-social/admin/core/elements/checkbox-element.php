<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Checkbox element.
 *
 *	@since 3.0.1
 */
class SS_Checkbox_Element extends SS_Base_Element
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
		
		$bool = array
		(
			'0'			=> false,
			'1'			=> true,
			'false'		=> false,
			'true'		=> true,
			'disable'	=> false,
			'enable'	=> true,
			'disabled'	=> false,
			'enabled'	=> true
		);
		
		$checked = (is_string($this->get_option('value')) && isset($bool[$this->get_option('value')])) ? $bool[$this->get_option('value')] : $this->get_option('value');
        
		$this->add_attribute('type', 'checkbox');
		$this->add_attribute('checked', (($checked) ? 'checked' : ''));
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		$label_pos = $this->get_option('label_pos');
		
		$label = '<label for="' . $this->get_attribute('id') . '">' . $this->get_option('label') . '</label>';
		
		if ($label_pos === 'before')
		{
			$this->html = $label;
		}
		
		$this->html = '<input';
	
		$this->generate_attributes();
		
		$this->html .= ' />';
		
		if ($label_pos !== 'before')
		{
			$this->html .= $label;
		}
		
		return $this->html;
	}
}