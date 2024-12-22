<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Color picker element.
 */
class SS_Color_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set attributes.
	 *
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
    
        $this->html = <<<HTML
            <div class="ss-color-element" id="{$name}">
                <input type="text" name="{$name}" class="ss-color-input" value="{$value}" style="border-color: {$value}" />
                <span class="ss-color-slot" style="background-color: {$value}"></span>
                <div class="ss-color-picker" tabindex="1" style="display: none;">
                    <div class="ss-color-picker-slot" style="background-color: {$value}"></div>
                    <div class="ss-color-picker-hex">
                        <input type="text" class="ss-color-picker-hex-input" maxlength="6" size="6" value="{$value}" />
                    </div>
                    <div class="ss-color-picker-colorlayer" style="background-color: {$value}">
                        <div class="ss-color-picker-colorlayer-overlay">
                            <div class="ss-color-picker-colorlayer-select"></div>
                        </div>
                    </div>
                    <div class="ss-color-picker-hue">
                        <div class="ss-color-picker-hue-select"></div>
                    </div>
                    <input type="button" class="ss-color-picker-button" value="Apply" />
                </div>
            </div>
HTML;
		
		return $this->html;
	}
}