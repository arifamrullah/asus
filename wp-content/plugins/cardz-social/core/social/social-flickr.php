<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for Flickr requests.
 */
class SS_Social_Flickr extends SS_Social_Base
{
    /**
     *  RSS reader request URL.
     *
     *  @var string
     */
    private $url = 'http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=200&q=';

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
        $info = array_merge(array
        (
            'network-id'        => '',
            'feed-type'         => ''
        ), $info);
    
        $url = $this->url . urlencode($this->get_url(trim($info['network-id']), $info['feed-type']));
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data) || empty($data->responseData->feed))
        {
            return array();
        }
        
        $feed = $data->responseData->feed;
        
        $items = array();
        
        foreach ($feed->entries as $item)
        {
            $item_data = array
            (
                'network'           => 'flickr',
                'id'                => $item->id,
                'created'           => $item->publishedDate,
                'author_link'       => $feed->link,
                'author_picture'    => '',
                'author_name'       => $feed->title,
                'message'           => ($item->contentSnippet) ? $item->contentSnippet : '',
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
                return "https://api.flickr.com/services/feeds/photos_public.gne?id={$id}&lang=en-us&size=b&format=rss_200";
                
            case 'tag':
                return "https://api.flickr.com/services/feeds/photos_public.gne?tag={$id}&lang=en-us&size=b&format=rss_200";
        }
        
        return "https://api.flickr.com/services/feeds/photos_public.gne?id={$id}&lang=en-us&size=b&format=rss_200";
    }
}