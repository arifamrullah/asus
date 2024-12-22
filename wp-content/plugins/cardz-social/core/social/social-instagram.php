<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Instagram requests.
 */
class SS_Social_Instagram extends SS_Social_Base
{
    /**
     *  Access token.
     *
     *  @var string
     */
    private $access_token = '';

    /**
     *  Init
     */
    public function __construct()
    {
        $this->access_token = trim(get_option('ss-is-access-token'));
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
        $info = array_merge(array
        (
            'network-id'        => '',
            'feed-type'         => ''
        ), $info);
    
        $url = $this->get_url(trim($info['network-id']), $info['feed-type'], $limit);
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data))
        {
            return array();
        }
        
        $items = array();
        
        foreach ($data->data as $item)
        {
            $item_data = array
            (
                'network'           => 'instagram',
                'id'                => $item->id,
                'created'           => date(DATE_ATOM, $item->created_time),
                'author_link'       => 'http://instagram.com/' . $item->user->username,
                'author_picture'    => $item->user->profile_picture,
                'author_name'       => $item->user->full_name,
                'message'           => (!empty($item->caption)) ? $item->caption->text : '',
                'description'       => '',
                'link'              => $item->link,
                'attachment'        => $item->images->standard_resolution->url
            );
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Get the URL.
     *
     *  @param string $network_id The ID of the user for which we get the feed.
     *  @param string $feed_type The feed type.
     *  @param number $limit [optional] The feed max items.
     *
     *  @return string Returns the URL part for the right API request.
     */
    private function get_url($network_id, $feed_type = 'home', $limit = 30)
    {
        switch ($feed_type)
        {
            case 'home':
                return "https://api.instagram.com/v1/users/self/feed?access_token={$this->access_token}&count={$limit}";
                
            case 'user':
                $user_id = $this->get_user_id($network_id);
                return "https://api.instagram.com/v1/users/{$user_id}/media/recent/?access_token={$this->access_token}&count={$limit}";
            
            case 'popular':
                return "https://api.instagram.com/v1/media/popular?access_token={$this->access_token}&count={$limit}";
                
            case 'likes':
                return "https://api.instagram.com/v1/users/self/media/liked?access_token={$this->access_token}&count={$limit}";
                
            case 'search':
                return "https://api.instagram.com/v1/tags/{$network_id}/media/recent?access_token={$this->access_token}&count={$limit}";
        }
        
        return "https://api.instagram.com/v1/users/self/feed?access_token={$this->access_token}&count={$limit}";
    }
    
    /**
     *  Get the user ID.
     */
    private function get_user_id($network_id)
    {
        $url = "https://api.instagram.com/v1/users/search?q={$network_id}&access_token={$this->access_token}";
        $request = wp_remote_get($url);
        $response = wp_remote_retrieve_body($request);
        
        $data = json_decode($response);
        
        if (!is_object($data) || empty($data->data))
        {
            return $network_id;
        }
        else
        {
            foreach ($data->data as $user)
            {
                if ($user->username == $network_id)
                {
                    return $user->id;
                }
            }
            
            return $network_id;
        }
    }
}