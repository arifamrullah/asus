<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for SoundCloud requests.
 */
class SS_Social_SoundCloud extends SS_Social_Base
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
        $network_id = trim($info['network-id']);
        $api_key = trim(get_option('ss-sc-api-key'));
        
        $url = $this->get_url($network_id, $api_key);
        
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
                'network'           => 'soundcloud',
                'id'                => $item->id,
                'created'           => $item->created_at,
                'author_link'       => $item->user->permalink_url,
                'author_picture'    => $item->user->avatar_url,
                'author_name'       => $item->user->username,
                'message'           => (!empty($item->title)) ? $item->title : '',
                'description'       => (!empty($item->description)) ? $item->description : '',
                'link'              => $item->permalink_url,
                'attachment'        => (!empty($item->artwork_url)) ? $item->artwork_url : ''
            );
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Resolve the client ID url.
     *
     *  @param string $network_id The network id.
     *  @param string $api_key The API key.
     */
    protected function get_url($network_id, $api_key)
    {
        $url = "http://api.soundcloud.com/resolve.json?url=https://soundcloud.com/{$network_id}/tracks&client_id={$api_key}";
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (!is_object($data) || empty($data->location))
        {
            return '';
        }
        
        return $data->location;
    }
}