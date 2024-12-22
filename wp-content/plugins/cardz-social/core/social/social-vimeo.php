<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Vimeo requests.
 */
class SS_Social_Vimeo extends SS_Social_Base
{
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
    public function request($info, $limit = 30)
    {
        $url = $this->get_url(trim($info['network-id']), $info['feed-type']);
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data))
        {
            return array();
        }
        
        $items = array();
        
        foreach ($data as $item)
        {
            $item_data = array
            (
                'network'           => 'vimeo',
                'id'                => $item->id,
                'created'           => $item->upload_date,
                'author_link'       => $item->user_url,
                'author_picture'    => $item->user_portrait_medium,
                'author_name'       => $item->user_name,
                'message'           => (!empty($item->title)) ? $item->title : '',
                'description'       => (!empty($item->description)) ? $item->description : '',
                'link'              => $item->url,
                'attachment'        => $item->thumbnail_large
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
    protected function get_url($id, $feed_type = 'page')
    {
        switch ($feed_type)
        {
            case 'own':
                return "https://vimeo.com/api/v2/{$id}/videos.json";
                
            case 'likes':
                return "https://vimeo.com/api/v2/{$id}/likes.json";
                
            case 'channel':
                return "http://vimeo.com/api/v2/channel/{$id}/videos.json";
                
            case 'group':
                return "http://vimeo.com/api/v2/group/{$id}/videos.json";
                
            case 'album':
                return "http://vimeo.com/api/v2/albums/{$id}/videos.json";
        }
        
        return "https://vimeo.com/api/v2/{$id}/videos.json";
    }
}