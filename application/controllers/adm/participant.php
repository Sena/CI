<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Participant_model');
    }

    public function index(){
        $this->data['participants'] = $this->Participant_model->get();
        $this->data['header'] = loadDataTable();
        parent::renderer();
    }
    public function edit($id = NULL){
        if($this->uri->segment(3) == 'editar'
            && (int) $id === 0) {
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/novo');
        }else{
            $data = $this->Participant_model->get(array('id_user' => $id))->result();
            $data = current($data);
            $this->data['participant'] = $data;
        }
        $this->content = $this->uri->segment(1) . '/' . $this->router->class . 'edit';
        parent::renderer();
    }
    public function record($id = NULL){
        $id = (int)$id;
        if($this->input->post()){
            /*$this->form_validation->set_rules('name', 'Nome', 'trim|required|min_length[3]');*/
            /*$this->form_validation->set_rules('address', 'Endereço', 'trim|required|min_length[3]|max_length[250]');*/
            /*$this->form_validation->set_rules('telephone', 'Telefone', 'integer|required|min_length[3]|max_length[11]');*/
            /*$this->form_validation->set_rules('cpf', 'CPF', 'integer|required|min_length[3]|max_length[11]');*/
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
            $this->form_validation->set_rules('video', 'URL do vídeo', 'trim|required|min_length[3]|max_length[250]');

            if($this->form_validation->run() === FALSE){
                $this->setError(validation_errors());
                if($id === 0){
                    $redirect = '/novo';
                }else{                   
                    $redirect = '/editar/' . $id;
                }
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) .  $redirect);
            } else {
                $data = $this->input->post();
                if($id === 0){
                    $this->Participant_model->insert($data);
                }else{
                    $this->Participant_model->update(array('id_user' => $id), $data);
                }
                $this->setMsg('Registro atualizado com sucesso');
            }
        }else{
            $this->setError('Ocorreu um erro ao processar o formulario, tente novamente mais tarde');
        }
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
    }
    public function delete($id){
        $data = $this->Participant_model->get(array('id_user' => $id))->result();
        $data = current($data);
        $this->Participant_model->delete(array('id_user' => $id));
        $this->setMsg('Registro excluido com sucesso');
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
    }

}

/* End of file clientes.php */
/* Location: ./application/controllers/adm/clientes.php */