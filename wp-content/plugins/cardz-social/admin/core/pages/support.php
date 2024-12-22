<?php if (!defined('ABSPATH')) { exit; }

/**
 *  CardZ Social Stream support page.
 *
 *  @since 1.0.43
 */
class SS_Pg_Support
{
    const PAGE_NAME = 'support-page';
    
    /**
     *  Holds the support message.
     */
    private $support_message = '';

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
        if (ss_post('ss-page-name') === self::PAGE_NAME)
        {
            $this->generate_support_message($_POST);
            $ss_response = $this->send_support_message();
        }
        
        include_once(SS_PROOT . '/admin/views/pages/support.php');
    }
    
    /**
     *  Generate the support message.
     *
     *  @param Array $data The data from which to generate the message.
     */
    private function generate_support_message($data)
    {
        $this->support_message = array
        (
            'contact-name'      => ss_post('ss-support-name'),
            'contact-email'     => ss_post('ss-support-email'),
            'contact-title'     => ss_post('ss-support-title'),
            'contact-website'   => ss_post('ss-support-website'),
            'contact-message'   => ss_post('ss-support-issue') . '<br /><br />'  . ss_post('ss-support-type'),
            'contact-submit'    => 1
        );
    }
    
    /**
     *  Send support message.
     */
    private function send_support_message()
    {
        $response = wp_remote_post('http://www.wpsocialstream.com/contact/', array
        (
            'method'        => 'POST',
            'timeout'       => 45,
            'redirection'   => 5,
            'blocking'      => true,
            'body'          => $this->support_message
        ));
        
        if (is_wp_error($response))
        {
            return ;
        }
        
        return $response;
    }
}