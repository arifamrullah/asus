<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Dribbble requests.
 */
class SS_Social_Dribbble extends SS_Social_Base
{
    /**
     *  Page number.
     *
     *  @var number
     */
    protected $page = 1;

    /**
     *  Init
     */
    public function __construct()
    {
    }
    
    /**
	 *	Get data from social netowrk using the given options.
	 *
	 *	@return object Returns an array containing the items in a normalized version.
	 *	{
	 *		@type string network		The network name.
	 *		@type string id				The user or page id.
	 *		@type string created		The item created time.
	 *		@type string author_link	The author link.
	 *		@type string author_picture	The author picture.
	 *		@type string author_name	The author name.
	 *		@type string message		The item message.
	 *		@type string description	The item description.
	 *		@type string link			Item link.
	 *		@type string attachment		Atached image URL.
	 *	}
	 */
    public function request($info, $items_limit = 30)
    {
        $info = array_merge(array
        (
            'network-id'    => '',
            'feed-type'     => ''
        ), $info);
    
        $url = $this->get_url(trim($info['network-id']), $info['feed-type']);
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data))
        {
            return array();
        }
        
        $items = array();
        
        foreach ($data->shots as $item)
        {
            $item_data = array
            (
                'network'           => 'dribbble',
                'id'                => $item->id,
                'created'           => $item->created_at,
                'author_link'       => $item->player->url,
                'author_picture'    => (!empty($item->player->avatar_url)) ? $item->player->avatar_url : SS_DEFAULT_AVATAR,
                'author_name'       => $item->player->name,
                'message'           => (!empty($item->title)) ? $item->title : '',
                'description'       => (!empty($item->description)) ? $item->description : '',
                'link'              => $item->url,
                'attachment'        => (!empty($item->image_url)) ? $item->image_url : ''
            );
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Generate the link.
     *
     *  @param string Network user.
     *  @param string feed_type The type of the feed.
     *
     *  @return string Returns the url.
     */
    protected function get_url($id, $feed_type = 'user')
    {
        if ($feed_type === 'likes')
        {
            return "http://api.dribbble.com/players/{$id}/shots/likes?sort=recent&page={$this->page}";
        }
        
        return "http://api.dribbble.com/players/{$id}/shots?sort=recent&page={$this->page}";
    }
}