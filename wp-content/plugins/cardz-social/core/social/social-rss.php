<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Class for RSS requests.
 */
class SS_Social_RSS extends SS_Social_Base
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
    public function request($info, $limit = 30)
    {
        $url = $this->url . urlencode(trim($info['network-id']));
        
        $result = $this->request_data($url);
        $data = json_decode($result['result']);
        
        if (empty($data))
        {
            return array();
        }
        
        $feed = $data->responseData->feed;
        
        $items = array();
        
        foreach ($feed->entries as $item)
        {
            $item_data = array
            (
                'network'           => 'rss',
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
}