<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();

        $this->table = 'login';
    }

}

/* End of file login_model.php */
/* Location: ./application/models/login_model.php */