<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Rect element. This can be used for margins, paddings, borders etc.
 */
class SS_Rect_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set options and attributes.
	 *
	 *	@param $attrs	Optional. Element attributes.
	 *	@param $options	Optional. Element options.
	 */
	public function __construct($options = array())
	{
		parent::__construct(array(), $options);
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
        $name = $this->get_option('name');
        $value = $this->get_option('value');
        $values = explode(' ', $value);
        
        $top = $values[0];
        $right = $values[1];
        $bottom = $values[2];
        $left = $values[3];
        
        $top_el = new SS_Size_Element(array
        (
            'id'    => $name . '-top',
            'name'  => $name . '-top',
            'value' => $top
        ));
        $right_el = new SS_Size_Element(array
        (
            'id'    => $name . '-right',
            'name'  => $name . '-right',
            'value' => $right
        ));
        $bottom_el = new SS_Size_Element(array
        (
            'id'    => $name . '-bottom',
            'name'  => $name . '-bottom',
            'value' => $bottom
        ));
        $left_el = new SS_Size_Element(array
        (
            'id'    => $name . '-left',
            'name'  => $name . '-left',
            'value' => $left
        ));
        
        $this->html = <<<HTML
            <div class="ss-rect-element" id="{$name}">
                <div class="ss-rect-top">
                    <label for="{$name}-top">top</label>
                    {$top_el->generate()}
                </div>
                <div class="ss-rect-right">
                    <label for="{$name}-right">right</label>
                    {$right_el->generate()}
                </div>
                <div class="ss-rect-bottom">
                    <label for="{$name}-bottom">bottom</label>
                    {$bottom_el->generate()}
                </div>
                <div class="ss-rect-left">
                    <label for="{$name}-left">left</label>
                    {$left_el->generate()}
                </div>
                <input type="hidden" name="{$name}" value="{$value}"  />
            </div>
HTML;

		return $this->html;
	}
}