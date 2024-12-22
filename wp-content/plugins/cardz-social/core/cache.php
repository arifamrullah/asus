<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Handle persistent data cache.
 *
 *  Usage:
 *      $ss_cache = new SS_File_Cache();
 *
 *      $ss_cache['unique-key'] = 'data to store';
 *
 *      echo $ss_cache['unique-key'];
 */
class SS_File_Cache implements ArrayAccess
{
	/**
	 *	Cache folder.
	 *
	 *	@var string
	 */
	protected $cache_folder = '';
	
	/**
	 *	Update frequency.
	 *
	 *	@var int
	 */
	protected $update_frequency = 3600;	// 1 day.
	
	/**
	 *	Array to keep the data in memory.
	 *
	 *	@var array
	 */
	protected $cached_data = array();
	
	/**
	 *	Do we keep the data in memory.
	 *
	 *	@var bool
	 */
	protected $keep_in_memory = false;
	
	/**
	 *	Initialize.
	 *
	 *	@param int $update_frequency [optional] The frequency update time in seconds.
	 *	@param string $cache_folder [optional] Cache folder.
	 *	@param bool $keep_in_memory [optional] Do we keep the data in memory?
	 */
	public function __construct($update_frequency = 3600, $cache_folder = '', $keep_in_memory = false)
	{
		$this->update_frequency = ($update_frequency > 0) ? $update_frequency : 0;
		$this->cache_folder = (empty($cache_folder)) ? SS_CROOT . '/ss_cache' : $cache_folder;
		$this->keep_in_memory = $keep_in_memory;
		
		// Create the folder if it dosen't exist.
		if (!is_dir($this->cache_folder))
		{
			mkdir($this->cache_folder, 0775, true);
		}
		
		if (!is_writable($this->cache_folder))
		{
			throw new Exception('The folder ' . $this->cache_folder . ' is not writable');
		}
	}
	
	/**
	 *	Check if the file exists.
	 */
	public function offsetExists($offset)
	{
		return file_exists($this->get_file_name($offset));
	}
	
	/**
	 *	Add data to cahce.
	 */
	public function offsetSet($offset, $value)
	{
		if ($this->keep_in_memory)
		{
			$this->cached_data[$offset] = $value;
		}
        
		file_put_contents($this->get_file_name($offset), serialize($value));
	}
	
	/**
	 *	Remove the file.
	 */
	public function offsetUnset($offset)
	{
		if ($this->keep_in_memory)
		{
			unset($this->cached_data[$offset]);
		}
		
		unlink($this->get_file_name($offset));
	}
	
	/**
	 *	Get data from cache.
	 */
	public function offsetGet($offset)
	{
		if ($this->keep_in_memory && !empty($this->cached_data[$offset]))
		{
			return $this->cached_data[$offset];
		}
	
		if (!$this->offsetExists($offset))
		{
			return null;
		}
		
		return unserialize(file_get_contents($this->get_file_name($offset)));
	}
	
	/**
	 *	Check if it is time to update.
	 *
	 *	@return bool Returns true if it is time to update, false otherwise.
	 */
	public function is_time_to_update($offset)
	{
		$file_name = $this->get_file_name($offset);
		
		if ($this->update_frequency <= 0)
		{
			return true;
		}
		
		return (!$this->offsetExists($offset) || filemtime($file_name) < (time() - $this->update_frequency));
	}
    
    /**
     *  Empty specific cache.
     */
    public function clear($offset = '')
    {
        if (!empty($offset))
        {
            if ($this->offsetExists($offset))
            {
                $this->offsetUnset($offset);
            }
        }
        else 
        {
            if ($this->keep_in_memory)
		    {
                $this->cached_data = array();
		    }

            // Remove all files from the cache directory.
            array_map('unlink', ($file_list = glob($this->cache_folder . '/*')) ? $file_list : array());
        }
    }
	
	/** 
	 *	Create and get the file name.
	 */
	private function get_file_name($offset)
	{
		return $this->cache_folder . '/' . md5($offset) . '.cdf';
	}
}

/**
 *  Handle persistent data cache.
 *
 *  Usage:
 *      $ss_cache = new SS_DB_Cache();
 *
 *      $ss_cache['unique-key'] = 'data to store';
 *
 *      echo $ss_cache['unique-key'];
 */
class SS_DB_Cache implements ArrayAccess
{
	/**
	 *	Update frequency.
	 *
	 *	@var int
	 */
	protected $update_frequency = 3600;	// 1 day.
	
	/**
	 *	Array to keep the data in memory.
	 *
	 *	@var array
	 */
	protected $cached_data = array();
	
	/**
	 *	Do we keep the data in memory.
	 *
	 *	@var bool
	 */
	protected $keep_in_memory = false;
    
    /**
     *  The DB table name.
     *
     *  @var string
     */
    protected $table_name = '';
	
	/**
	 *	Initialize.
	 *
	 *	@param int $update_frequency [optional] The frequency update time in seconds.
	 *	@param bool $keep_in_memory [optional] Do we keep the data in memory?
	 */
	public function __construct($update_frequency = 3600, $keep_in_memory = false)
	{
        global $wpdb;
        
        $this->table_name = $wpdb->prefix . 'ss_cache';
    
		$this->update_frequency = ($update_frequency > 0) ? $update_frequency : 0;
		$this->keep_in_memory = $keep_in_memory;
	}
	
	/**
	 *	Check if the value exists.
	 */
	public function offsetExists($offset)
	{
        global $wpdb;
        
        $result = $wpdb->get_row($wpdb->prepare("SELECT name FROM {$this->table_name} WHERE name=%s", $offset), ARRAY_A);
        
        return !empty($result);
	}
	
	/**
	 *	Add data to cahce.
	 */
	public function offsetSet($offset, $value)
	{
        global $wpdb;
    
		if ($this->keep_in_memory)
		{
			$this->cached_data[$offset] = $value;
		}
        
        //if (is_array($value))
        {
            //$value = serialize($value);
            $value = json_encode($value);
        }
        
        if (!$this->offsetExists($offset))
        {
            $wpdb->insert($this->table_name,
            array
            (
                'name'  => $offset,
                'value'  => $value,
            ),
            array
            (
                '%s',
                '%s'
            ));
            
            ap_debug(false)->log($wpdb->last_error, $wpdb->show_errors(), $wpdb->last_query);
        }
        else
        {
            $wpdb->update($this->table_name,
            array
            (
                'name'  => $offset,
                'value'  => $value,
            ),
            array('name' => $offset),
            array
            (
                '%s',
                '%s'
            ),
            array('%s'));
        }
	}
	
	/**
	 *	Remove the file.
	 */
	public function offsetUnset($offset)
	{
        global $wpdb;
    
		if ($this->keep_in_memory)
		{
			unset($this->cached_data[$offset]);
		}
		
		$wpdb->query($wpdb->prepare("DELETE FROM {$this->table_name} WHERE name = %s", $offset));
	}
	
	/**
	 *	Get data from cache.
	 */
	public function offsetGet($offset)
	{
        global $wpdb;
    
		if ($this->keep_in_memory && !empty($this->cached_data[$offset]))
		{
			return $this->cached_data[$offset];
		}
	
		if (!$this->offsetExists($offset))
		{
			return null;
		}
        
        $result = $wpdb->get_row($wpdb->prepare("SELECT name, value FROM {$this->table_name} WHERE name=%s", $offset), ARRAY_A);
        
        if (empty($result))
        {
            return null;
        }
        
        $unserialized = unserialize($result['value']);
        
        return ($unserialized) ? $unserialized : $result['value'];
	}
	
	/**
	 *	Check if it is time to update.
	 *
	 *	@return bool Returns true if it is time to update, false otherwise.
	 */
	public function is_time_to_update($offset)
	{
        global $wpdb;
    
		if ($this->update_frequency <= 0)
		{
			return true;
		}
        
        $result = $wpdb->get_row($wpdb->prepare("SELECT name, created FROM {$this->table_name} WHERE name=%s", $offset), ARRAY_A);
        
        if (!empty($result))
        {
            $db_time = strtotime($result['created']);
            
            return ($db_time < (time() - $this->update_frequency));
        }
        
		return true;
	}
	
	/**
     *  Create the DB table.
     *
     *  This should be called when the plugin/theme is activated.
     */
    public function create_db_table()
    {
        global $wpdb, $charset_collate;
        
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS {$this->table_name}
        (
            id_cache INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            value TEXT NOT NULL,
            created TIMESTAMP NOT NULL DEFAULT NOW(),
            PRIMARY KEY (id_cache)
        ) {$charset_collate};
SQL;

        $wpdb->query($sql);
    }
}

global $ss_file_cache;
        
$ss_file_cache = new SS_File_Cache();