<?php if (!defined('ABSPATH')) { exit; }

/**
 *  CardZ Social Stream editor.
 */
class SS_Editor
{
    /**
     *  Array of fields.
     *
     *  @var array
     */
    protected $fields = array();
    
    /**
     *  Array of groups.
     *
     *  @var array
     */
    protected $groups = array();
    
    /**
     *  Post type name.
     *
     *  @var string
     */
    protected $post_type = SS_Post_Type::POST_TYPE;
    
    /**
     *  Array of available networks.
     *
     *  @var array
     */
    protected $available_networks = array
    (
        'twitter'       => 'Twitter',
        'facebook'      => 'Facebook',
        'google'        => 'Google Plus',
        'youtube'       => 'Youtube',
        'instagram'     => 'Instagram',
        'soundcloud'    => 'SoundCloud',
        'pinterest'     => 'Pinterest',
        'vimeo'         => 'Vimeo',
        'rss'           => 'RSS',
        'foursquare'    => 'Foursquare',
        'vine'          => 'Vine',
        'dribbble'      => 'Dribbble',
        'flickr'        => 'Flickr',
        'tumblr'        => 'Tumblr',
        //'linkedin'      => 'LinkedIn',
        'vk'            => 'vk'
    );
    
    /**
     *  Prepare class.
     *
     *  @param string $post_type [optional] The post type to edit.
     */
    public function __construct($post_type = SS_Post_Type::POST_TYPE)
    {
        $this->post_type = $post_type;
        $this->prepare_fields();
    }
    
    /**
     *  Save the data.
     */
    public function save_data($post_id)
    {
        $this->options->save_data($post_id);
        
        /*
         *  Clear the cached data for this stream. We want to make sure we always have the
         *  latest stream.
         */
        global $ss_file_cache;
        
        if (isset($post_id))
        {
            $ss_file_cache->clear('feedData_' . $post_id);
        }
    }
    
    /**
     *  Render the properties panel.
     */
    public function display($post)
    {
        wp_nonce_field(basename(__FILE__), 'cardz-social-stream-editor-nonce');
        
        // Make variables available to the loaded file.
        $groups = $this->groups;
        
        include_once(SS_PROOT . '/admin/views/properties.php');
    }
    
    /**
     *  Prepare fields.
     */
    protected function prepare_fields()
    {
        global $ss_font_list;
        
        /* Element Properties */
        
        $this->fields['ss-el-width'] = array
        (
            'title'     => __('Width', 'cardz-social'),
            'default'   => '',
            'type'      => 'size'
        );
        
        $this->fields['ss-el-height'] = array
        (
            'title'     => __('Height', 'cardz-social'),
            'default'   => '',
            'type'      => 'size'
        );
        
        $this->fields['ss-el-position'] = array
        (
            'title'     => __('Position', 'cardz-social'),
            'default'   => '0 0 0 0',
            'type'      => 'rect'
        );
        
        $this->fields['ss-el-margins'] = array
        (
            'title'     => __('Margins', 'cardz-social'),
            'default'   => '0 0 0 0',
            'type'      => 'rect'
        );
        
        $this->fields['ss-el-paddings'] = array
        (
            'title'     => __('Paddings', 'cardz-social'),
            'default'   => '0 0 0 0',
            'type'      => 'rect'
        );
        
        $this->fields['ss-font-family'] = array
		(
			'title'		=> __('Font family', 'cardz-social'),
			'desc'		=> '',
			'default'	=> 'Open+Sans',
			'type'		=> 'select',
			'choices'	=> $ss_font_list
		);
        
        $this->fields['ss-font-size'] = array
        (
            'title'     => __('Font size', 'cardz-social'),
            'desc'      => '',
            'default'   => '1em',   
            'type'      => 'size'
        );
        
        $this->fields['ss-font-color'] = array
        (
            'title'     => __('Color', 'cardz-social'),
            'desc'      => '',
            'default'   => '#ffffff',
            'type'      => 'color'
        );
        
        $this->fields['ss-background'] = array
        (
            'title'     => __('Background', 'cardz-social'),
            'desc'      => '',
            'default'   => '#ff0000',
            'type'      => 'color'
        );
        
        $this->fields['ss-text-align'] = array
        (
            'title'         => __('Text Align', 'cardz-social'),
            'default'       => 'left',
            'horizontal'    => true,
            'type'          => 'align'
        );
        
        $this->fields['ss-border-color'] = array
        (
            'title'     => __('Border Color', 'cardz-social'),
            'desc'      => '',
            'default'   => '#ffffff',
            'type'      => 'color'
        );
        
        $this->fields['ss-border-width'] = array
        (
            'title'     => __('Border Width', 'cardz-social'),
            'default'   => '0 0 0 0',
            'type'      => 'rect'
        );
        
        $this->fields['ss-border-style'] = array
        (
            'title'     => __('Border Style', 'cardz-social'),
            'default'   => 'none',
            'type'      => 'select',
            'choices'   => array
            (
                'none'      => 'None',
                'solid'     => 'Solid',
                'dashed'    => 'Dashed'
            )
        );
    
        /* Design */
        
        $this->fields['ss-gutter'] = array
        (
            'title'     => __('Gutter', 'cardz-social'),
            'desc'      => '',
            'default'   => '10',   
            'type'      => 'size'
        );
        
        $this->fields['ss-skin'] = array
		(
			'title'		=> __('Skin', 'cardz-social'),
			'desc'		=> '',
			'default'	=> 'default',
			'type'		=> 'select',
			'choices'	=> array
            (
                'default'       => 'Default',
                'flat'          => 'Flat',
                'flat-drak'     => 'Flat Dark',
                'classic'       => 'Classic',
                'classic-flat'  => 'Classic Flat',
                'classic-foley' => 'Classic Foley',
                'bescombe'      => 'Bescombe',
                'buturuga'      => 'Buturuga',
                'flaty'         => 'Flaty',
                'green'         => 'Green',
                'glowy'         => 'Glowy',
                'square'        => 'Square',
                'madrid'        => 'Madrid',
                'cover'         => 'Cover',
                'cherry'        => 'Cherry',
                'fiasco'        => 'Fiasco',
                'freedom'       => 'Freedom',
                'ice'           => 'Ice',
                'mint'          => 'Mint',
                'orange'        => 'Orange',
                'plastic'       => 'Plastic',
                'rainbow'       => 'Rainbow',
                'sweet'         => 'Sweet'
            )
		);
        
        $this->fields['ss-skin-filters'] = array
		(
			'title'		=> __('Filters Skin', 'cardz-social'),
			'desc'		=> '',
			'default'	=> 'default',
			'type'		=> 'select',
			'choices'	=> array
            (
                'default'       => 'Default',
                'chime'         => 'Chime',
                'choso'         => 'Choso',
                'fiasco'        => 'Fiasco'
            )
		);
        
        $this->fields['ss-skin-lightbox'] = array
		(
			'title'		=> __('Lightbox Skin', 'cardz-social'),
			'desc'		=> '',
			'default'	=> 'default',
			'type'		=> 'select',
			'choices'	=> array
            (
                'default'       => 'Default',
                'acri'          => 'Acri',
                'full'          => 'Full',
                'gallery'       => 'Gallery',
                'rainbow'       => 'Rainbow'
            )
		);
        
        $this->fields['ss-transition'] = array
		(
			'title'		=> __('Transition', 'cardz-social'),
			'desc'		=> '',
			'default'	=> 'none',
			'type'		=> 'select',
			'choices'	=> array
            (
                'none'              => 'None',
                'fade'              => 'Fade',
                'flip'              => 'Flip',
                'fly'               => 'Fly',
                'pop'               => 'Pop',
                'helix'             => 'Helix',
                'move-up'           => 'Move Up',
                'move-down'         => 'Move Down',
                'scale-up'          => 'Scale Up',
                'scale-down'        => 'Scale Down',
                'swipe-left'        => 'Swipe Left',
                'swipe-right'       => 'Swipe Right',
                'swipe-up-left'     => 'Swipe Up Left',
                'swipe-up-right'    => 'Swipe Up Right',
                'rotate-up'         => 'Rotate Up',
                'fall-perspective'  => 'Fall Perspective',
            )
		);
        
        $this->fields['ss-share'] = array
		(
			'title'		=> __('Share Type', 'cardz-social'),
			'default'	=> 'window',
			'type'		=> 'select',
			'choices'	=> array
            (
                'none'              => 'None',
                'window'            => 'Window',
                'page'              => 'Page'
            )
		);
        
        $this->fields['ss-items-per-page'] = array
        (
            'title'     => __('Items per page', 'cardz-social'),
            'default'   => '10',
            'type'      => 'text'
        );
        
        $this->fields['ss-pagination-type'] = array
		(
			'title'		=> __('Pagination Type', 'cardz-social'),
			'default'	=> 'button',
			'type'		=> 'select',
			'choices'	=> array
            (
                'button'    => 'Button',
                'scroll'    => 'Scroll'
            )
		);
        
        $this->fields['ss-text-limit-type'] = array
		(
			'title'		=> __('Text Limit Type', 'cardz-social'),
			'default'	=> 'words',
			'type'		=> 'select',
			'choices'	=> array
            (
                'unlimited' => 'Unlimited',
                'words'     => 'Words',
                'chars'     => 'Chars'
            )
		);
        
        $this->fields['ss-text-limit'] = array
        (
            'title'     => __('Text limit', 'cardz-social'),
            'default'   => '200',
            'type'      => 'text'
        );
        
        $this->fields['ss-items-shadow'] = array
        (
            'title'     => __('Show Items Shadow', 'cardz-social'),
            'label'     => __('Show Items Shadow', 'cardz-social'),
            'desc'      => '',
            'default'   => true,
            'type'      => 'checkbox'
        );
        
        $this->fields['ss-filters'] = array
        (
            'title'     => __('Show filters toolbar', 'cardz-social'),
            'label'     => __('Show filters toolbar', 'cardz-social'),
            'desc'      => '',
            'default'   => true,
            'type'      => 'checkbox'
        );
        
        $this->fields['ss-lightbox'] = array
        (
            'title'     => __('Enable lightbox', 'cardz-social'),
            'label'     => __('Enable lightbox', 'cardz-social'),
            'desc'      => '',
            'default'   => true,
            'type'      => 'checkbox'
        );
        
        $this->fields['ss-responsive'] = array
        (
            'title'     => __('Responsive', 'cardz-social'),
            'label'     => __('Responsive', 'cardz-social'),
            'desc'      => '',
            'default'   => true,
            'type'      => 'checkbox'
        );
        
        $this->fields['ss-clickable-links'] = array
        (
            'title'     => __('Make links clickable', 'cardz-social'),
            'label'     => __('Make links clickable', 'cardz-social'),
            'desc'      => '',
            'default'   => true,
            'type'      => 'checkbox'
        );
        
        $this->fields['ss-hideifnoimage'] = array
        (
            'title'     => __('Hide if no image', 'cardz-social'),
            'label'     => __('Hide if no image', 'cardz-social'),
            'desc'      => '',
            'default'   => false,
            'type'      => 'checkbox'
        );
        
        $this->fields['ss-disable-for-small-screen'] = array
        (
            'title'     => __('Disable on small screen', 'cardz-social'),
            'label'     => __('Disable on small screen', 'cardz-social'),
            'desc'      => '',
            'default'   => false,
            'type'      => 'checkbox'
        );
        
        /* Networks & Posts */
        
        $this->fields['ss-networks'] = array
        (
            'title'     => __('Social networks', 'cardz-social'),
            'desc'      => '',
            'default'   => '',
            'type'      => 'networks',
            'networks'  => $this->available_networks
        );
        
        $this->fields['ss-custom-item'] = array
        (
            'title'     => __('Add Custom Post', 'cardz-social'),
            'default'   => __('Add Custom Post', 'cardz-social'),
            'type'      => 'button'
        );
        
        $this->fields['ss-moderate-posts'] = array
        (
            'title'     => __('Moderate Posts', 'cardz-social'),
            'default'   => __('Moderate Posts', 'cardz-social'),
            'type'      => 'button'
        );
        
        $this->fields['ss-order-by'] = array
		(
			'title'		=> __('Order by', 'cardz-social'),
			'default'	=> 'auto',
			'type'		=> 'select',
			'choices'	=> array
            (
                'auto'          => 'Auto',
                'network'       => 'Network',
                'title'         => 'Title',
                'created'       => 'Created',
                'author_name'   => 'Author Name',
                'message'       => 'Message'
            )
		);
        
        $this->fields['ss-order'] = array
		(
			'title'		=> __('Order', 'cardz-social'),
			'default'	=> 'desc',
			'type'		=> 'select',
			'choices'	=> array
            (
                'asc'       => 'Ascendent',
                'desc'      => 'Descendent',
                'rand'      => 'Random'
            )
		);
        
        $this->fields['ss-items-limit'] = array
        (
            'title'     => __('Limit', 'cardz-social'),
            'default'   => SS_DEFAULT_LIMIT,
            'type'      => 'number'
        );
        
        
        $this->fields['ss-css-data'] = array
        (
            'default'   => '',
            'type'      => 'hidden'
        );
        
        // Define groups.
        
        $this->groups['networks'] = array
        (
            '__title'           => __('Networks & Posts', 'cardz-social'),
            'ss-networks'       => $this->fields['ss-networks'],
            'ss-custom-item'    => $this->fields['ss-custom-item'],
            'ss-moderate-posts' => $this->fields['ss-moderate-posts'],
            
            'ss-order-by'       => $this->fields['ss-order-by'],
            'ss-order'          => $this->fields['ss-order'],
            'ss-items-limit'    => $this->fields['ss-items-limit']
        );
        
        $this->groups['element-properties'] = array
        (
            '__title'           => __('Element Properties', 'cardz-social'),
            'ss-el-width'       => $this->fields['ss-el-width'],
            'ss-el-height'      => $this->fields['ss-el-height'],
            'ss-el-position'    => $this->fields['ss-el-position'],
            'ss-el-margins'     => $this->fields['ss-el-margins'],
            'ss-el-paddings'    => $this->fields['ss-el-paddings'],
            'ss-font-family'    => $this->fields['ss-font-family'],
            'ss-font-size'      => $this->fields['ss-font-size'],
            'ss-font-color'     => $this->fields['ss-font-color'],
            'ss-background'     => $this->fields['ss-background'],
            'ss-text-align'     => $this->fields['ss-text-align'],
            
            'ss-border-color'   => $this->fields['ss-border-color'],
            'ss-border-width'   => $this->fields['ss-border-width'],
            'ss-border-style'   => $this->fields['ss-border-style'],
            
            // Store CSS data for elements.
            'ss-css-data'       => $this->fields['ss-css-data']
        );
        
        $this->groups['design'] = array
        (
            '__title'                       => __('Design', 'cardz-social'),
            'ss-gutter'                     => $this->fields['ss-gutter'],
            'ss-skin'                       => $this->fields['ss-skin'],
            'ss-skin-filters'               => $this->fields['ss-skin-filters'],
            'ss-skin-lightbox'              => $this->fields['ss-skin-lightbox'],
            'ss-transition'                 => $this->fields['ss-transition'],
            
            'ss-share'                      => $this->fields['ss-share'],
            'ss-items-per-page'             => $this->fields['ss-items-per-page'],
            'ss-pagination-type'            => $this->fields['ss-pagination-type'],
            
            'ss-text-limit-type'            => $this->fields['ss-text-limit-type'],
            'ss-text-limit'                 => $this->fields['ss-text-limit'],
            
            'ss-items-shadow'               => $this->fields['ss-items-shadow'],
            'ss-filters'                    => $this->fields['ss-filters'],
            'ss-lightbox'                   => $this->fields['ss-lightbox'],
            'ss-responsive'                 => $this->fields['ss-responsive'],
            'ss-clickable-links'            => $this->fields['ss-clickable-links'],
            'ss-hideifnoimage'              => $this->fields['ss-hideifnoimage'],
            'ss-disable-for-small-screen'   => $this->fields['ss-disable-for-small-screen']
        );
        
        $this->options = new SS_Admin_Options();
        
        $this->options->set_fields_array($this->fields);
    }
}