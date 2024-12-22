<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Handle plugin auto updates.
 */
class SS_Updates
{
    /**
     *  API Version. This is passed to the server through request to choose the API version.
     *
     *  @const string
     */
    const API_VERSION = 'v1.0';
    
    /**
     *  Keep configuration.
     *
     *  @var array
     */
    protected $config = array();
    
    /**
     *  Keep data from remote server.
     *
     *  @var object
     */
    protected $remote_data = null;
    
    /**
     *  Prepare everythink for update request.
     *
     *  @param array $config [optional] Array of config.
     */
    public function __construct($config = array())
    {
        $this->config = $config;
        
        add_filter('pre_set_site_transient_update_plugins', array(&$this, 'set_update_transient'));
        add_filter('plugins_api', array(&$this, 'show_plugin_info'), 10, 3);
    }
    
    /**
     *  Get remote information about the latest version available.
     *
     *  @return object Returns an object from the response data, or null on failure.
     */
    public function get_remote_info()
    {
        $result = wp_remote_post($this->config['remote_url'],
        array
        (
            'body'  => array
            (
                'api_version'   => self::API_VERSION,
                'purchase_code' => $this->config['purchase_code']
            )
        ));
        
        if (!is_wp_error($result) || wp_remote_retrieve_response_code($result) === 200)
        {
            $result = json_decode(wp_remote_retrieve_body($result));
        
            return (!empty($result)) ? $result : null;;
        }
        
        return null;
    }
    
    /**
     *  Add self-hosted updates for our plugin.
     *
     *  @param object $transient WP transient object.
     *
     *  @return object $transient WP transient object.
     */
    public function set_update_transient($transient)
    {
        if (empty($transient->checked))
        {
            return $transient;
        }
    
        if (empty($this->remote_data))
        {
            $this->remote_data = $this->get_remote_info();
        }
        
        $response = $this->remote_data;
        
        //ap_debug()->log($response);
        
        if (!empty($response) && version_compare($this->config['version'], $response->version, '<'))
        {
            $transient_pl = new stdClass();
            
            $transient_pl->slug = $this->config['slug'];
            $transient_pl->new_version = $response->version;
            $transient_pl->url = $this->config['update_url'];
            $transient_pl->package = $this->config['update_url'];
            
            $transient->response[$this->config['plugin_slug']] = $transient_pl;
        }
        
        return $transient;
    }
    
    /**
     *  Add self-hosted description to the filter.
     *
     *  @param bool|object $result The result object. Default false.
     *  @param string $action The type of information being requested from the Plugin Install API.
     *  @param object $args Plugin API arguments.
     *
     *  @return bool|object Returns the information.
     */
    public function show_plugin_info($result, $action, $args)
    {
        if (isset($args->slug) && $args->slug === $this->config['slug'])
        {
            if (empty($this->remote_data))
            {
                $this->remote_data = $this->get_remote_info();
            }
            
            $this->remote_data->info->sections = json_decode(json_encode($this->remote_data->info->sections), true);
            
            return $this->remote_data->info;
        }
        
        return false;
    }
}