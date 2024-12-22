<?php if (!defined('ABSPATH')) { exit; }

/**
 *	CardZ Social Stream post type.
 */
class SS_Post_Type
{
    /**
     *  Post type name.
     *
     *  @const String
     */
    const POST_TYPE = 'ss-post-type';

    /**
     *  Post type name.
     *
     *  @var string
     */
    public $post_type = self::POST_TYPE;
    
    /**
     *  Register actions.
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'customize_submenus'));
        add_action('init', array(&$this, 'init'));
        
        add_filter('manage_'. $this->post_type .'_posts_columns', array(&$this, 'add_columns'));
		add_action('manage_posts_custom_column', array(&$this, 'manage_columns'), 10, 2);
    }
    
    /**
     *  Register custom post type.
     */
    public function init()
	{
		$args = array
		(
			'label' => CardZStream::PRODUCT_NAME,
			'labels' => array
			(
				'name' => CardZStream::PRODUCT_NAME,
				'menu_name' => CardZStream::PRODUCT_NAME,
				'singular_name' => CardZStream::PRODUCT_NAME,
				'add_new' => 'Add New Item',
				'all_items' => 'All Items',
				'add_new_item' => 'Add New Item',
				'edit_item' => 'Edit Item',
				'new_item' => 'New Item',
				'view_item' => 'View Item',
				'search_items' => 'Search Item',
				'not_found' => 'No items found',
				'not_found_in_trash' => 'No items found in Trash'
			),
			'hierarchical' => false,
			'public' => true,
			//'show_ui'	=> false,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'show_in_nav_menus' => false,
			'show_in_admin_bar' => false,
			'show_in_menu' => true,
			'capability_type' => 'post',
			'supports' => array('title'/*, 'editor'*/),
			'menu_icon' => SS_PURL . '/admin/assets/images/plugin_16_color.png',
			'menu_position' => 200
		);
	
		register_post_type($this->post_type, $args);
        
        if ($args['hierarchical'])
		{
			add_filter('page_row_actions', array($this, '_manage_row_actions'), 10, 2);
		}
		else
		{
			add_filter('post_row_actions', array($this, '_manage_row_actions'), 10, 2);
		}
	}
    
    /**
	 *	Customize submenu.
	 */
	public function customize_submenus()
	{
		global $submenu;
		
		// Remove the Add New menu.
		unset($submenu['edit.php?post_type=' . $this->post_type][10]);
	}
    
    /**
	 *	Add custom columns to the post list.
	 */
	public function add_columns($columns)
	{
		// Put the columns right after the title column.
		$slice = array_slice($columns, 0, 2, true);
		
		$slice['cardz-social-stream-shortcode']	= __('Shortcode', 'cardz-social-stream');
		$slice['cardz-social-stream-slug']		= __('Slug', 'cardz-social-stream');
		
		$slice += $slice + array_slice($columns, 2, count($columns) - 1, true);
		
		return $slice;
	}
	
	/**
	 *	Manage columns.
	 */
	public function manage_columns($column, $post_id)
	{
		global $post;
		
		switch ($column)
		{
		case 'cardz-social-stream-shortcode':
			echo $this->get_shortcode($post_id);
			break;
			
		case 'cardz-social-stream-slug':
			echo $this->get_slug($post_id);
			break;
		}
	}
    
    /**
	 *	Manage row actions.
	 */
	public function manage_row_actions($actions, $post)
	{
		if (isset($_GET['post_type']) && $_GET['post_type'] == $this->post_type)
		{
			$analytics_url = admin_url('edit.php?post_type='. $this->post_type .'&page=ss-analytics-page&post=' . $post->ID);
		
			$actions['edit'] = '<a href="#" class="cardz-social-stream-edit" data-post-id="'. $post->ID .'" title="Edit this item">'. __('Edit', 'cardz-social-stream') .'</a>';
			$actions['view'] = '<a href="#" class="cardz-social-stream-view" data-post-id="'. $post->ID .'" title="Preview this item">'. __('View', 'cardz-social-stream') .'</a>';
			$actions['analytics'] = '<a href="'. $analytics_url .'" class="cardz-social-stream-analytics" data-post-id="'. $post->ID .'" title="Show Analytics for this item">'. __('Analytics', 'cardz-social-stream') .'</a>';
		
			unset($actions['inline hide-if-no-js']);
		}
	
		return $actions;
	}
    
    /**
	 *	Trigger manage row actions for this post type.
	 */
	public function _manage_row_actions($actions, $post)
	{
		if ($post->post_type = $this->post_type)
		{
			return $this->manage_row_actions($actions, $post);
		}
	
		return $actions;
	}
    
    /**
	 *	Get shortcode.
	 */
	private function get_shortcode($post_id)
	{
		$shortcode = '[' . SS_Shortcodes::MAIN_SHORTCODE . ' use=\'' . $this->get_slug($post_id) . '\'][/' . SS_Shortcodes::MAIN_SHORTCODE . ']';
		
		return '<input type="text" style="width: 100%;" value="' . $shortcode . '" readonly />';
	}
	
	/**
	 *	Get popup slug.
	 */
	private function get_slug($post_id)
	{
		$post_data = get_post($post_id);
		
		return $post_data->post_name;
	}
}