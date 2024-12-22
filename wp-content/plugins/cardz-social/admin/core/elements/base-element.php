<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Base element.
 *
 *	@since 3.0.1
 */
class SS_Base_Element
{
	/**
	 *	HTML code.
	 */
	protected $html = '';
	
	/**
	 *	Element attributes.
	 */
	protected $attrs = array();
	
	/**
	 *	Element options.
	 */
	protected $options = array();
	
	/**
	 *	Constructor. Set attributes and options.
	 *
	 *	@param $attrs	Optional. Element attributes.
	 *	@param $options	Optional. Element options.
	 */
	public function __construct($attrs = array(), $options = array())
	{
		$this->attrs = $attrs;
		$this->options = $options;
		
		// Create CSS class from the called class name.
		$class = str_replace('_', '-', get_called_class());
		$class = str_replace('-Element', '', $class);
		$class = strtolower($class);
		
		$this->attrs['class'] = (isset($this->attrs['class'])) ? $class . ' ' . $this->attrs['class'] : $class;
	}
	
	/**
	 *	Add one or more attribute(s) to the element.
	 *
	 *	@param $attrs	An array with element attributes.
	 *
	 *	@return True on success, false on failure.
	 */
	public function add_attributes($attrs)
	{
		if (isset($attrs))
		{
			foreach ($attrs as $name => $value)
			{
				$this->attrs[$name] = $value;
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 *	Add one attrbute to the element.
	 *
	 *	@param $name	Attribute name.
	 *	@param $value	Attribute value.
	 *
	 *	@return True on success, false on failure.
	 */
	public function add_attribute($name, $value)
	{
		if (isset($name) && isset($value))
		{
			$this->attrs[$name] = $value;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 *	Add one or more option(s) to the element.
	 *
	 *	@param $options	An array of options.
	 *
	 *	@return True on success, false on failure.
	 */
	public function add_options($options)
	{
		if (isset($options))
		{
			foreach ($options as $name => $value)
			{
				$this->options[$name] = $value;
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 *	Add one option to the element.
	 *
	 *	@param $name	Option name.
	 *	@param $value	Option value.
	 *
	 *	@return True on success, false on failure.
	 */
	public function add_option($name, $value)
	{
		if (isset($name) && isset($value))
		{
			$this->options[$name] = $value;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 *	Set element ID.
	 *
	 *	@param $id	The id to set.
	 *
	 *	@return True on success, false on failure.
	 */
	public function set_id($id)
	{
		return $this->add_attribute('id', $id);
	}
	
	/**
	 *	Set element classes.
	 *
	 *	The classes should be separated by a space. All previous classes will be replaced.
	 *
	 *	@param $classes	Classes to set to the element.
	 *
	 *	@return True on success, false on failure.
	 */
	public function set_classes($classes)
	{
		return $this->add_attribute('class', $classes);
	}
	
	/**
	 *	Get attribute by name.
	 *
	 *	@param $name	Attribute name.
	 *
	 *	@return The attribute value or an empty string.
	 */
	public function get_attribute($name)
	{
		return (isset($this->attrs[$name])) ? $this->attrs[$name] : '';
	}
	
	/**
	 *	Get option value by name.
	 *
	 *	@param $name	Option name.
	 *
	 *	@return The option value or an empty string.
	 */
	public function get_option($name)
	{
		return (isset($this->options[$name])) ? $this->options[$name] : '';
	}
	
	/**
	 *	Generate attributes and add them to the HTML.
	 *
	 *	@param $return [Optional] Wether to return the attributes text or add it to the $html variable. Default false.
	 */
	public function generate_attributes($return = false)
	{
		$attrs_str = '';
		
		foreach ($this->attrs as $name => $value)
		{
			if (!empty($value))
			{
				$attrs_str .= " $name=\"$value\"";
			}
		}
		
		if (!$return)
		{
			$this->html .= $attrs_str;
		}
		else
		{
			return $attrs_str;
		}
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		return $this->html;
	}
	
	/**
	 *	Get the generated HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function get_html()
	{
		return $this->html;
	}
}