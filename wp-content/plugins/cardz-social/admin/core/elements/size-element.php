<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Size element.
 *
 *	@since 3.0.1
 */
class SS_Size_Element extends SS_Base_Element
{
	private $all_units = array('px', 'em', '%', 'rem', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'ch', 'vh', 'vw', 'vmin', 'vmax', 'vm');
	private $mode = 'css';
	private $units = array
	(
		'css'	=> array('px', 'em', '%', 'rem'),
		'time'	=> array('ms', 'sec', 'min', 'h')
	);

	/**
	 *	Constructor. Set attributes.
	 *
	 *	@param $attrs	Attributes to add.
	 */
	public function __construct($attrs = array())
	{
		parent::__construct($attrs);
		
		$this->add_attribute('type', 'ss-size');
		
		$this->mode = (isset($attrs['mode'])) ? $attrs['mode'] : 'css';
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
		$value = $this->get_attribute('value');
		$unit = ($this->mode == 'css') ? 'px' : 'ms';
		$regex_units = implode('|', $this->units[$this->mode]);
		
		if (preg_match('/([0-9]*)('. $regex_units .')$/', $value, $match))
		{
			$value = isset($match[1]) ? $match[1] : intval($value);
			$unit = isset($match[2]) ? $match[2] : $unit;
		}
		else
		{
			$value = intval($value);
		}
	
		$this->html = <<<HTML
			<div{$this->generate_attributes(true)}>
				<input class="ss-size-input" type="text" value="{$value}" />
				<span class="ss-size-unit">$unit</span>
				{$this->get_available_units()}
				<input type="hidden" class="ss-size-value" name="{$this->get_attribute('name')}" value="{$value}{$unit}" />
			</div>
HTML;
		
		return $this->html;
	}
	
	/**
	 *	Generate the HTML list for the available units.
	 *
	 *	@return The generated HTML.
	 */
	private function get_available_units()
	{
		$units = $this->units[$this->mode];
	
		$html = '<ul class="ss-size-units">';
		
		foreach ($units as $value)
		{
			$html .= '<li>' . $value . '</li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}
}