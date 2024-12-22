<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Filters element.
 *
 *	@since 3.0.1
 */
class SS_Filters_Element extends SS_Base_Element
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
		<div id="$name" class="sp-filters" data-value='$value'>
			<div class="sp-filters-toolbar">
				<span class="sp-filters-action-add">+</span>
			</div>
			{$this->generate_filters_html()}
			<div class="sp-filters-editor">
				<div class="sp-filters-editor-toolbar">
					<span class="sp-filters-action-save">save</span>
					<span class="sp-filters-action-cancel">cancel</span>
				</div>
				<div class="sp-filters-editor-subpanel sp-filters-editor-page-type" data-type="list">
					<ul>
						<li data-value="page">Page</li>
						<li data-value="post">Post</li>
						<li data-value="home">Home Page</li>
						<li data-value="search">Search Page</li>
						<li data-value="archive">Archive Page</li>
					</ul>
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-post-type" data-type="list">
					{$this->generate_post_type_list()}
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-post" data-type="list">
					{$this->generate_post_list()}
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-page-template" data-type="list">
					{$this->generate_page_template_list()}
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-category" data-type="list">
					{$this->generate_categories_list()}
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-url" data-type="url">
					<p class="description">Filter popup by URI.</p>
					<input type="text" class="sp-filters-editor-url-field" />
					<input type="checkbox" id="sp-url-regex" class="sp-filters-editor-use-regex" /><label name="sp-url-regex">Use RegEx</label>
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-refferer" data-type="url">
					<p class="description">Filter popup by reffere URI.</p>
					<input type="text" class="sp-filters-editor-url-field" />
					<input type="checkbox" id="sp-refferer-regex" class="sp-filters-editor-use-regex" /><label name="sp-refferer-regex">Use RegEx</label>
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-user-role" data-type="list">
					{$this->generate_user_roles_list()}
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-user-status" data-type="list">
					<ul>
						<li data-value="logged-in">Logged In</li>
						<li data-value="logged-out">Logged Out</li>
					</ul>
				</div>
				
				<div class="sp-filters-editor-subpanel sp-filters-editor-device" data-type="list">
					<ul>
						<li data-value="desktop">Desktop</li>
						<li data-value="mobile">Mobile</li>
					</ul>
				</div>
				<div class="sp-filters-editor-subpanel sp-filters-editor-between-dates" data-type="dates">
					<input type="text" class="sp-from-date" readonly="true" />
					<input type="text" class="sp-to-date" readonly="true" />
					<div class="sp-filters-calendar sp-calendar"></div>
				</div>

			</div>
			<input type="hidden" name="$name" class="sp-filters-data" />
		</div>
HTML;
		
		return $this->html;
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
		$html = '<ul class="sp-filters-list">';
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
					<div class="sp-filter">
						<span class="sp-mode" data-value="{$filter->mode}">{$filter->mode}</span>
						<span class="sp-text" data-value="{$filter->type}">{$filter->title}</span>
						<div class="sp-actions">
							<span class="sp-filters-action-add-subitem"></span>
							<span class="sp-filters-action-edit" data-value="{$filter->type}"></span>
							<span class="sp-filters-action-remove"></span>
						</div>
					</div>
				</li>
HTML;
		}*/
		
		$html .= '</ul>';
		
		return $html;
	}
}