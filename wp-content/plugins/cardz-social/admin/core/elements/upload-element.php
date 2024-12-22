<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Upload element.
 *
 *	@since 3.0.1
 */
class SS_Upload_Element extends SS_Base_Element
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
		$placeholder = $this->get_option('placeholder');
		$value = esc_attr($this->get_option('value'));
		$name = $this->get_option('name');
		$classes = $this->get_option('classes');
		
		$this->html = <<<HTML
			<div class="sp-upload">
				<input type="text" class="sp-upload-input" id="$name" name="$name" placeholder="$placeholder" value="$value" />
				<a href="#" class="sp-upload-button">Upload</a>
			</div>
HTML;
		
		return $this->html;
	}
	
}