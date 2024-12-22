<?php if (!defined('ABSPATH')) { exit; }

require_once(SS_PROOT . '/libs/tmhOAuth/tmhOAuth.php');

/**
 *  Class for twitter requests.
 */
class SS_Social_Twitter extends SS_Social_Base
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
            'network-id'        => '',
            'feed-type'         => '',
            'hashtag'           => '',
            'ignore-retweets'   => '',
            'ignore-replies'    => '',
            'list-name'         => ''
        ), $info);
        
        $info['network-id'] = trim($info['network-id']);
    
        $tmhOAuth = new tmhOAuth(array
        (
            'consumer_key'      => trim(get_option('ss-tw-api-key')),
            'consumer_secret'   => trim(get_option('ss-tw-api-secret')),
            'token'             => trim(get_option('ss-tw-access-token')),
            'secret'            => trim(get_option('ss-tw-access-token-secret'))
        ));
        
        $response_code = $tmhOAuth->request('GET', $tmhOAuth->url($this->get_url($info['feed-type'])), $this->get_params($info['feed-type'], $info, $limit));
        
        if ($response_code === 200)
        {
            $tweets = json_decode($tmhOAuth->response['response']);
        
            if (isset($tweets->statuses))
            {
                $tweets = $tweets->statuses;
            }
            
            $items = array();
        
            foreach ($tweets as $tweet)
            {
                $items[] = array
                (
                    'network'           => 'twitter',
                    'id'                => $tweet->id_str,
                    'created'           => $tweet->created_at,
                    'author_link'       => 'https://twitter.com/' . $info['network-id'],
                    'author_picture'    => $tweet->user->profile_image_url_https,
                    'author_name'       => $tweet->user->screen_name,
                    'message'           => $tweet->text,
                    'description'       => '',
                    'link'              => 'https://twitter.com/' . $tweet->user->screen_name . '/status/' . $tweet->id_str,
                    'attachment'        => (!empty($tweet->entities->media[0]->media_url)) ? $tweet->entities->media[0]->media_url : ''
                );
            }
        
            return $items;
        }
        
        return array();
    }
    
    /**
     *  Get the URL by the given feed type.
     *
     *  @param string $feed_type The type of the feed.
     *
     *  @return string Returns the URL part for the right API request.
     */
    private function get_url($feed_type)
    {
        switch ($feed_type)
        {
            case 'home':
                return '1.1/statuses/home_timeline.json';
                
            case 'user':
                return '1.1/statuses/user_timeline.json';
                
            case 'user-list':
                return '1.1/lists/statuses.json';
                
            case 'user-fav':
                return '1.1/favorites/list.json';
                
            case 'search':
            default:
                return '1.1/search/tweets.json';
        }
    }
    
    /**
     *  Get the params for the given feed type.
     *
     *  @param string $feed_type The type of the feed.
     *
     *  @return string Returns an array of params the right API request.
     */
    private function get_params($feed_type, $info, $limit)
    {
        $params = array
        (
            'screen_name'   => $info['network-id'],
            'count'         => $limit,   // Limit.
            'include_entities'  => 'true'
        );
        
        if (!empty($info['ignore-replies']))
        {
            $params['exclude_replies'] = 'true';
        }
    
        if ($feed_type === 'user')
        {
            if (!empty($info['ignore-retweets']))
            {
                $params['include_rts'] = 'false';
            }
        }
        else if ($feed_type === 'user-list')
        {
            $params = array
            (
                'slug'              => $info['list-name'],
                'owner_screen_name' => $info['network-id'],
                'count'             => $limit   // Limit.
            );
            
            if (!empty($info['ignore-retweets']))
            {
                $params['include_rts'] = 'false';
            }
        }
        else
        {
            $params = array
            (
                'q'                 => urlencode($info['network-id']),
                'count'             => $limit,   // Limit.
                'result_type'       => 'mixed',
                'include_entities'  => 'true'
            );
        }
        
        return $params;
    }
}