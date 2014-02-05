<?php
class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }
    public function index() {
    	if(isset($this->data['logado']->id)){
	    	$this->session->unset_userdata('logado');
	    	unset($this->data['logado']);
    	}
    	parent::renderer();
    }
    public function auth(){
    	if($this->input->post()){

	        $this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[3]');
	        $this->form_validation->set_rules('password', 'Senha', 'trim|required');

	        if($this->form_validation->run() === FALSE){
        		$this->setError(validation_errors());
	        } else {
	        	$this->load->model('login_model');

	            $logado = $this->login_model->get(array('username' => $this->input->post('username')))->result();
	            if (count($logado) === 0) {
	                $this->setError('Usuário não cadastrado em nosso sistema');
	            }else {
	                $logado = current($logado);
	                if($logado->password != md5($this->input->post('password'))) {
	                    $this->setError('Senha incorreta');
	                } elseif((int)$logado->status_id != 1) {
	                    $this->setError('Usuário não está ativo');
	                } else {
	                    $this->session->set_userdata('logado', $logado);
	                }
	                //$this->goToPreviousUrl(); //There is a bug
	                redirect($this->uri->segment(1));
	            }
	        }
    	}else{
    		$this->setError('Ocorreu um erro ao processar o formulario, tente novamente mais tarde');
    	}
	    redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
    }
}