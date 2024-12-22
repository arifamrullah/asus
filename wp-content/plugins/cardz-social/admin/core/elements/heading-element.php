<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Heading element.
 *
 *	@since 3.0.1
 */
class SS_Heading_Element extends SS_Base_Element
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
		
		// Set the default heading.
		if (!isset($options['type']))
		{
			$options['type'] = 'h1';
		}
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		/*
		 *	Format the HTML using the following structure:
		 *	<h1 class="class-name">Value</h1>
		 */
		$this->html = "<{$this->get_option('type')}{$this->generate_attributes()}>{$this->get_option('value')}<{$this->get_option('type')}>";
		
		return $this->html;
	}
}