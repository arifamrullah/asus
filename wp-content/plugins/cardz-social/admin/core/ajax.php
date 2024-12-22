<?php if (!defined('ABSPATH')) { exit; }

/**
 *	CardZ Social Stream Admin ajax hooks.
 */
class SS_Admin_Ajax
{
	/**
	 *	Set hooks.
	 */
	public function __construct()
	{
        add_action('wp_ajax_ss-load-view', array(&$this, 'load_view'));
        
        add_action('wp_ajax_ss-new-stream', array(&$this, 'add_new_stream'));
        
        add_action('wp_ajax_ss-save-project', array(&$this, 'save_project'));
        
        add_action('wp_ajax_ss-add-new-feed', array(&$this, 'add_new_feed'));
        
        add_action('wp_ajax_ss-analytics-get', array(&$this, 'get_analytics_data'));

        add_action('wp_ajax_insert_social_feed', array(&$this, 'insert_social_feed'));
	}
    
    public function insert_social_feed(){
        ob_clean();
        $data = (isset($_REQUEST['data'])) ? $_REQUEST['data'] : '';
        $category_id = 0;
        if ($data['network'] == "facebook"){
            $category_id = 3;
        } else if ($data['network'] == "twitter"){
            $category_id = 4;
        } else if ($data['network'] == "instagram"){
            $category_id = 5;
        }

        $post = array(
            'post_title' => $data['network'],
            'post_content' => $data['content'],
            'post_status' => 'draft',
            'post_category' => array( $category_id ),
            'post_type' =>  'social-feed',
        );
        $post_id = wp_insert_post( $post );
        wp_set_post_terms( $post_id, array( $category_id ), 'social-feed-categories', true );

        update_post_meta( $post_id, '_url_value', $data['url'] );
        update_post_meta( $post_id, '_username_value', $data['username'] );
        update_post_meta( $post_id, '_userphoto_value', $data['userphoto'] );

        //Upload Image
        if ( isset( $data['image'] ) ) {
            $data['image'] = urldecode( str_replace( "https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&resize_w=280&refresh=172800&url=", "", $data['image'] ) );
        }

        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents( $data['image'] );
        $filename = basename( $data['image'] );
        if ( wp_mkdir_p( $upload_dir['path'] ) )
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents( $file, $image_data );

        $wp_filetype = wp_check_filetype( $filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name( $filename ),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        set_post_thumbnail( $post_id, $attach_id );
        //end upload image

        wp_die();
    }

    /**
     *  Load a registered view.
     */
    public function load_view()
    {
        $view = (isset($_REQUEST['view'])) ? $_REQUEST['view'] : '';
        
        $additional_data = array();
        
        if (isset($_REQUEST['post_id']))
        {
            $additional_data['post_id'] = $_REQUEST['post_id'];
            $additional_data['post'] = get_post($additional_data['post_id']);
            $additional_data['menu_id'] = $additional_data['post_id'];
        }
        else if (isset($_REQUEST['menu_id']))
        {
            $additional_data['post_id'] = $_REQUEST['menu_id'];
            $additional_data['post'] = get_post($additional_data['post_id']);
            $additional_data['menu_id'] = $additional_data['post_id'];
        }
        
        // Pass request variables to the view.
        foreach ($_REQUEST as $key => $value)
        {
            if ($key !== 'post_id' || $key !== 'menu_id'|| $key !== 'view')
            {
                $additional_data[$key] = $value;
            }
        }
        
        if ($view === 'canvas' || $view === 'preview')
        {
            global $post;
            
            if (!empty($additional_data['post']))
            {
                $post = $additional_data['post'];
                $additional_data['options'] = SS_Data()->get_options();
            }
        }
        
        ss_load_admin_view($view, $additional_data);
    
        die();
    }
    
    /**
     *  Add new stream.
     */
    public function add_new_stream()
    {
        $name = ss_post('stream-name');
        $caption = ss_post('stream-caption');
        $skin = ss_post('skin-name');
        
		if (!empty($name))
		{
			$post_data = array
			(
				'post_title'	=> $name,
				'post_content'	=> '',
				'post_status'	=> 'publish',
				'post_type'		=> SS_Post_type::POST_TYPE,
			);
			
			$post_id = wp_insert_post($post_data);
			
			add_post_meta($post_id, 'ss-caption', $caption);
			add_post_meta($post_id, 'ss-skin', $skin);
		}

		die();
    }
    
    /**
     *  Save project.
     */
    public function save_project()
    {
        $post_id = ((isset($_POST['id'])) ? $_POST['id'] : 0);
		//$css_data = ss_post('cssData');
        
        //print_r($_POST);
        
        //echo $css;
        
		CardZStream()->admin->editor->save_data($post_id);
    
        die();
    }
    
    /**
     *  Add new custom feed post.
     */
    public function add_new_feed()
    {
        global $wpdb;
        
        $id_post = ss_request('id_post');
        $name = ss_request('name', '');
        $network = ss_request('network', 'custom');
        $message = ss_request('message', '');
        $description = ss_request('description', '');
        $link = ss_request('link', '');
        $attachment = ss_request('attachment', '');
        $video_source = ss_request('video_source', '');
        $author_name = ss_request('author_name', '');
        $author_picture = ss_request('author_picture', '');
        $author_link = ss_request('author-link', '');
        $created = ss_request('created', date("Y-m-d H:i:s"));
        $iteration = ss_request('iteration', 1);
        $position = ss_request('position', '-1');
        
        if ($id_post === false)
        {
            die();
        }
        
        $wpdb->insert($wpdb->ss_feeds,
        array
        (
            'id_post'           => $id_post,
            'name'              => $name,
            'network'           => $network,
            'message'           => $message,
            'description'       => $description,
            'link'              => $link,
            'attachment'        => $attachment,
            'video_source'      => $video_source,
            'author_name'       => $author_name,
            'author_picture'    => $author_picture,
            'author_link'       => $author_link,
            'created'           => $created,
            'iteration'         => $iteration,
            'position'          => $position
        ),
        array
        (
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d'
        ));
    
        die();
    }
    
    /**
	 *	Get analytics data.
	 */
	public function get_analytics_data()
	{
		$post_id = ss_get('post_id', '');
		$date = ss_get('date', '');
		$date = explode(' - ', $date);
		$start_date = strtotime($date[0]);
		$end_date = strtotime($date[1]);
	
		$data = CardZStream()->admin->analytics->get_data_by_date($post_id, $start_date, $end_date);
	
        /*
		 *	We need to increment the end date by 1 day, because how MySQL will see the time.
		 */
		/*$start_date = new DateTime(date(DateTime::ATOM, $start_date));
		$end_date = new DateTime(date(DateTime::ATOM, strtotime('+1 day', $end_date)))
        
        
        
        $interval = new DateInterval('P1D');
        
        $date_range = new DatePeriod($start_date, $interval, $end_date);
        
        foreach ($date_range as $date)
        {
            echo $date->format(DateTime::ATOM) . "\n";
        }*/
        
        $start_date = date('F j, Y', $start_date);
        $end_date = date('F j, Y', $end_date);
        
        $step = 'date';
        
        if ($start_date === $end_date)
        {
            $step = 'hour';
        }
        
		echo CardZStream()->admin->analytics->format_data($data, $step);

		die();
	}
     
}

$ss_admin_ajax = new SS_Admin_Ajax();
