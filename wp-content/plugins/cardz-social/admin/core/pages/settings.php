<?php if (!defined('ABSPATH')) { exit; }

/**
 *  CardZ Social Stream settings page.
 */
class SS_Pg_Settings
{
    /**
     *  Prepare class.
     */
    public function __construct()
    {
        
    }
    
    /**
     *  Save the data.
     */
    public function save_data($options)
    {
        foreach ($options as $key => $value)
        {
            if ($key === 'ss-page-name' || $key === 'submit')
            {
                continue;
            }
            
            update_option($key, trim($value), true);
        }
    }
    
    /**
     *  Render the page.
     */
    public function display()
    {
        // If we have data, save them.
        if (ss_post('ss-page-name') === 'general-settings')
        {
            $this->save_data($_POST);
        }
        
        $key_names = array
        (
            'ss-purchase-code',
	        'ss-fb-app-id',
	        'ss-fb-app-secret',
	        'ss-tw-api-key',
	        'ss-tw-api-secret',
	        'ss-tw-access-token',
	        'ss-tw-access-token-secret',
	        'ss-gp-api-key',
            'ss-yb-api-key',
	        'ss-is-access-token',
            'ss-sc-api-key',
	        'ss-fq-client-id',
	        'ss-fq-client-secret',
	        'ss-li-access-token',
	        'ss-li-client-id',
	        'ss-li-client-secret'
        );
        
        $options = array();
        
        foreach ($key_names as $name)
        {
            $options[$name] = get_option($name, '');
        }
        
        include_once(SS_PROOT . '/admin/views/pages/settings.php');
    }
}