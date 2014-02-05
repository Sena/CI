<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Client_model');
    }

    public function index(){
        $this->data['clients'] = $this->Client_model->get();
        $this->data['header'] = loadDataTable();
        parent::renderer();
    }
    public function edit($id = NULL){
        if($this->uri->segment(3) == 'editar'
            && (int) $id === 0) {
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/novo', 'refresh');
        }else{
            $data = $this->Client_model->get(array('id_client' => $id))->result();
            $data = current($data);
            $this->data['client'] = $data;
        }
        $this->content = $this->uri->segment(1) . '/' . $this->router->class . 'edit';
        parent::renderer();
    }
    public function record($id = NULL){
        $id = (int)$id;
        if($this->input->post()){
            $this->form_validation->set_rules('client', 'Nome', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('order', 'Ordem', 'is_natural');

            if($this->form_validation->run() === FALSE){
                $this->setError(validation_errors());
                if($id === 0){
                    $redirect = '/novo';
                }else{                   
                    $redirect = '/editar/' . $id;
                }
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) .  $redirect, 'refresh');
            } else {
                $data = $this->input->post();
                $data['id_status'] = 3;
                if($id === 0){
                    $this->Client_model->insert($data);
                }else{
                    $this->Client_model->update(array('id_client' => $id), $data);
                }
                $this->setMsg('Registro atualizado com sucesso');
            }
        }else{
            $this->setError('Ocorreu um erro ao processar o formulario, tente novamente mais tarde');
        }
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2), 'refresh');
    }
    public function delete($id){
        $data = $this->Client_model->get(array('id_client' => $id))->result();
        $data = current($data);
        $this->Client_model->delete(array('id_client' => $id));
        $this->setMsg('Registro excluido com sucesso');
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2), 'refresh');
    }

}

/* End of file clientes.php */
/* Location: ./application/controllers/adm/clientes.php */