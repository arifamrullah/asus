<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Vine requests.
 */
class SS_Social_Vine extends SS_Social_Base
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
        
        foreach ($data->data->records as $item)
        {
            $item_data = array
            (
                'network'           => 'vine',
                'id'                => $item->userId,
                'created'           => $item->created,
                'author_link'       => 'https://vine.co/u/' . $item->userId,
                'author_picture'    => $item->avatarUrl,
                'author_name'       => $item->username,
                'message'           => (!empty($item->description)) ? $item->description : '',
                'description'       => '',
                'link'              => $item->permalinkUrl,
                'attachment'        => '',
                'video_source'      => $item->videoUrl
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
        switch ($feed_type)
        {
            case 'user':
                $user_id = $this->get_user_id($id);
                return "https://api.vineapp.com/timelines/users/{$user_id}?page={$this->page}";
                
            case 'likes':
                $user_id = $this->get_user_id($id);
                return "https://api.vineapp.com/timelines/users/{$user_id}/likes?page={$this->page}";
                
            case 'hashtag':
                return "https://api.vineapp.com/timelines/tags/{$id}?page={$this->page}";
        }
        
        return "https://api.vineapp.com/timelines/users/{$id}?page={$this->page}";
    }
    
    /**
     *  Get the user ID.
     */
    private function get_user_id($network_id)
    {
        $url = "https://api.vineapp.com/users/search/{$network_id}";
        $request = wp_remote_get($url);
        $response = wp_remote_retrieve_body($request);
        
        $data = json_decode($response, false, 512, JSON_BIGINT_AS_STRING);
        
        if (is_object($data))
        {
            if (!empty($data->data->records[0]->userId))
            {
                return (string)$data->data->records[0]->userId;
            }
        }
        
        return $network_id;
    }
}