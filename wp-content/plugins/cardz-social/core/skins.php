<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Manage plugin skins.
 */
class SS_Skins
{
	/**
	 *	Skins.
	 */
	protected $skins = null;
	 
	/**
	 *	Instance of this class.
	 */
	protected static $instance = null;
	
	/**
	 *	Set hooks.
	 */
	public function __construct()
	{
		//$this->skins = $this->get_skins_from_file(SS_PROOT . '/content/skins/');
        $this->skins = $this->get_available_skins();
	}
	
	/**
	 *	Get instance of this class.
	 *
	 *	@return SP_Skins instance.
	 */
	public static function get_instance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 *	Get skins array.
	 *
	 *	@return The skins array.
	 */
	public function get_skins()
	{
		return $this->skins;
	}
    
    /**
     *  Get a list of available skins.
     *
     *  This function will search for available skins in multiple locations.
     *
     *  @return Array The list of skins as an associative array.
     */
    private function get_available_skins()
    {
        $skins = $this->get_skins_from_file(SS_PROOT . '/content/skins/');
        $skins += $this->get_skins_from_file(SS_PROOT . '/content/js/skins/grid/');
        $skins += $this->get_skins_from_file(SS_CROOT . '/cardz/skins/');
        
        return $skins;
    }
	
	/**
	 *	Get skins from file.
	 *
	 *	@param string $path path.
	 */
	private function get_skins_from_file($path)
	{
		$files = glob($path . '*');
		$skins = array('flat' => array()); // Make sure the default skin is the first skin.
		
        if (empty($files))
        {
            return array();
        }
        
		foreach ($files as $file)
		{
			$file_name = basename($file);
            $skin_name = basename($file, '.jpg');
            
            $skin = new stdClass();
            
            $skin->thumb = '<img src="' . SS_PURL . '/content/skins/' . $file_name . '" height="120" />';
            $skin->thumb_path = $file;
            $skin->name = $skin_name;
            $skin->file_name = $file_name;
			
			$skins[$skin_name] = $skin;
		}
		
		return $skins;
	}    
}

/**
 *	Returns the instance of SS_Skins.
 *
 *	@return SS_Skins
 */
function SS_Skins()
{
	return SS_Skins::get_instance();
}

?>