<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for facebook requests.
 */
class SS_Social_Facebook extends SS_Social_Base
{
    /**
     *  Access token.
     */
    protected $access_token = '';

    /**
     *  Init
     */
    public function __construct()
    {
        $app_id = trim(get_option('ss-fb-app-id', ''));
        $app_secret = trim(get_option('ss-fb-app-secret', ''));
        
        $this->access_token = "{$app_id}|{$app_secret}";
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
            'feed-type'     => '',
            'hashtag'       => ''
        ), $info);
    
        $url = $this->get_url(trim($info['network-id']), $info['feed-type'], $items_limit);
        
        /*$cache_key = $info['network-id'] . $info['feed-type'] . '-facebook';
        
        if (CardZStream()->cache->is_time_to_update($cache_key))
        {
            $result = $this->request_data($url);
            
            CardZStream()->cache[$cache_key] = $result;
        }
        else
        {
            $result = CardZStream()->cache[$cache_key];
        }*/
        
        $result = $this->request_data($url);
        
        $data = json_decode($result['result']);
        
        if (empty($data))
        {
            return array();
        }
        
        $items = array();
        
        foreach ($data->data as $item)
        {
            $attachment = '';
            $message = (!empty($item->message)) ? $item->message : ((!empty($item->story)) ? $item->story : '');
        
            if (!empty($info['hashtag']))
            {
                $hashtag = (strpos($info['hashtag'], '#') !== false) ? trim(str_replace('#', '', $info['hashtag'])) :  trim($info['hashtag']);
                
                if (!preg_match('/\B#('. $hashtag .')/', $message))
                {
                    continue ;
                }
            }
        
            if (!empty($item->picture))
            {
                // Get the largest image.
                if (strpos($item->picture, '_b.') !== false)
                {
                    $attachment = $item->picture;
                }
                else if (strpos($item->picture, 'safe_image.php') !== false)
                {
                    $attachment = $this->get_external_image_url($item->picture, 'url');
                }
                else if (strpos($item->picture, 'app_full_proxy.php') !== false)
                {
                    $attachment = $this->get_external_image_url($item->picture, 'src');
                }
                else if (!empty($item->object_id))
                {
                    $attachment = 'https://graph.facebook.com/' . $item->object_id . '/picture/?width=800';
                }
                else if (!empty($item->id))
                {
                    $attachment = 'https://graph.facebook.com/' . str_replace($item->from->id + '_', '', $item->id) . '/picture/?width=800';
                }
                else
                {
                    $attachment = $item.picture;
                }
            }
            
            $items[] = array
            (
                'network'           => 'facebook',
                'id'                => $item->id,
                'created'           => $item->created_time,
                'author_link'       => 'http://facebook.com/' . $item->from->id,
                'author_picture'    => 'https://graph.facebook.com/' . $item->from->id . '/picture',
                'author_name'       => $item->from->name,
                'message'           => $message,
                'description'       => (!empty($item->description)) ? $item->description : '',
                'link'              => (!empty($item->link)) ? $item->link : 'http://facebook.com/' . $item->from->id,
                'attachment'        => $attachment
            );
        }
        
        return $items;
    }
    
    /**
     *  Generate the link.
     *
     *  @param string feed_type The type of the feed.
     *
     *  @return string Returns the url.
     */
    protected function get_url($id, $feed_type = 'page', $limit = 30)
    {
        switch ($feed_type)
        {
            case 'home':
                return "https://graph.facebook.com/me/home?limit={$limit}&fields=id,object_id,created_time,from,message,story,description,link,picture&access_token={$this->access_token}";
            
            case 'page':
            case 'user':
                return "https://graph.facebook.com/{$id}/posts?limit={$limit}&fields=id,object_id,created_time,from,message,story,description,link,picture&access_token={$this->access_token}";
                
            case 'group':
                return "https://graph.facebook.com/{$id}/feed?limit={$limit}&fields=id,object_id,created_time,from,message,story,description,link,picture&access_token={$this->access_token}";
        }
        
        return "https://graph.facebook.com/me/home?limit={$limit}&fields=id,object_id,created_time,from,message,story,description,link,picture&access_token={$this->access_token}";
    }
    
    /**
     *  Get external image URL.
     *
     *  @param url string The original image URL.
     *  @param param string The parameter in the URL.
     *
     *  @return string Returns the image URL.
     */
    private function get_external_image_url($url, $param)
    {
        $url = explode($param . '=', urldecode($url));
        
        if (strpos($url[1], 'fbcdn-sphotos') === false)
        {
            $url = explode('&', $url[1]);
            $url = $url[0];
        }
        
        return $url;
    }
}