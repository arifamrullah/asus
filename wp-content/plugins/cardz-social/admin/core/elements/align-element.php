<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Align element.
 *
 *	@since 3.0.1
 */
class SS_Align_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set options.
	 *
	 *	@param $options	Optional. Element options.
	 */
	public function __construct($options = array())
	{
		parent::__construct(array(), $options);
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
		$value = $this->get_option('value');
		$value = (!empty($value)) ? $value : 'center';
		$name = $this->get_option('name');
		$selected_class = ' selected';
        
        $horizontal = $this->get_option('horizontal');
	
		$this->html = '<div id="'. $name .'" class="ss-align-element">';
        if (!$horizontal)
        {
		    $this->html .= '	<a href="#" class="ss-align-top-left ss-button'. (($value == 'top-left') ? $selected_class : '') .'" data-align-value="top-left"></a>';
		    $this->html .= '	<a href="#" class="ss-align-top ss-button'. (($value == 'top') ? $selected_class : '') .'" data-align-value="top"></a>';
		    $this->html .= '	<a href="#" class="ss-align-top-right ss-button'. (($value == 'top-right') ? $selected_class : '') .'" data-align-value="top-right"></a>';
        }
        
		$this->html .= '	<a href="#" class="ss-align-left ss-button'. (($value == 'left') ? $selected_class : '') .'" data-align-value="left"></a>';
		$this->html .= '	<a href="#" class="ss-align-center ss-button'. (($value == 'center') ? $selected_class : '') .'" data-align-value="center"></a>';
		$this->html .= '	<a href="#" class="ss-align-right ss-button'. (($value == 'right') ? $selected_class : '') .'" data-align-value="right"></a>';
        
        if (!$horizontal)
        {
		    $this->html .= '	<a href="#" class="ss-align-bottom-left ss-button'. (($value == 'bottom-left') ? $selected_class : '') .'" data-align-value="bottom-left"></a>';
		    $this->html .= '	<a href="#" class="ss-align-bottom ss-button'. (($value == 'bottom') ? $selected_class : '') .'" data-align-value="bottom"></a>';
		    $this->html .= '	<a href="#" class="ss-align-bottom-right ss-button'. (($value == 'bottom-right') ? $selected_class : '') .'" data-align-value="bottom-right"></a>';
        }
        
		$this->html .= '	<input type="hidden" name="'. $name .'" class="ss-align-value" value="'. $value .'" />';
		$this->html .= '</div>';
		
		return $this->html;
	}
	
}