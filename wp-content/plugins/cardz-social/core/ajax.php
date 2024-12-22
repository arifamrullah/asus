<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Client ajax hooks.
 */
class SS_Client_Ajax
{
	/**
	 *	Set hooks.
	 */
	public function __construct()
	{
		add_action('wp_ajax_ss_analytics_add', array(&$this, 'save_analytics_data'));
		add_action('wp_ajax_nopriv_ss_analytics_add', array(&$this, 'save_analytics_data'));
        
        add_action('wp_ajax_ss-get-feed-data', array(&$this, 'get_feed_data'));
        add_action('wp_ajax_nopriv_ss-get-feed-data', array(&$this, 'get_feed_data'));
	}
	
	/**
	 *	Save analytics data.
	 */
	public function save_analytics_data()
	{
		global $wpdb;

		$data = (isset($_GET['data'])) ? $_GET['data'] : array();
	
		$format = array
		(
			'%d',
			'%s',
			'%d',
			'%d',
			'%d',
			'%d',
			'%s',
			'%s'
		);
	
		foreach ($data as $name => $value)
		{
			$post_id = ss_get_post_id($name, array('post_type' => SS_Post_Type::POST_TYPE));
            
			$affected_rows = $wpdb->insert($wpdb->ss_analytics,
			array
			(
				'id_post'			=> $post_id,
				'name'				=> $name,
				'views'				=> $value['views'],
				'clicks'			=> $value['clicks'],
				'conversions'		=> $value['conversions'],
				'conversion_rate'	=> $value['conversion_rate'],
				'start_time'		=> $value['start_time'],
				'close_time'		=> $value['close_time'] || ''
			), $format);
		
			if ($affected_rows === false)
			{
				// Something wen't wrong.
			}
		}
	
		//file_put_contents(SPO_PROOT . '/analytics-data.txt', print_r($data, true));
	
		die();
	}
    
    /**
     *  GET feed data.
     */
    public function get_feed_data()
    {
        $use = ss_request('use');
        $plain = ss_request('plain');
        
        if (!$use)
        {
            die();
        }
        
        header('Content-type: application/json');
        
        global $post;
        
        if (is_numeric($use))
        {
            $post = get_post($use);
        }
        else
        {
            $post = ss_get_post_by_slug($use, array('post_type' => SS_Post_Type::POST_TYPE));
        }
        
        if (empty($post))
        {
            die();
        }
        
        $options = SS_Data()->get_options(!$plain);
        
        echo ($plain) ? json_encode($options['feedData']) : $options;

        die();
    }
}

$ss_client_ajax = new SS_Client_Ajax();