<?php
/**
 * Bootstrap Basic theme
 *
 * @package bootstrap-basic
 */


/**
 * Required WordPress variable.
 */
if (!isset($content_width)) {
	$content_width = 1170;
}


if (!function_exists('bootstrapBasicSetup')) {
	/**
	 * Setup theme and register support wp features.
	 */
	function bootstrapBasicSetup()
	{
		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 *
		 * copy from underscores theme
		 */
		load_theme_textdomain('bootstrap-basic', get_template_directory() . '/languages');

		// add theme support post and comment automatic feed links
		add_theme_support('automatic-feed-links');

		// enable support for post thumbnail or feature image on posts and pages
		add_theme_support('post-thumbnails');
		add_image_size('grid',432,432,true);

		// add support menu
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'bootstrap-basic'),
		));

		// add post formats support
		add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

		// add support custom background
		add_theme_support(
			'custom-background',
			apply_filters(
				'bootstrap_basic_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => ''
				)
			)
		);
	}// bootstrapBasicSetup
}
add_action('after_setup_theme', 'bootstrapBasicSetup');


if (!function_exists('bootstrapBasicWidgetsInit')) {
	/**
	 * Register widget areas
	 */
	function bootstrapBasicWidgetsInit()
	{
		register_sidebar(array(
			'name'          => __('Header right', 'bootstrap-basic'),
			'id'            => 'header-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Navigation bar right', 'bootstrap-basic'),
			'id'            => 'navbar-right',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		));

		register_sidebar(array(
			'name'          => __('Sidebar left', 'bootstrap-basic'),
			'id'            => 'sidebar-left',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Sidebar right', 'bootstrap-basic'),
			'id'            => 'sidebar-right',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Footer left', 'bootstrap-basic'),
			'id'            => 'footer-left',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Footer right', 'bootstrap-basic'),
			'id'            => 'footer-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
	}// bootstrapBasicWidgetsInit
}
add_action('widgets_init', 'bootstrapBasicWidgetsInit');


if (!function_exists('bootstrapBasicEnqueueScripts')) {
	/**
	 * Enqueue scripts & styles
	 */
	function bootstrapBasicEnqueueScripts()
	{
		wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css');
		wp_enqueue_style('bootstrap-theme-style', get_template_directory_uri() . '/css/bootstrap-theme.min.css');
		wp_enqueue_style('fontawesome-style', get_template_directory_uri() . '/css/font-awesome.min.css');
		wp_enqueue_style('main-style', get_template_directory_uri() . '/css/custom.css');
		wp_enqueue_style('mobile-style', get_template_directory_uri() . '/css/mobile.css');
		wp_enqueue_style('bxslider-style', get_template_directory_uri() . '/css/jquery.bxslider.css');
		wp_enqueue_style('featherlight-style', get_template_directory_uri() . '/css/featherlight.css');
		wp_enqueue_style('featherlight-gallery-style', get_template_directory_uri() . '/css/featherlight.gallery.css');
		wp_enqueue_style( 'style', get_stylesheet_uri() );

		wp_enqueue_script('jquery-script', get_template_directory_uri() . '/js/jquery.js','','',false);
		wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js','','',true);
		wp_enqueue_script('easing-script', get_template_directory_uri() . '/js/jquery.easing.min.js','','',true);
		wp_enqueue_script('scrolling-script', get_template_directory_uri() . '/js/scrolling-nav.js','','',true);
		wp_enqueue_script('masonry-script', get_template_directory_uri() . '/js/masonry.pkgd.js','','',true);
		wp_enqueue_script('bxslider-script', get_template_directory_uri() . '/js/jquery.bxslider.js','','',true);
		wp_enqueue_script('owlcarousel-script', get_template_directory_uri() . '/js/owl.carousel.min.js','','',true);
		wp_enqueue_script('featherlight-script', get_template_directory_uri() . '/js/featherlight.js','','',true);
		wp_enqueue_script('featherlight-gallery-script', get_template_directory_uri() . '/js/featherlight.gallery.js','','',true);
		wp_enqueue_script('main-script', get_template_directory_uri() . '/js/main.js','','',true);
		$email_nonce = null;
		wp_localize_script( 'main-script', 'ajax_object', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'base_url' => get_template_directory_uri(), 
			'we_value' => $email_nonce
			)
		);
	}// bootstrapBasicEnqueueScripts
}
add_action('wp_enqueue_scripts', 'bootstrapBasicEnqueueScripts');

// Add Shortcode
function left_image_right_text( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'image' => '',
			'title' => '',
		), $atts )
	);

	// Code
	$isi = '<div class="container-fluid content-grey">
				<div class="row">
					<div class="col-md-5 noPad left">
						<img src="'.$image.'" />
					</div>
					<div class="col-md-6 right">
						<h3>
							'.$title.'
						</h3>
						'.$content.'
					</div>
				</div>
			</div>';
	return  $isi ;
}
add_shortcode( 'left-image', 'left_image_right_text' );

// Add Shortcode
function right_image_left_text( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'image' => '',
			'title' => '',
			'link' =>'',
		), $atts )
	);

	// Code
	$isi = '<div class="container-fluid content-grey">
				<div class="row">
					<div class="col-md-6 noPad left pull-right">
						<img src="'.$image.'" />
					</div>
					<div class="col-md-5 right  pull-right">
						<h3>
							'.$title.'
						</h3>
						'.$content.'
						<a href="'.$link.'" class="btn-info">
						READ MORE
						</a>
					</div>
				</div>
			</div>';
	return  $isi ;
}
add_shortcode( 'right-image', 'right_image_left_text' );

/**
 * admin page displaying help.
 */
if (is_admin()) {
	require get_template_directory() . '/inc/BootstrapBasicAdminHelp.php';
	$bbsc_adminhelp = new BootstrapBasicAdminHelp();
	add_action('admin_menu', [$bbsc_adminhelp, 'themeHelpMenu']);
	unset($bbsc_adminhelp);
}

function newscred_js() {
    echo '<script src="//analytics.newscred.com/analytics_b23771d3521c4a34936786a310751e99.js"></script>';
}

add_action( 'wp_head', 'newscred_js' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Custom dropdown menu and navbar in walker class
 */
require get_template_directory() . '/inc/BootstrapBasicMyWalkerNavMenu.php';


/**
 * Template functions
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * --------------------------------------------------------------
 * Theme widget & widget hooks
 * --------------------------------------------------------------
 */
require get_template_directory() . '/inc/widgets/BootstrapBasicSearchWidget.php';
require get_template_directory() . '/inc/template-widgets-hook.php';

require get_template_directory() . '/inc/zenpad.php';

// NewsCred Analytics for Scripts

