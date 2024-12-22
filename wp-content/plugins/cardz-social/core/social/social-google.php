<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Google+ requests.
 */
class SS_Social_Google extends SS_Social_Base
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
    
        $api_key = trim(get_option('ss-gp-api-key'));
        $url = $this->get_url(trim($info['network-id']), $api_key, $limit);
        
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
                'network'           => 'google',
                'id'                => $item->id,
                'created'           => $item->published,
                'author_link'       => $item->actor->url,
                'author_picture'    => $item->actor->image->url,
                'author_name'       => $item->actor->displayName,
                'message'           => $item->title,
                'description'       => (!empty($item->description)) ? $item->description : '',
                'link'              => $item->url,
                'attachment'        => ''
            );
            
            if (!empty($item->object->attachments))
            {
                foreach ($item->object->attachments as $attachment)
                {
                    if (!empty($attachment->fullImage))
                    {
                        $item_data['attachment'] = $attachment->fullImage->url;
                    }
                    else
                    {
                        if ($attachment->objectType === 'album')
                        {
                            if (!empty($attachment->thumbnails))
                            {
                                if (!empty($attachment->thumbnails[0]->image))
                                {
                                    $item_data['attachment'] = $attachment->thumbnails[0]->image->url;
                                }
                            }
                        }
                    }
                }
            }
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Get the URL.
     *
     *  @param string $network_id The ID of the user for which we get the feed.
     *  @param string $api_key The API Key.
     *  @param number $limit [optional] The feed max items.
     *
     *  @return string Returns the URL part for the right API request.
     */
    private function get_url($network_id, $api_key, $limit = 30)
    {
        return "https://www.googleapis.com/plus/v1/people/{$network_id}/activities/public?key={$api_key}&maxResults={$limit}&prettyprint=false&fields=items(id,actor,object(attachments(displayName,fullImage,id,image,objectType,url),id,content,objectType,url),published,title,url)";
    }
}