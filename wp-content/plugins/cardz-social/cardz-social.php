<?php
/*
 *	Plugin Name: CardZ Social Stream
 *	Plugin URI: http://www.wpsocialstream.com/
 *	Description: CardZ Social Stream for WordPress
 *	Author: Agapa Studio
 *	Author URI: http://www.agapastudio.com/
 *	Version: 9999
 *
 *	Copyright (c) 2015 by Agapa Studio. All rights reserved.
 */
 
if (!defined('ABSPATH')) { exit; }

// This should be removed on the production version.
include_once('core/debug.php');

/**
 *	Main CardZ Social Stream class.
 */
final class CardZStream
{
    /**
     *  Plugin name.
     *
     *  @const string
     */
    const PRODUCT_NAME = 'CardZ Social Stream';
    
    /**
     *  Plugin version.
     *
     *  @const string
     */
    const VERSION = '1.0.52';
    
	/**
	 *	String version.
	 */
	public $version = self::VERSION;
    
    /**
     *  Plugin Name
     */
    public $name = self::PRODUCT_NAME;
	
	/**
	 *	Instance of the SS_Admin class.
	 */
	public $admin = null;
	
	/**
	 *	Instance of SS_Options class.
	 */
	public $options = null;
    
    /**
     *  Instance of SS_DB_Cache class.
     *
     *  @var SS_DB_Cache
     */
    public $cache = null;
	
	/**
	 *	Instance of this class.
	 */
	protected static $instance = null;
	
	
	/**
	 *	Default constructor.
	 */
	public function __construct()
	{
		$this->set_constants();
		$this->include_files();
		
        $update_frequency = 300; // 2 hours.
        
		$this->admin = new SS_Admin();
		$this->options = new SS_Options();
        $this->cache = new SS_DB_Cache($update_frequency, true);        
        
        add_action('init', array(&$this, 'init'));
		
		// Register hooks to handle install and uninstall process.
		register_activation_hook(__FILE__, array($this, 'activate'));
		register_uninstall_hook(__FILE__, array('CardZStream', 'uninstall'));
		
		add_action('wp_enqueue_scripts', array($this, 'load_client_scripts'));
		add_action('wp_head', array($this, 'insert_in_header'));
	}
	
	/**
	 *	Get instance of this class.
	 *
	 *	@return CardZStream - Main instance.
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
     *  When wordpress initializes.
     */
    public function init()
    {
        global $wpdb;
        
        $wpdb->ss_analytics = $wpdb->prefix . 'ss_analytics';
        $wpdb->ss_feeds = $wpdb->prefix . 'ss_feeds';
    }
	
	/**
	 *	Define CardZ Social Stream constants.
	 */
	public function set_constants()
	{
		define('SS_VERSION', $this->version);
        define('SS_NAME', $this->name);
		
		define('SS_PROOT', dirname(__FILE__));				// Plugin root.
		define('SS_CROOT', dirname(get_theme_root()));		// Content root.
		
		define('SS_PURL', plugins_url('', __FILE__));		// Plugin URL.
		define('SS_CURL', content_url());					// Content URL.
		
		define('SS_HOME_URL', get_home_url());					// Home page URL.
        
        define('SS_DEFAULT_AVATAR', SS_PURL . '/assets/images/avatar.jpg');
        
        define('SS_DEFAULT_LIMIT', 30);
	}
    
	/**
	 *	Inclure required core files.
	 */
	public function include_files()
	{
        require_once('core/web-fonts.php');
		require_once('core/utility.php');
        require_once('core/skins.php');
        require_once('core/options.php');
		require_once('core/shortcodes.php');
		require_once('core/ajax.php');
        require_once('core/data.php');
        require_once('core/external/visual-composer.php');
        
        require_once('core/cache.php');
		
        require_once('core/social/social-base.php');
        require_once('core/social/social-dribbble.php');
        require_once('core/social/social-facebook.php');
        require_once('core/social/social-flickr.php');
        require_once('core/social/social-foursquare.php');
        require_once('core/social/social-google.php');
        require_once('core/social/social-instagram.php');
        require_once('core/social/social-pinterest.php');
        require_once('core/social/social-rss.php');
        require_once('core/social/social-soundcloud.php');
        require_once('core/social/social-tumblr.php');
        require_once('core/social/social-twitter.php');
        require_once('core/social/social-vimeo.php');
        require_once('core/social/social-vine.php');
        require_once('core/social/social-vk.php');
        require_once('core/social/social-youtube.php');
        
		require_once('admin/admin.php');
	}
	
	/**
	 *	Create the necessarly database for analytics.
	 */
	public function activate()
	{
		global $wpdb, $charset_collate;
		
		if (!current_user_can('activate_plugins'))
		{
			return ;
		}
        
        $wpdb->ss_analytics = $wpdb->prefix . 'ss_analytics';
        $wpdb->ss_feeds = $wpdb->prefix . 'ss_feeds';
		
		$query = "CREATE TABLE IF NOT EXISTS {$wpdb->ss_analytics}" .
		'(' .
		'	id_analytics INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,' .
		'	id_post INT(11) UNSIGNED NOT NULL,' .
		'	name VARCHAR(200) NOT NULL,' .
		'	views INT(11) UNSIGNED NOT NULL,' .
		'	clicks INT(11) UNSIGNED NOT NULL,' .
		'	conversions INT(11) UNSIGNED NOT NULL,' .
		'	conversion_rate INT(11) UNSIGNED NOT NULL,' .
		'	start_time DATETIME NOT NULL,' .
		'	close_time DATETIME NOT NULL,' .
		'	PRIMARY KEY (id_analytics)' .
		") $charset_collate;";
		
		$wpdb->query($query);
        
        $query = <<<SQL
            CREATE TABLE IF NOT EXISTS {$wpdb->ss_feeds}
            (
                id_feed INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                id_post INT(11) UNSIGNED NOT NULL,
                name VARCHAR(200) NOT NULL,
                network VARCHAR(80) NOT NULL,
                message TEXT NOT NULL,
                description TEXT NOT NULL,
                link VARCHAR(2000) NOT NULL,
                attachment VARCHAR(2000) NOT NULL,
                video_source VARCHAR(2000) NOT NULL,
                author_name VARCHAR(200) NOT NULL,
                author_picture VARCHAR(2000) NOT NULL,
                author_link VARCHAR(2000) NOT NULL,
                added TIMESTAMP NOT NULL DEFAULT NOW(),
                created DATETIME NOT NULL,
                iteration INT(11) UNSIGNED NOT NULL DEFAULT 1,
                position INT(11) NOT NULL DEFAULT -1,
                PRIMARY KEY (id_feed)
            ) {$charset_collate};
SQL;

        $wpdb->query($query);
        
        $this->cache->create_db_table();
	}
	
	/**
	 *	Remove any data.
	 */
	public static function uninstall()
	{
		global $wpdb;
		
		exit;
		
		if (!defined('WP_UNINSTALL_PLUGIN'))
		{
			exit;
		}
		
		// Remove tables
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ss_analytics");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ss_feeds");
		
		$streams = get_posts(array('post_type' => SS_Post_Type::POST_TYPE));
		
		foreach ($streams as $stream)
		{
			wp_delete_post($stream->ID, true);
		}
	}
	
	/**
	 *	Load scripts on the client side.
	 */
	public function load_client_scripts()
	{
        // If the jQuery is not already included, then include it.
		if (!wp_script_is('jquery'))
		{
			wp_enqueue_script('jquery');
		}
        
        /*wp_enqueue_style('cardz-social-fx-style', SS_PURL . '/content/js/cardz.social.fx.css');
        
        wp_enqueue_style('cardz-social-font-style', SS_PURL . '/content/js/skins/assets/css/font.css');
        
        wp_enqueue_style('cardz-social-default-skin', SS_PURL . '/content/js/skins/grid/flat/flat.css');*/
        
        wp_enqueue_script('cardz-social-general-script', SS_PURL . '/assets/js/script.js', array('jquery'));
        
        wp_enqueue_script('cardz-social-script', SS_PURL . '/content/js/cardz.social.min.js', array('jquery'));
        
        wp_localize_script('cardz-social-general-script', 'ss_urls', array
		(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'pluginurl' => SS_PURL
		));
	}
    
	/**
	 *	Insert HTML code in header.
	 */
    public function insert_in_header()
    {
    ?>
        <script>var cardz_instances = {};jQuery.fn.cardZSocial.defaults = jQuery.extend(jQuery.fn.cardZSocial.defaults, {pluginURL: '<?php echo SS_PURL; ?>/content/js/', pluginPath: '<?php echo SS_PURL; ?>/content/js/'});</script>
    <?php
    }
}

/**
 *	Returns the main instance of CardZStream.
 *
 *	@return CardZStream
 */
function CardZStream()
{
	return CardZStream::get_instance();
}

global $speedo_social_stream;

$speedo_social_stream = CardZStream();