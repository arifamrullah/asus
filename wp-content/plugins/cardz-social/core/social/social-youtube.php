<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for YouTube requests.
 */
class SS_Social_YouTube extends SS_Social_Base
{
    /**
     *  API Key.
     *
     *  @var string
     */
    private $api_key = '';

    /**
     *  Init
     */
    public function __construct()
    {
        $this->api_key = trim(get_option('ss-yb-api-key'));
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
        
        foreach ($data->items as $item)
        {
            $item_data = array
            (
                'network'           => 'youtube',
                'id'                => $item->id,
                'created'           => $item->snippet->publishedAt,
                'author_link'       => 'https://www.youtube.com/channel/' . $item->snippet->channelId,
                'author_picture'    => $this->get_user_thumb($item->snippet->channelId),
                'author_name'       => $item->snippet->channelTitle,
                'message'           => $item->snippet->title,
                'description'       => ($item->snippet->description) ? $item->snippet->description : '',
                'link'              => 'https://www.youtube.com/watch?v=' . $item->snippet->resourceId->videoId,
                'attachment'        => '',
                'video_source'      => 'https://www.youtube.com/embed/' . $item->snippet->resourceId->videoId
            );
            
            if (!empty($item->snippet->thumbnails))
            {
                // Try to get the largest version.
                if (!empty($item->snippet->thumbnails->maxres))
                {
                    $item_data['attachment'] = $item->snippet->thumbnails->maxres->url;
                }
                else if (!empty($item->snippet->thumbnails->standard))
                {
                    $item_data['attachment'] = $item->snippet->thumbnails->standard->url;
                }
                else if (!empty($item->snippet->thumbnails->high))
                {
                    $item_data['attachment'] = $item->snippet->thumbnails->high->url;
                }
                else if (!empty($item->snippet->thumbnails->medium))
                {
                    $item_data['attachment'] = $item->snippet->thumbnails->medium->url;
                }
                else if (!empty($item->snippet->thumbnails->default))
                {
                    $item_data['attachment'] = $item->snippet->thumbnails->default->url;
                }
            }
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Get user thumbnail.
     *
     *  @param string $user_id The user ID for which to get the thumbnail.
     *
     *  @return string The thumbnail url.
     */
    private function get_user_thumb($user_id)
    {
        $result = $this->request_data("https://www.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails&id={$user_id}&key={$this->api_key}");
        $data = json_decode($result['result']);
        
        if (isset($data->items[0]->snippet->thumbnails))
        {
            if (isset($data->items[0]->snippet->thumbnails->default))
            {
                return $data->items[0]->snippet->thumbnails->default->url;
            }
            else if (isset($data->items[0]->snippet->thumbnails->medium))
            {
                return $data->items[0]->snippet->thumbnails->medium->url;
            }
            else if (isset($data->items[0]->snippet->thumbnails->high))
            {
                return $data->items[0]->snippet->thumbnails->high->url;
            }
        }
        
        return '';
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
    private function get_url($network_id, $feed_type = 'channel', $limit = 30)
    {
        $query = urlencode($network_id);
    
        switch ($feed_type)
        {
            case 'playlist':
                break;
                
            case 'channel':
                $result = $this->request_data("https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails&forUsername={$network_id}&maxResults={$limit}&key={$this->api_key}");
                $data = json_decode($result['result']);
                
                $playlist_id = (isset($data->items[0])) ? $data->items[0]->contentDetails->relatedPlaylists->uploads : '';
                
                return "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults={$limit}&playlistId={$playlist_id}&key={$this->api_key}";
                
            case 'search':
                return "https://www.googleapis.com/youtube/v3/search?videoDefinition=high&order=viewCount&part=snippet&q={$query}&type=video&key={$this->api_key}";
        }
        
        return "https://www.googleapis.com/youtube/v3/search?videoDefinition=high&order=viewCount&part=snippet&q={$query}&type=video&key={$this->api_key}";
    }
}