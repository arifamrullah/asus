<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Make Social Stream ready for Visual Composer
 */
class SS_Visual_Composer
{
    /**
     *  Init hooks.
     */
    public function __construct()
    {
        add_action('init', array($this, 'init_vc'));
    }
    
    /**
     *  Init Visual Composer.
     */
    public function init_vc()
    {
        /*
         *  Check if Visual Composer is installed.
         *  If it is not installed, we don't want to do anything.
         */
        if (!defined('WPB_VC_VERSION'))
        {
            return ;
        }
        
        $posts = get_posts(array('post_type' => SS_Post_Type::POST_TYPE));
        
        $streams = array();
        
        foreach ($posts as $post)
        {
            $streams[$post->post_title] = $post->post_name;
        }
        
        // Register our shortcode within Visual Composer interface.
        vc_map(array
        (
            'name'          => SS_NAME,
            'description'   => __('Display a social stream in your page', 'social-stream'),
            'base'          => 'cardz',
            'class'         => '',
            'controls'      => 'full',
            'icon'          => SS_PURL . '/admin/assets/images/vc_icon.png',
            'category'      => __('Social', 'js_composer'),
            'params'        => array
            (
                array
                (
                    'type'          => 'dropdown',
                    'holder'        => 'div',
                    'class'         => '',
                    'heading'       => __('Use', 'social-stream'),
                    'param_name'    => 'use',
                    'value'         => $streams,
                    'description'   => __('Select which stream to be used', 'social-stream')
                )
            )
        ));
    }
}

new SS_Visual_Composer();