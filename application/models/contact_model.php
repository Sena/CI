<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table = 'contact';
    }
}

/* End of file login_model.php */
/* Location: ./application/models/login_model.php */