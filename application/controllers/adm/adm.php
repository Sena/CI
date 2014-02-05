<?php
class Adm extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index() {
    	$this->data['content'] = 'Olá ' . $this->data['logado']->name . ' - Seja bem vindo';
    	parent::renderer();
    }
}