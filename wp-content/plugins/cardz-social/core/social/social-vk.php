<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for VK requests.
 */
class SS_Social_VK extends SS_Social_Base
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
        $id = trim($info['network-id']);
    
        $url = "https://api.vk.com/method/wall.get?owner_id={$id}&count={$limit}&filter=owner&extended=1";
        
        $result = $this->request_data($url);
        
        $data = json_decode($result['result']);
        
        if (empty($data))
        {
            return array();
        }
        
        $items = array();
        
        foreach ($data->response->wall as $item)
        {
            if (is_numeric($item))
            {
                continue ;
            }
        
            $item_data = array
            (
                'network'           => 'vk',
                'id'                => $item->id,
                'created'           => $item->date * 1000,
                //'author_link'       => 'http://vk.com/id' . $item->to_id,
                'author_link'       => $this->get_author_link($data),
                'author_picture'    => $this->get_author_picture($data),
                'author_name'       => $this->get_author_name($data),
                'message'           => (!empty($item->text)) ? $item->text : '',
                'description'       => '',
                'link'              => '',
                'attachment'        => (!empty($item->attachment->photo)) ? $item->attachment->photo->src_big : ''
            );
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Get the author picture.
     *
     *  @param Array $data The original response from the API.
     *
     *  @return String Returns the url for the author picture.
     */
    private function get_author_picture($data)
    {
        if (!empty($data->response->profile))
        {
            return $data->response->profile[0]->photo;
        }
        else if (!empty($data->response->profiles))
        {
            return $data->response->profiles[0]->photo;
        }
        else if (!empty($data->response->groups))
        {
            return $data->response->groups[0]->photo;
        }
    }
    
    /**
     *  Get the author name.
     *
     *  @param Array $data The original response from the API.
     *
     *  @return String Returns the author name.
     */
    private function get_author_name($data)
    {
        if (!empty($data->response->profile))
        {
            return $data->response->profile[0]->first_name . ' ' . $data->response->profile[0]->last_name;
        }
        else if (!empty($data->response->profiles))
        {
            return $data->response->profiles[0]->first_name . ' ' . $data->response->profiles[0]->last_name;
        }
        else if (!empty($data->response->groups))
        {
            return $data->response->groups[0]->name;
        }
    }
    
    /**
     *  Get author link.
     *
     *  @param Array $data The original response from the API.
     *
     *  @return String Returns the author link.
     */
    private function get_author_link($data)
    {
        if (!empty($data->response->groups))
        {
            return 'http://vk.com/' . $data->response->groups[0]->screen_name;
        }
        
        return 'http://vk.com/id' . $item->to_id;
    }
}