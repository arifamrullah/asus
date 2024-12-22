<?php if (!defined('ABSPATH')) { exit; }

/**
 *  CardZ stream widget.
 *
 *  @since 1.0.12
 */
class SS_Stream_Widget extends WP_Widget
{
	/**
	 *	Options.
	 */
	public $options = null;

	/**
	 *	Constructor. Initialize and set widget.
	 */
	public function __construct()
	{
		$widget_data = array
		(
            'name'              => 'ss-stream-widget',
            'title'             => __('CardZ Stream Widget', 'cardz-social'),
            'widget_options'    => array
            (
                'classname'     => 'cardz-stream-widget',
                'description'   => __('Create a Cardz stream', 'cardz-social')
            ),
            'control_options'   => array
            (
                'width'         => 300
            )
		);
		
		$this->WP_Widget($widget_data['name'], $widget_data['title'], $widget_data['widget_options'], $widget_data['control_options']);
		
		add_action('init', array($this, 'get_fields'));
	}
	
	/**
	 *	Sanitize widget form values as they are saved.
	 *
	 *	@param $new_instance
	 *	@param $old_instance
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		foreach ($this->fields as $key => $value)
		{
			$instance[$key] = $new_instance[$key];
		}
        
		return $instance;
	}
	
	/**
	 *	Back-end widget form (Options form).
	 *
	 *	@param $instance
	 */
	public function form($instance)
	{
		$defaults = array();
		
		foreach ($this->fields as $key => $value)
		{
			$defaults[$key] = $value['std'];
		}
        
		$instance = wp_parse_args((array)$instance, $defaults);
		
		foreach ($this->fields as $key => $field)
		{	
		?>
			<p>
				<label for="<?php echo $this->get_field_id($key); ?>"><?php echo $field['title']; ?></label>
				<?php
					$value = $instance[$key];
					$this->options->display_field($value, $key);
				?>
			</p>
		<?php
		}
	}
	
	/**
	 *	Set fields array.
	 */
	public function get_fields()
	{
        $this->fields['ss-use'] = array
        (
            'title'     => __('Stream slug or stream ID', 'cardz-social'),
            'default'   => '',
            'type'      => 'text',
            'id'        => $this->get_field_id('ss-use'),
            'name'      => $this->get_field_id('ss-use')
        );
		
		$this->options = new SS_Admin_Options();
		
		$this->options->set_fields_array($this->fields);
	}
	
	/**
	 *	Front-end display of widget.
	 *
	 *	@param $args
	 *	@param $instance
	 */
	public function widget($args, $instance)
	{
		extract($args);
		
		echo $before_widget;
        
        echo do_shortcode('[cardz use="' . esc_attr($instance['ss-use']) . '" /]');
		
		echo $after_widget;
	}
}

// Register widget.
add_action('widgets_init', create_function('', 'return register_widget("SS_Stream_Widget");'));
