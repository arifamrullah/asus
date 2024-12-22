<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Manage options.
 */
class SS_Options
{
	/**
	 *	Get a specific option.
	 */
    public function get_option($option, $page = 'speedo_social_stream_options')
    {   
        $options = get_option($page);	
        
        if (isset($options[$option]))
        {
            return $options[$option];
        }

        return '';//$options;
    }
	
	/**
	 *	Get option from a specific post.
	 *
	 *	@param $post_id		Post ID.
	 *	@param $key			Key name.
	 *	@param $default		Default value.
	 *
	 *	@return The value of the option on success, the default value on failure.
	 */
	public function get_post_option($post_id, $key, $default)
	{
		$value = get_post_meta($post_id, $key, true);
		$value = (!empty($value)) ? $value : $this->get_option($key);
		$value = ($value == 'true') ? true : (($value == 'false') ? false : $value);
		
		return (!empty($value)) ? $value : $default;
	}
    
	/**
	 *	Get option from a specific page.
	 *
	 *	@param int $page_id		Page ID.
	 *	@param string $key		Option key.
	 *	@param mixed $default	Default value.
	 *
	 *	@return Returns the value of the option on success, the default vale on failure.
	 */
    public function get_page_option($page_id, $key, $default)
    {
        return $this->get_post_option($page_id, $key, $default);
    }
	
	/**
	 *	Get time value.
	 *
	 *	@param $key		Option key.
	 *	@param $default	Default value.
	 *
	 *	@return Returns the time value in milliseconds.
	 */
	public function get_time_option($post_id, $key, $default)
	{
		$value = $this->get_post_option($post_id, $key, $default);
		
		if (is_bool($value) || $value == 0)
		{
			return false;
		}
		
		if (preg_match('/([0-9]*)(ms|sec|min|h)$/', $value, $match))
		{
			$value = isset($match[1]) ? $match[1] : intval($value);
			$unit = isset($match[2]) ? $match[2] : $unit;
			
			if ($value == 0)
			{
				return false;
			}
			
			switch ($unit)
			{
			case 'sec':
				$value = $value * 1000;		// Convert from seconds to milliseconds.
				break;
				
			case 'min':
				$value = $value * 60000;	// Convert from minutes to milliseconds.
				break;
			
			case 'h':
				$value = $value * 3600;		// Convert from hours to milliseconds.
				break;
			
			case 'ms':
			default:
				return $value;
			}
		}
		
		return $value;
	}
}