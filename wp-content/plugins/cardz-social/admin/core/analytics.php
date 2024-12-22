<?php if (!defined('ABSPATH')) { exit; }

/**
 *	CardZ Social analytics.
 */
class SS_Analytics
{
	/**
	 *	Constructor. Registeer hooks.
	 */
	public function __construct()
	{
		add_action('admin_menu', array($this, 'add_admin_menu_page'));
	}
	
	/**
	 *	Add page to the admin menu.
	 */
	public function add_admin_menu_page()
	{
		add_submenu_page(
			'edit.php?post_type=' . SS_Post_Type::POST_TYPE,
			__('Analytics', 'cardz-social'),
			__('Analytics', 'cardz-social'),
			'manage_options',
			'ss-analytics-page',
			array($this, 'display_page')
		);
	}

	/**
	 *	Display the admin page.
	 */
	public function display_page()
	{
		$post_id = ss_request('post_id', ss_request('post', ''));
        
		include_once(SS_PROOT . '/admin/views/analytics.php');
	}
	
	/**
	 *	Get data from the post id.
	 *
	 *	@param $post_id	The post ID.
	 *
	 *	@return An array with data on success, empty array on failure.
	 */
	public function get_data($post_id)
	{
		global $wpdb;
		
        return $wpdb->get_results("SELECT * FROM {$wpdb->ss_analytics} WHERE id_post={$post_id}");
	}
	
	/**
	 *	Get data between two given dates for a specific post.
	 *
	 *	@param $post_id	The post ID.
	 *	@param $start_date	The start date.
	 *	@param $end_date	The end date.
	 *
	 *	@return An array with data on success, empty array on failure.
	 */
	public function get_data_by_date($post_id, $start_date, $end_date)
	{
		global $wpdb;
		
		/*
		 *	We need to increment the end date by 1 day, because how MySQL will see the time.
		 */
		$start_date = date('Y-m-d', $start_date);
		$end_date = date('Y-m-d', strtotime('+1 day', $end_date));
		
        return $wpdb->get_results("SELECT * FROM {$wpdb->ss_analytics} WHERE id_post={$post_id} AND start_time >= '{$start_date}' AND start_time <= '{$end_date}'");
	}
	
	/**
	 *	Get totals.
	 *
	 *	@param $post_id	The post ID.
	 *
	 *	@return An object with data on success, null on failure.
	 */
	public function get_totals($post_id)
	{
		$data = $this->get_data($post_id);
		
		if (empty($data))
		{
			return null;
		}
		
		// Prepare the object.
		$object_data = new stdClass();
		
		$object_data->id_post = $post_id;
		$object_data->name = '';
		$object_data->views = 0;
		$object_data->clicks = 0;
		$object_data->conversions = 0;
		$object_data->conversion_rate = 0;
		$object_data->total_time = new stdClass();
		$object_data->total_time->y = 0;
		$object_data->total_time->m = 0;
		$object_data->total_time->d = 0;
		$object_data->total_time->h = 0;
		$object_data->total_time->i = 0;
		$object_data->total_time->s = 0;
		$object_data->total_time->formated = 0;
		
		foreach ($data as $values)
		{
			$object_data->name = $values->name;
			$object_data->views += $values->views;
			$object_data->clicks += $values->clicks;
			$object_data->conversions += $values->conversions;
			$object_data->conversion_rate += $values->conversion_rate;
			
			$date_a = date_create($values->start_time);
			$date_b = date_create($values->close_time);
			
			$difference = date_diff($date_a, $date_b);
			
			$object_data->total_time->y += $difference->y;
			$object_data->total_time->m += $difference->m;
			$object_data->total_time->d += $difference->d;
			$object_data->total_time->h += $difference->h;
			$object_data->total_time->i += $difference->i;
			$object_data->total_time->s += $difference->s;
		}
		
		$object_data->total_time = $this->format_date($object_data->total_time);
		
		return $object_data;
	}
	
	/**
	 *	Format the data for use on the client side.
	 *
	 *	@param data	The date to format.
     *  @param step How do we step.
	 *
	 *	@return JSON string.
	 */
	public function format_data($data, $step = 'date')
	{
		$result = array
		(
			'views' => array(),
			'clicks' => array(),
			'conversions' => array(),
			'conversion_rate' => array(),
			'time_on_strem' => array(),
			'time_on_page' => array(),
            'totals' => array
            (
                'views' => 0,
			    'clicks' => 0,
			    'conversions' => 0,
			    'conversion_rate' => 0,
			    'time_on_strem' => null,
			    'time_on_page' => null
            ),
            'labels' => array()
		);
        
        $computed_data = array();
		
        foreach ($data as $index => $values)
        {
            if ($step === 'date')
            {
                $date = date('F j, Y', strtotime($values->start_time));
            }
            else
            {
                $date = date('H:i:s', strtotime($values->start_time));
            }
        
            if (!isset($computed_date[$date]))
            {
                $computed_date[$date] = array
		        (
			        'views' => $values->views,
			        'clicks' => $values->clicks,
			        'conversions' => $values->conversions,
			        'conversion_rate' => $values->conversion_rate,
			        'time_on_strem' => array(),
			        'time_on_page' => array()
		        );
            }
            else
            {
                $computed_date[$date]['views']		    += $values->views;
			    $computed_date[$date]['clicks']		    += $values->clicks;
			    $computed_date[$date]['conversions']    += $values->conversions;
            }
        }
        
        foreach ($computed_date as $date => $values)
        {
            $result['views'][]			    = $values['views'];
			$result['clicks'][]			    = $values['clicks'];
			$result['conversions'][]	    = floor($values['conversions'] / $values['views']);
            $result['conversion_rate'][]    = $values['conversions'] / $values['views'] * 100;
            $result['labels'][]             = $date;
            
            $result['totals']['views']              += $values['views'];
            $result['totals']['clicks']             += $values['clicks'];
            $result['totals']['conversions']        += floor($values['conversions'] / $values['views']);
            $result['totals']['conversion_rate']    += $values['conversions'] / $values['views'] * 100;
        }
        /*
		foreach ($data as $index => $values)
		{
			$date = date('F j, Y', strtotime($values->start_time));
			//$date = $values->start_time;
			
			$result['views'][]				= $values->views;
			$result['clicks'][]				= $values->clicks;
			$result['conversions'][]		= $values->conversions;
			$result['conversion_rate'][]	= $values->conversion_rate;
            $result['labels'][]             = $date;
			
			$date_a = date_create($values->start_time);
			$date_b = date_create($values->close_time);
			
			//$difference = date_diff($date_a, $date_b);
			
			//$difference = $this->format_date($difference);
			
			$date_a = strtotime($values->start_time);
			$date_b = strtotime($values->close_time);
			
			$result['time_on_strem'][] = ($date_b - $date_a);
			
			//$result['time_on_popup'][]		= array($date, $difference->formated);
			//$result['time_on_page'][]		= array($date, $values->clicks);
		}*/
		
		return json_encode($result);
	}
	
	/**
	 *	Format the time difference.
	 *
	 *	@param $difference A difference object.
	 *
	 *	@return an object containing the formated difference.
	 */
	public function format_date($difference)
	{
		$data = new stdClass();
		
		$data->y = $difference->y;
		$data->m = $difference->m;
		$data->d = $difference->d;
		$data->h = $difference->h;
		$data->i = $difference->i;
		$data->s = $difference->s;
		
		$data->formated =
		(
			($data->y > 0 ? $data->y . (($data->y > 1) ? ' Years ' : ' Year ') : '') .
			($data->m > 0 ? $data->m . (($data->m > 1) ? ' Months ' : ' Month ') : '') .
			($data->d > 0 ? $data->d . (($data->d > 1) ? ' Days ' : ' Day ') : '') .
			($data->h > 0 ? $data->h . (($data->h > 1) ? ' Hours ' : ' Hour ') : '') .
			($data->i > 0 ? $data->i . (($data->i > 1) ? ' Minutes ' : ' Minute ') : '') .
			($data->s > 0 ? $data->s . (($data->s > 1) ? ' Seconds ' : ' Second ') : '')
		);
		
		return $data;
	}
}