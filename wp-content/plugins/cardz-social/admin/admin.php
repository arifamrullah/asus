<?php if (!defined('ABSPATH')) { exit; }

/**
 *	CardZ Social Stream admin.
 */
class SS_Admin
{
    /**
     *  Instance of SS_Editor class.
     *
     *  @var SS_Editor
     */
    public $editor = null;
    
    /**
     *  Instance of SS_Analytics class.
     *
     *  @var SS_Analytics
     */
    public $analytics = null;
    
    /**
     *  Post type instance.
     */
    public $post_type = null;

	/**
	 *	Array of pages.
	 */
	private $pages = array();
	
	/**
	 *	Array of sections.
	 */
	private $sections = array();
	
	/**
	 *	Array of checkboxes.
	 */
	private $checkboxes = array();
	
	/**
	 *	Array of settings.
	 */
	private $settings = array();
    
    /**
     *  Settings page instance.
     */
    private $ss_pg_settings = null;
    
    /**
     *  Support page instance.
     *
     *  @since 1.0.43
     */
    private $ss_pg_support = null;
    
    /**
     *  Keep notices.
     */
    public $notices = array();
	
	/**
	 *	Constructor. Register functions.
	 */
	public function __construct()
	{
        $this->include_files();
        
        // We want to show even if we are not int the admin.
        add_action('admin_bar_menu', array(&$this, 'admin_bar_menu'), 100);
        
        if (!is_admin())
        {
            return ;
        }
        
        $this->register_views();
		
        $this->post_type = new SS_Post_Type();
        $this->editor = new SS_Editor(SS_Post_Type::POST_TYPE);
        $this->analytics = new SS_Analytics();
        
        $this->ss_pg_settings = new SS_Pg_Settings();
        $this->ss_pg_support = new SS_Pg_Support();
        
        global $speedo_social_stream;
        
        $update = new SS_Updates(array
        (
            'slug'          => 'cardz-social',
            'plugin_slug'   => 'cardz-social/cardz-social.php',
            'remote_url'    => 'http://www.wpsocialstream.com/api/?call=updates&action=info',
            'update_url'    => 'http://www.wpsocialstream.com/api/?call=updates',
            //'version'       => '0.0.1',
            'version'       => CardZStream::VERSION,
            'purchase_code' => get_option('ss-purchase-code')
        ));
        
        $this->request_notices();
        
        //$this->notices[] = $update->get_notices();
        
        global $ss_file_cache;
        
        // Handle clear cache actions.
        if (isset($_GET['post_type']) && $_GET['post_type'] === SS_Post_Type::POST_TYPE)
        {
            if (isset($_GET['cz_action']) && $_GET['cz_action'] === 'empty-all-caches')
            {
                $ss_file_cache->clear();
            }
            else if (isset($_GET['cz_action']) && $_GET['cz_action'] === 'empty-stream-cache')
            {
                $stream = $_GET['stream'];
                
                if (!empty($stream))
                {
                    $ss_file_cache->clear('feedData_' . $stream);
                }
            }
        }
		
        add_action('admin_menu', array(&$this, 'register_menu_items'));
		add_action('admin_enqueue_scripts', array(&$this, 'register_scripts'));
        add_action('admin_notices', array(&$this, 'admin_notices'));
		add_filter('contextual_help', array(&$this, 'contextual_help'), 10, 3);
	}
	
	/**
	 *	Include required core files.
	 */
	public function include_files()
	{
		$this->include_html_elements();
	
        require_once('core/pages/settings.php');
        require_once('core/pages/support.php');
        require_once('core/analytics.php');
		require_once('core/view-manager.php');
        require_once('core/post-type.php');
        require_once('core/editor.php');
		require_once('core/options.php');
        require_once('core/update.php');
		require_once('core/tinymce/plugins.php');
		//require_once('core/widgets/stream.php');
		require_once('core/ajax.php');
	}
	
	/**
	 *	Includes requierd HTML elements.
	 */
	public function include_html_elements()
	{
		require_once('core/elements/base-element.php');
		require_once('core/elements/heading-element.php');
		require_once('core/elements/filters-element.php');
        require_once('core/elements/networks-element.php');
		require_once('core/elements/size-element.php');
        require_once('core/elements/align-element.php');
		require_once('core/elements/checkbox-element.php');
		require_once('core/elements/description-element.php');
		require_once('core/elements/input-element.php');
        require_once('core/elements/color-element.php');
        require_once('core/elements/rect-element.php');
		//require_once('core/elements/radio-element.php');
		require_once('core/elements/select-element.php');
		require_once('core/elements/textarea-element.php');
		require_once('core/elements/upload-element.php');
	}
    
    /**
     *  Register admin menu items.
     */
    public function register_menu_items()
    {
        add_submenu_page('edit.php?post_type=' . SS_Post_Type::POST_TYPE, __('Settings', 'social-stream'), __('Settings', 'social-stream'), 'manage_options', 'ss-settings-page', array($this->ss_pg_settings, 'display'));
        add_submenu_page('edit.php?post_type=' . SS_Post_Type::POST_TYPE, __('Support', 'social-stream'), __('Support', 'social-stream'), 'manage_options', 'ss-support-page', array($this->ss_pg_support, 'display'));
    }
    
    /**
     *  Register menu items for admin bar.
     */
    public function admin_bar_menu()
    {
        global $wp_admin_bar;
        
        $menu_items = array();
        
        // Parent menu.
        $menu_items = array
        (
            array
            (
                'id'    => 'cardz-abm',
                'title' => CardZStream::PRODUCT_NAME,
                'href'  => admin_url('edit.php?post_type=' . SS_Post_Type::POST_TYPE)
            )
        );
        
        if (current_user_can('manage_options'))
        {
            $menu_items[] = array
            (
                'id'        => 'cardz-abm-empty-all-caches',
                'parent'    => 'cardz-abm',
                'title'     => __('Empty All Caches', 'cardz-social'),
                'href'      => admin_url('edit.php?post_type=' . SS_Post_Type::POST_TYPE . '&cz_action=empty-all-caches')
            );
            
            $streams = get_posts(array('post_type' => SS_Post_Type::POST_TYPE));
            
            if (!empty($streams))
            {
                $menu_items[] = array
                (
                    'id'        => 'cardz-abm-empty-stream-caches',
                    'parent'    => 'cardz-abm',
                    'title'     => __('Empty Stream Caches', 'cardz-social')
                );
                
                foreach ($streams as $stream)
                {
                    $menu_items[] = array
                    (
                        'id'        => 'cardz-abm-empty-stream-cache-' . $stream->ID,
                        'parent'    => 'cardz-abm-empty-stream-caches',
                        'title'     => __('Empty stream \'' . $stream->post_title . '\'', 'cardz-social'),
                        'href'      => admin_url('edit.php?post_type=' . SS_Post_Type::POST_TYPE . '&cz_action=empty-stream-cache&stream=' . $stream->ID)
                    );
                }
            }
        }
        
        foreach ($menu_items as $menu_item)
        {
            $wp_admin_bar->add_menu($menu_item);
        }
    }
	
    /**
     *  Register admin views.
     */
    public function register_views()
    {
        //$skins = array();
        $skins = SS_Skins()->get_skins();
    
        ss_register_admin_view('new-stream', 'new-stream.php', array('skins' => $skins));
        ss_register_admin_view('editor', 'editor.php');
        ss_register_admin_view('canvas', 'canvas.php', array('options' => ''));
        ss_register_admin_view('preview', 'preview.php', array('options' => ''));
        ss_register_admin_view('network-options', 'network-options.php');
        ss_register_admin_view('add-custom-item', 'add-custom-item.php');
    }
    
	/**
	 *	Register admin scripts and styles.
	 */
	public function register_scripts()
	{
        wp_enqueue_style('cardz-social-stream-admin-css', SS_PURL . '/admin/assets/css/admin.css');
        
        wp_enqueue_script('cardz-social-stream-admin-js', SS_PURL . '/admin/assets/js/admin.js', array('jquery'));
		
		// Add paths.
		wp_localize_script('cardz-social-stream-admin-js', 'SS_HOME_URL', SS_HOME_URL);
        
        // Register libs
        wp_enqueue_script('moment', SS_PURL . '/admin/libraries/moment/moment.min.js', array('jquery'));
        
        wp_enqueue_script('chart-js', SS_PURL . '/admin/libraries/chart-js/Chart.min.js', array('jquery'));
        
        // For media library upload.
		wp_enqueue_media();
	}
    
    /**
     *  Show notifications on admin side.
     */
    public function admin_notices()
    {
        if (!empty($this->notices))
        {
            foreach ($this->notices as $notice)
            {
                if (!empty($notice->template))
                {
                    switch ($notice->template)
                    {    
                    case 'error':
                        echo '<div class="ss-error-nag">' . $notice->message . '</div>';
                        break;
                        
                    case 'update':
                        echo '<div class="update-nag">' . $notice->message . '</div>';
                        break;
                        
                    case 'info':
                    default:
                        echo '<div class="ss-info-nag">' . $notice->message . '</div>';
                        break;
                    }
                }
                else if (isset($notice->html))
                {
                    echo $notice->html;
                }
            }
        }
    }
	
	/**
	 *	Show a contextual help.
	 */
	public function contextual_help($contextual_help, $screen_id, $screen)
	{
		if ($screen_id == 'edit-cardz-social-stream-post')
		{
			$contextual_help = '<p>' . __('CardZ Social Stream help.', 'cardz-social-stream') . '</p>';
			
			$screen->add_help_tab(array(
				'id'	=> 'item',
				'title'	=> __('Item', 'cardz-social-stream'),
				'content'	=> '<p>' . __('This is the content of the new tab', 'cardz-social-stream') . '</p>'
			));
		}
		
		return $contextual_help;
	}
    
    /**
     *  Make a request and get notices from server.
     */
    private function request_notices()
    {
        $response = wp_remote_get('http://www.wpsocialstream.com/api/?call=notices');
        
        if (is_array($response))
        {
            if (!is_wp_error($response) || wp_remote_retrieve_response_code($response) === 200)
            {
                $data = json_decode(wp_remote_retrieve_body($response));
                
                if (isset($data->notices))
                {
                    $this->notices = $data->notices;
                }
            }
        }
    }
}