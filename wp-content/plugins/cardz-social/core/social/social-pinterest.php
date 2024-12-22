<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Pinterest requests.
 */
class SS_Social_Pinterest extends SS_Social_Base
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
        $info = array_merge(array
        (
            'network-id'        => ''
        ), $info);
        
        $network_id = trim($info['network-id']);
        $type = (strpos($network_id, '/') !== false) ? 'boards' : 'users';
    
        $url = "https://api.pinterest.com/v3/pidgets/{$type}/{$network_id}/pins/";
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data) && $data->status !== 'success')
        {
            return array();
        }
        
        $items = array();
        
        foreach ($data->data->pins as $item)
        {
            $item_data = array
            (
                'network'           => 'pinterest',
                'id'                => $item->id,
                'created'           => $data->generated_at,
                'author_link'       => $data->data->user->profile_url,
                'author_picture'    => $data->data->user->image_small_url,
                'author_name'       => $data->data->user->full_name,
                'message'           => (!empty($item->description)) ? $item->description : '',
                'description'       => '',
                'link'              => $item->link,
                'attachment'        => ''
            );
            
            $highest_width = 0;
            
            // Get the highest image.
            foreach ($item->images as $image)
            {
                if ($image->width > $highest_width)
                {
                    $item_data['attachment'] = $image->url;
                    
                    $highest_width = $image->width;
                }
            }
            
            $items[] = $item_data;
        }
        
        return $items;
    }
}