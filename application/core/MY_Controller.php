<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $data = array();
    public $content = NULL;
    public $header = 'default/header';
    public $footer = 'default/footer';

    public function __construct() {
        parent::__construct();
        
        $this->data['logado'] = $this->session->userdata('logado');
        $this->data['header'] = NULL;

        if($this->uri->segment(1) == 'adm'){
            if($this->router->class != 'login' && isset($this->data['logado']->id) === FALSE) {
                $this->setError('É necessário estar logado');
                $this->setPreviousUrl(base_url($this->uri->uri_string()));
                redirect(base_url('/adm/login'), 'refresh');
            }
            if($this->header !== NULL) {
                $this->header = 'adm/' . $this->header;
            }
            if($this->footer !== NULL) {
                $this->footer = 'adm/' . $this->footer;
            }
            $this->content = 'adm/' . (file_exists(APPPATH . 'views/adm/' . $this->router->class . '.php') ? $this->router->class : 'default/content.php');
        
            $this->data['css'] = loadCss($this->router->class, 'adm/');
            $this->data['js'] = loadJs($this->router->class, 'adm/');
            


            header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

        }else{
            $this->content = file_exists(APPPATH . 'views/' . $this->router->class . '.php') ? $this->router->class : 'default/content.php';
        
            $this->data['css'] = loadCss($this->router->class);
            $this->data['js'] = loadJs($this->router->class);
        }
        $this->data['error'] = $this->session->flashdata('error');
        $this->data['msg'] = $this->session->flashdata('msg');
    }
    
    /**
     * Call the view
     *
     * @access  public
     */
    public function index() {
        $this->renderer();
    }
    
    /**
     * Set a generic error to show in the view
     *
     * @access  public
     * @param   string A generic error
     */
    public function setError($str) {
        $this->session->set_flashdata('error', $this->session->flashdata('error') . '<p>' . $str . '</p>');
    }
    
    /**
     * Set a generic msg to show in the view
     *
     * @access  public
     * @param   string A generic msg
     */
    public function setMsg($str) {
        $this->session->set_flashdata('msg', $this->session->flashdata('msg') . '<p>' . $str . '</p>');
    }
    
    /**
     * Checks if user is logged
     *
     * @access  public
     */
    public function renderer() {

        if(ENVIRONMENT == 'development') {
            $this->db->cache_delete_all();
        }


        //if($content === NULL) 
        if(isset($this->data['pageTitle']) == false)  $this->data['pageTitle'] =  NAME_SITE . ' | ' . ucfirst($this->router->class);
        /*
        if($this->session->userdata('logado') == false && $this->router->class != 'login') {
            redirect(base_url(), 'refresh');
        }
        */

        if($this->header !== NULL) {
            $this->load->view($this->header, $this->data);
        }
        $this->load->view($this->content, $this->data);

        if($this->footer !== NULL) {
            $this->load->view($this->footer, $this->data);           
        }
    }
    
    /**
     * Set a window title
     *
     * @access  public
     * @param   string A $page name
     */
    public function setPageTitle($page){
        $this->data['pageTitle'] = NAME_SITE . ' | ' . $page;
    }
    
    /**
     * Set a previous URL
     *
     * @access  public
     * @param   string A valid address internal or external
     */
    public function setPreviousUrl($address){
        $previousUrl = $this->session->userdata('previousUrl');
        $previousUrl[] = $address;
        
        $this->session->set_userdata( 'previousUrl', $previousUrl );
    }
    
    /**
     * Redirect the user, to previous URL 
     *
     * @access  public
     */
    public function goToPreviousUrl(){
        $previousUrl = $this->session->userdata('previousUrl');
        if(is_array($previousUrl) && count($previousUrl) > 0) {
            $previous = array_pop($previousUrl);
            $this->session->set_userdata( 'previousUrl', $previousUrl );
            redirect($previous, 'refresh');
        }else{
            return FALSE;
        }
    }
}