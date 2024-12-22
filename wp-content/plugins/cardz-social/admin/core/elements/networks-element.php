<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Networks element.
 */
class SS_Networks_Element extends SS_Base_Element
{
	/**
	 *	Constructor. Set options.
	 *
	 *	@param $options	Optional. Element options.
	 */
	public function __construct($options = array())
	{
		parent::__construct(array(), $options);
	}
	
	/**
	 *	Set value.
	 *
	 *	@param $value	The value to set.
	 */
	public function set_value($value)
	{
		$this->add_option('value', $value);
	}
	
	/**
	 *	Generate the HTML.
	 *
	 *	@return The generated HTML.
	 */
	public function generate()
	{
		$name = $this->get_option('name');
		$value = str_replace('\'', '&#39;', $this->get_option('value'));
		
		$this->html = <<<HTML
		<div id="$name" class="ss-networks" data-value='$value'>
			<div class="ss-networks-toolbar">
				<span class="ss-networks-action-add">+</span>
                {$this->generate_network_list()}
			</div>
			{$this->generate_filters_html()}
			<div class="ss-networks-editor">
				<div class="ss-networks-editor-toolbar">
					<span class="ss-networks-action-save">save</span>
					<span class="ss-networks-action-cancel">cancel</span>
				</div>
				<div class="ss-networks-editor-subpanel ss-networks-editor-page-type" data-type="list">
					<ul>
						<li data-value="page">Page</li>
						<li data-value="post">Post</li>
						<li data-value="home">Home Page</li>
						<li data-value="search">Search Page</li>
						<li data-value="archive">Archive Page</li>
					</ul>
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-post-type" data-type="list">
					{$this->generate_post_type_list()}
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-post" data-type="list">
					{$this->generate_post_list()}
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-page-template" data-type="list">
					{$this->generate_page_template_list()}
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-category" data-type="list">
					{$this->generate_categories_list()}
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-url" data-type="url">
					<p class="description">Filter popup by URI.</p>
					<input type="text" class="ss-networks-editor-url-field" />
					<input type="checkbox" id="ss-url-regex" class="ss-networks-editor-use-regex" /><label name="ss-url-regex">Use RegEx</label>
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-refferer" data-type="url">
					<p class="description">Filter popup by reffere URI.</p>
					<input type="text" class="ss-networks-editor-url-field" />
					<input type="checkbox" id="ss-refferer-regex" class="ss-networks-editor-use-regex" /><label name="ss-refferer-regex">Use RegEx</label>
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-user-role" data-type="list">
					{$this->generate_user_roles_list()}
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-user-status" data-type="list">
					<ul>
						<li data-value="logged-in">Logged In</li>
						<li data-value="logged-out">Logged Out</li>
					</ul>
				</div>
				
				<div class="ss-networks-editor-subpanel ss-networks-editor-device" data-type="list">
					<ul>
						<li data-value="desktop">Desktop</li>
						<li data-value="mobile">Mobile</li>
					</ul>
				</div>
				<div class="ss-networks-editor-subpanel ss-networks-editor-between-dates" data-type="dates">
					<input type="text" class="ss-from-date" readonly="true" />
					<input type="text" class="ss-to-date" readonly="true" />
					<div class="ss-networks-calendar ss-calendar"></div>
				</div>

			</div>
			<input type="hidden" name="$name" class="ss-networks-data" />
		</div>
HTML;
		
		return $this->html;
	}
	
    /**
     *  Generate network list.
     *
     *	@return HTML list containing all the available networks.
     */
    private function generate_network_list()
    {
        $html = '<ul class="ss-networks-type">';
        $networks = $this->get_option('networks');
        
        foreach ($networks as $name => $title)
        {
            $html .= '	<li data-value="' . $name .'">'. $title .'</li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }
    
	/**
	 *	Generate post types list HTML.
	 *
	 *	@return HTML list containing all the available post types.
	 */
	private function generate_post_type_list()
	{
		$html = '<ul>';
		$post_types = get_post_types();
		
		foreach ($post_types as $post_type)
		{
			$html .= '	<li data-value="' . $post_type .'">'. $post_type .'</li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}
	
	/**
	 *	Generate post list HTML.
	 *
	 *	@return HTML list containing all the available posts.
	 */
	private function generate_post_list()
	{
		$html = '<ul>';
		$posts = get_posts();
		
		foreach ($posts as $post)
		{
			$html .= '	<li data-value="' . $post->post_name .'">'. $post->post_title .'</li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}
	
	/**
	 *	Generate page template list HTML.
	 *
	 *	@return HTML list containing all the available page templates.
	 */
	private function generate_page_template_list()
	{
		$html = '<ul>';
		$templates = get_page_templates();
		
		foreach ($templates as $name => $template)
		{
			$html .= '	<li data-value="' . $template .'">'. $name .'</li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}
	
	/**
	 *	Generate categories list HTML.
	 *
	 *	@return HTML list containing all the available categories.
	 */
	private function generate_categories_list()
	{
		$html = '<ul>';
		$categories = get_categories();
		
		foreach ($categories as $category)
		{
			$html .= '	<li data-value="' . $category->slug .'">'. $category->name .'</li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}
	
	/**
	 *	Generate user roles list HTML.
	 *
	 *	@return HTML list containing all the available user roles.
	 */
	private function generate_user_roles_list()
	{
		$html = '<ul>';
		$roles = get_editable_roles();
		
		foreach ($roles as $value => $role)
		{
			$html .= '	<li data-value="' . $value .'">'. $role['name'] .'</li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}
	
	/**
	 *	Generate filters list HTML. From the given value.
	 *
	 *	@return HTML list containing the filters.
	 */
	private function generate_filters_html()
	{
		$html = '<ul class="ss-networks-list">';
		/*$value = $this->get_option('value');
		
		if ($value == '')
		{
			return '';
		}*/
		
		/*$filters = json_decode($value);
		
		//SS_trace($filters);
		
		foreach ($filters as $filter)
		{
			$html .= <<<HTML
				<li data-value="{$filter->value}" data-type="{$filter->type}" data-regex="{$filter->regex}">
					<div class="ss-filter">
						<span class="ss-mode" data-value="{$filter->mode}">{$filter->mode}</span>
						<span class="ss-text" data-value="{$filter->type}">{$filter->title}</span>
						<div class="ss-actions">
							<span class="ss-networks-action-add-subitem"></span>
							<span class="ss-networks-action-edit" data-value="{$filter->type}"></span>
							<span class="ss-networks-action-remove"></span>
						</div>
					</div>
				</li>
HTML;
		}*/
		
		$html .= '</ul>';
		
		return $html;
	}
}