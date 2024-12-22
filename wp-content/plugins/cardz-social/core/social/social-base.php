<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Base class for social requests.
 */
class SS_Social_Base
{
    /**
     *  User Agent string to send to the server.
     *
     *  @const string
     */
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36';

    /**
     *  Init
     */
    public function __construct()
    {
    }
    
    /**
     *  Request data from URL.
     *
     *  @param string $url The URL from which to get the data.
     *
     *  @retrun array Returns an array of data.
     */
    protected function request_data($url)
    {
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        
        $result = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE );
        $error = curl_error($curl);
        
        curl_close($curl);
        
        try
        {
            if (!empty($error) || $http_code != 200)
            {
                $content = @file_get_contents(SS_CROOT . '/ss_cache/log.czl');
            
                @file_put_contents(SS_CROOT . '/ss_cache/log.czl', $content . PHP_EOL . print_r(array('result' => $result, 'error' => $error, 'url' => $url), true));
            }
        }
        catch (Exception $ex)
        {
            
        }
        
        return array('result' => $result, 'error' => $error, 'url' => $url);
    }
}