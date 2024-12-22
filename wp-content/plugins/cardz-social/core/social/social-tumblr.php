<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Tumblr requests.
 */
class SS_Social_Tumblr extends SS_Social_Base
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
        $url = $this->get_url(trim($info['network-id']), $limit);
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data))
        {
            return array();
        }
        
        $items = array();
        
        foreach ($data->posts as $item)
        {
            $item_data = array
            (
                'network'           => 'tumblr',
                'id'                => $item->id,
                'created'           => $item->date,
                'author_link'       => 'http://' . $item->id . '.tumblr.com',
                'author_picture'    => '',
                'author_name'       => $data->tumblelog->title,
                'message'           => (!empty($item->{$item->type . '-caption'})) ? $item->{$item->type . '-caption'} : '',
                'description'       => (!empty($item->{$item->type . '-caption'})) ? $item->{$item->type . '-caption'} : '',
                'link'              => $item->url,
                'attachment'        => ''
            );
            
            if ($item->type === 'photo')
            {
                $item_data['attachment'] = $item->{'photo-url-250'};
            }
            
            if (!empty($item->{'video-source'}))
            {
                $video_source = $item->{'video-source'};
                
                if (strpos($video_source, 'vine.') !== false)
                {
                    $item_data['video_source'] = $video_source . '/embed/simple';
                }
                else if (strpos($video_source, 'youtube') !== false)
                {
                    $item_data['video_source'] = preg_replace('/^.*(youtu.be\/|v\/|embed\/|watch\?|youtube.com\/user\/[^#]*#([^\/]*?\/)*)\??v?=?([^#\&\?]*).*/', 'http://www.youtube.com/embed/$3?fs=1&amp;rel=0', $video_source);
                }
            }
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Generate the link.
     *
     *  @param string $id Network user.
     *  @param number $limit The nummber of posts.
     *
     *  @return string Returns the url.
     */
    protected function get_url($id, $limit = 30)
    {
        return "http://{$id}.tumblr.com/api/read/json?debug=1&num={$limit}";
    }
}