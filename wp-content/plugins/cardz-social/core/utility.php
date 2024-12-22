<?php if (!defined('ABSPATH')) { exit; }

if (!function_exists('ss_request'))
{
    /**
     *  Get data from $_REQUEST variable, if the value doesn't exist, return false.
     *
     *  @param string $key  Key value.
     *  @param mixed $default [optional] Default value.
     *
     *  @return mixed Returns the data from the $_REQUEST variable.
     */
    function ss_request($key, $default = false)
    {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }
}

if (!function_exists('ss_get'))
{
    /**
     *  Get data from $_GET variable, if the value doesn't exist, return false.
     *
     *  @param string $key  Key value.
     *  @param mixed $default [optional] Default value.
     *
     *  @return mixed Returns the data from the $_GET variable.
     */
    function ss_get($key, $default = false)
    {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
}

if (!function_exists('ss_post'))
{
    /**
     *  Get data from $_POST variable, if the value doesn't exist, return false.
     *
     *  @param string $key  Key value.
     *  @param mixed $default [optional] Default value.
     *
     *  @return mixed Returns the data from the $_POST variable.
     */
    function ss_post($key, $default = false)
    {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
}

if (!function_exists('ss_get_post_by_slug'))
{
	/**
	 *	Get post by slug.
	 *
	 *	@param $slug	The post slug.
	 *	@param $attrs	[optional] Attributes for the get_posts function.
	 *
	 *	@return Post object on success, null on failure.
	 */
	function ss_get_post_by_slug($slug, $attrs = array())
	{
		$attrs = array('name' => $slug) + $attrs;
		
		$posts = get_posts($attrs);
		
		if (!empty($posts))
		{
			return $posts[0];
		}
		
		return null;
	}
}

if (!function_exists('ss_get_post_id'))
{
	/**
	 *	Get post ID by slug.
	 *
	 *	@param $slug	The post slug.
	 *	@param $attrs	[optional] Attributes for the get_posts function.
	 *
	 *	@return Post id on success, false on failure.
	 */
	function ss_get_post_id($slug, $attrs = array())
	{
		$post = ss_get_post_by_slug($slug, $attrs);
		
		if ($post !== null)
		{
			return $post->ID;
		}
		
		return false;
	}
}

if (!function_exists('ss_get_post_slug'))
{
	/**
	 *	Get the slug of a post by ID.
	 *
	 *	@param $id		The ID of the post.
	 *	@param $attrs	[optional] Attributes for the get_posts function.
	 *
	 *	@return Returns the slug of the post on success, false on failure.
	 */
	function ss_get_post_slug($id, $attrs = array())
	{
		$posts = get_posts($attrs);
		
		foreach ($posts as $post)
		{
			if ($post->ID == $id)
			{
				return $post->post_name;
			}
		}
		
		return false;
	}
}

if (!function_exists('ss_get_current_url'))
{
	/**
	 *	Get current URL.
	 *
	 *	@return The current url.
	 */
	function ss_get_current_url()
	{
		$url = 'http' . ((isset($_SERVER['https']) && $_SERVER['https'] === 'on') ? 's' : '') . '://';
		
		if ($_SERVER['SERVER_PORT'] != '80')
		{
			$url .= $_SERVER['SERVER_NAME'] . ':' .$_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		}
		else
		{
			$url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}
		
		return $url;
	}
}

if (!function_exists('ss_get_file'))
{
	/**
	 *	Get file content.
	 *
	 *	@param $path	File path.
	 *
	 *	@return Content of the file on success, empty string on failure.
	 */
	function ss_get_file($path)
	{
		if (function_exists('realpath'))
		{
			$path = realpath($path);
		}
		
		if (!$path || !@is_file($path))
		{
			return '';
		}
		
		return @file_get_contents($path);
	}
}

if (!function_exists('ss_extend'))
{
	/**
	 *	Merge the contents of two objects or arrays toghether.
	 *
	 *	@param $object_a	First object.
	 *	@param $object_b	Second object.
	 *
	 *	@return The result of the merging.
	 */
	function ss_extend($object_a, $object_b)
	{
		$object_a = (is_object($object_a)) ? json_decode(json_encode($object_a), true) : $object_a;
		$object_b = (is_object($object_b)) ? json_decode(json_encode($object_b), true) : $object_b;
		
		if (is_array($object_a) && is_array($object_b))
		{
			return array_merge($object_a, $object_b);
		}
		
		return array();
	}
}

if (!function_exists('get_called_class'))
{
    /**
     *  Get called class for PHP older than 5.3.
     */
    function get_called_class($level = 1, $trace = false)
    {
        if (!$trace) $trace = debug_backtrace();
        if (!isset($trace[$level])) throw new Exception('Cannot find called class: stack level too deep');
        if (!isset($trace[$level]['type'])) throw new Exception ('Cannot find called class: type not set');

        switch ($trace[$level]['type'])
        {
            case '::':
                $lines = file($trace[$level]['file']);
                $i = 0;
                $callerLine = '';
                while (stripos($callerLine, $trace[$level]['function']) === false)
                {
                    $i++;
                    $callerLine = $lines[$trace[$level]['line'] - $i] . $callerLine;
                }

                $pattern = '/([a-zA-Z0-9\_]+)::' . $trace[$level]['function'] . '/';
                preg_match($pattern, $callerLine, $matches);

                if (!isset($matches[1]))
                {
                    throw new Exception('Cannot find called class: originating method call is obscured');
                }

                switch ($matches[1]) {
                    case 'self':
                    case 'parent':
                        return get_called_class($level + 1, $trace);
                    default:
                    return $matches[1];
                }

            case '->': 
                switch ($trace[$level]['function']) {
                    case '__get':
                        if (!is_object($trace[$level]['object']))
                        {
                            throw new Exception('Edge case fail. __get called on non object');
                        }
                        return get_class($trace[$level]['object']);
                    default: return $trace[$level]['class'];
                }

            default: 
                throw new Exception ("Unknown backtrace method type");
        }
    }
}