<?php if (!defined('ABSPATH')) { exit; }

/**
 *  Admin view manager.
 */
class SS_Admin_View_Manager
{
    /**
     *  Hold views.
     *
     *  @var array
     */
    private $views = array();
    
    /**
     *  Register view.
     *
     *  @param string $name The view name.
     *  @param string $file The file view to be loaded.
     *  @param array $data Data to be available in the view.
     */
    public function register_view($name, $file, $data)
    {
        $this->views[$name] = new stdClass();
        
        $this->views[$name]->file = $file;
        $this->views[$name]->data = $data;
    }
    
    /**
     *  Remove view.
     *
     *  @param string $name The view name.
     */
    public function remove_view($name)
    {
        if (!empty($this->views[$name]))
        {
            unset($this->views[$name]);
        }
    }
    
    /**
     *  Load view.
     *
     *  @param string $name The view name.
     *  @param array $additional_data [optional] Additional data to be available in the view.
     */
    public function load_view($name, $additional_data = array())
    {
        if (!empty($this->views[$name]))
        {
            extract($this->views[$name]->data);
            extract($additional_data);
            
            include_once(SS_PROOT . '/admin/views/' . $this->views[$name]->file);
        }
    }
}

global $ss_admin_views;

$ss_admin_views = new SS_Admin_View_Manager();

/**
 *  Register view.
 *
 *  @param string $name The view name.
 *  @param string $file The file view to be loaded.
 *  @param array $data [optional] Data to be available in the view.
 */
function ss_register_admin_view($name, $file, $data = array())
{
    global $ss_admin_views;
    
    $ss_admin_views->register_view($name, $file, $data);
}

/**
 *  Remove view.
 *
 *  @param string $name The view name.
 */
function ss_remove_admin_view($name)
{
    global $ss_admin_views;
    
    $ss_admin_views->remove_view($name);
}

/**
 *  Load view.
 *
 *  @param string $name The view name.
 *  @param array $additional_data [optional] Additional data to be available in the view.
 */
function ss_load_admin_view($name, $additional_data = array())
{
    global $ss_admin_views;
    
    $ss_admin_views->load_view($name, $additional_data);
}