<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Manage plug-in data.
 */
class SS_Data
{
    /**
	 *	Instance of this class.
     *
     *  @var SS_Data
	 */
	protected static $instance = null;
    
    /**
	 *	Get instance of this class.
	 *
	 *	@return SS_Data instance.
	 */
	public static function get_instance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
    
    /**
     *  Get options as a JSON string.
     *
     *  @param bool $return_json [optional] Wether to return a JSON string, or an object.
     *
     *  @return string|object Returns the data as JSON string or as an object.
     */
    public function get_options($return_json = true)
    {
        global $wpdb, $post;
    
        /**
         *  Fires before prepareing the options data.
         *
         *  It can be used to modify the post option before the options are set.
         *
         *  @since 1.0.12
         *
         *  @param WP_Post $post Post object.
         */
        do_action('cardz_before_get_options', $post);
        
        $options = array
        (
            /* Networks & data*/
            //'networks'              => array(),
            'feedData'              => array(),
            
            /* Design */
            'skin'                  => $this->get_option('ss-skin', 'default'),
            'skinFilters'           => $this->get_option('ss-skin-filters', 'default'),
            'skinLightbox'          => $this->get_option('ss-skin-lightbox', 'default'),
            'effect'                => $this->get_option('ss-transition', 'fade'),
            'grid'                  => array
            (
                'cols'                  => $this->get_option('ss-cols', 8),
                'width'                 => $this->get_option('ss-item-width', 280),
                'gutter'                => intval($this->get_option('ss-gutter', 10)),
            ),
            'toolbar'               => $this->get_option('ss-filters', true),
            'lightbox'              => $this->get_option('ss-lightbox', true),
            'share'                 => $this->get_option('ss-share', 'window'),
            'pagination'            => array
            (
                'itemsPerPage'          => $this->get_option('ss-items-per-page', 10),
                'type'                  => $this->get_option('ss-pagination-type', 'button')
            ),
            'limitTextType'         => $this->get_option('ss-text-limit-type', 'words'),
            'limitText'             => $this->get_option('ss-text-limit', '200'),
            
            'orderBy'               => $this->get_option('ss-order-by', 'auto'),
            'order'                 => $this->get_option('ss-order', 'asc'),
            
            'hideIfNoImage'            => $this->get_option('ss-hideifnoimage', false),
            
            'itemShadow'            => $this->get_option('ss-items-shadow', true),
            'responsive'            => $this->get_option('ss-responsive', true),
            'clickableLinks'        => $this->get_option('ss-clickable-links', true),
            'disable'               => $this->get_option('ss-disable', false),
            'disableForSmallScreen' => $this->get_option('ss-disable-for-small-screen', false),
            'moderate'              => $this->get_option('ss-moderate', '')
        );
        
        $networks = json_decode($this->get_option('ss-networks', ''), true);
        
        $api_keys = array
        (
            'google'    => get_option('ss-gp-api-key', ''),
            'instagram' => get_option('ss-is-access-token', ''),
            'youtube'   => get_option('ss-yb-api-key', '')
        );
        
        global $ss_file_cache;
        
        //$cache_data = new SS_File_Cache();
        $cache_data = $ss_file_cache;
        
        if ($cache_data->is_time_to_update('feedData_' . $post->ID) || true)
        {
            if (!empty($networks) && is_array($networks))
            {
                $social_objects = array
                (
                    'dribbble'      => 'SS_Social_Dribbble',
                    'facebook'      => 'SS_Social_Facebook',
                    'flickr'        => 'SS_Social_Flickr',
                    'foursquare'    => 'SS_Social_Foursquare',
                    'google'        => 'SS_Social_Google',
                    'instagram'     => 'SS_Social_Instagram',
                    'pinterest'     => 'SS_Social_Pinterest',
                    'rss'           => 'SS_Social_RSS',
                    'soundcloud'    => 'SS_Social_SoundCloud',
                    'tumblr'        => 'SS_Social_Tumblr',
                    'twitter'       => 'SS_Social_Twitter',
                    'vimeo'         => 'SS_Social_Vimeo',
                    'vine'          => 'SS_Social_Vine',
                    'vk'            => 'SS_Social_VK',
                    'youtube'       => 'SS_Social_YouTube'
                );
            
                foreach ($networks as $network)
                {
                    $social_object = new $social_objects[$network['type']]();
                    $options['feedData'] = array_merge($options['feedData'], $social_object->request($network['value'], $this->get_option('ss-items-limit', 30)));
                    
                
                    /*if ($network['type'] === 'facebook')
                    {
                        $social_object = new SS_Social_Facebook();
                        $options['feedData'] = array_merge($options['feedData'], $social_object->request($network['value']));
                        //$options['feedData'] += $social_object->request($network['value']);
                    }
                    else if ($network['type'] === 'twitter')
                    {
                        $social_object = new SS_Social_Twitter();
                        $options['feedData'] = array_merge($options['feedData'], $social_object->request($network['value']));
                        //$options['feedData'] += $social_object->request($network['value']);
                    }
                    else if ($network['type'] === 'rss')
                    {
                        $social_object = new SS_Social_RSS();
                        $options['feedData'] = array_merge($options['feedData'], $social_object->request($network['value']));
                    }
                    else if ($network['type'] === 'youtube')
                    {
                        $social_object = new SS_Social_YouTube();
                        $options['feedData'] = array_merge($options['feedData'], $social_object->request($network['value']));
                    }
                    else if ($network['type'] === 'instagram')
                    {
                        $social_object = new SS_Social_Instagram();
                        $options['feedData'] = array_merge($options['feedData'], $social_object->request($network['value']));
                    }
                    else
                    {
                        $options['networks'][$network['type']] = array
                        (
                            'id'        => (!empty($network['value']['network-id'])) ? $network['value']['network-id'] : '',
                            'api_key'   => $api_keys[$network['type']]
                        );
                        
                        if (isset($network['value']['feed-type']))
                        {
                            $options['networks'][$network['type']]['type'] = $network['value']['feed-type'];
                        }
                    }*/
                }
            }
        
            /*
             *  Get all custom feeds for this stream.
             */
            $options['feedData'] = array_merge($options['feedData'], $wpdb->get_results("SELECT * FROM {$wpdb->ss_feeds} WHERE id_post = {$post->ID}"));
            
            $cache_data['feedData_' . $post->ID] = $options['feedData'];
        }
        else
        {
            $options['feedData'] = $cache_data['feedData_' . $post->ID];
        }
        
        /**
         *  Filters the options array before returing and after it has been set.
         *
         *  @since 1.0.12
         *
         *  @param array $options The options array.
         */
        $options = apply_filters('cardz_filter_get_options', $options);
        
        return ($return_json) ? json_encode($options) : $options;
    }
    
    /**
     *  Get an option from the current post.
     *
     *  @param string $property The property name.
     *  @param string $default The default value.
     *
     *  @return mixed Returns the value of the specific property or the default value.
     */
    public function get_option($property, $default)
    {
        global $post;
        
        $value = get_post_meta($post->ID, $property, true);
        $value = ($value == null || $value == '') ? $default : $value;
        
        return (gettype($default) === 'boolean') ? (($value == '1') ? true : false) : $value; 
    }
}

/**
 *	Returns the instance of SS_Data.
 *
 *	@return SS_Data
 */
function SS_Data()
{
	return SS_Data::get_instance();
}

?>