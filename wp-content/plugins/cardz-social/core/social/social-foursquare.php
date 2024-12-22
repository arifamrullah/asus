<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Foursquare requests.
 */
class SS_Social_Foursquare extends SS_Social_Base
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
    public function request($info, $items_limit = 30)
    {
        $url = $this->get_url(trim($info['network-id']), $info['feed-type'], $items_limit);
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data) || empty($data->responseData))
        {
            return array();
        }
        
        $items = array();
        
        $feed = $data->responseData->feed;
        
        foreach ($feed->entries as $item)
        {
            $item_data = array
            (
                'network'           => 'foursquare',
                'id'                => $item->id,
                'created'           => $item->publishedDate,
                'author_link'       => $feed->link,
                'author_picture'    => '',
                'author_name'       => $feed->title,
                'message'           => (!empty($item->contentSnippet)) ? $item->contentSnippet : '',
                'description'       => '',
                'link'              => $item->link,
                'attachment'        => ''
            );
            
            // Get the URL of the image.
            if (preg_match_all('/<img.*?src=["\'](.*?)["\']/', $item->content, $match) !== false)
            {
                $item_data['attachment'] = $match[1][0];
            }
            
            $items[] = $item_data;
        }
        
        return $items;
    }
    
    /**
     *  Generate the link.
     *
     *  @param string $id Network user.
     *  @param string $feed_type The type of the feed.
     *  @param number $limit Feed limit.
     *
     *  @return string Returns the url.
     */
    protected function get_url($id, $feed_type = 'page', $limit = 30)
    {
        return "http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num={$limit}&q=https://feeds.foursquare.com/history/{$id}.rss";
    }
}