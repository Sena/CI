<?php
class Partner extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Partner_model');
    }
    public function index(){
        $this->data['partners'] = $this->Partner_model->get();
        $this->data['header'] = loadDataTable();
        parent::index();
    }
    public function edit($id = NULL){
        if($this->uri->segment(3) == 'editar'
            && (int) $id === 0) {
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/novo', 'refresh');
        }else{
            $data = $this->Partner_model->get(array('id_partner' => $id))->result();
            $data = current($data);
            $this->data['partner'] = $data;
        }
        $this->content = $this->uri->segment(1) . '/' . $this->router->class . 'edit';
        parent::index();
    }
    public function record($id = NULL){
        $id = (int)$id;
        if($this->input->post()){
            $this->form_validation->set_rules('partner', 'Nome', 'trim|required|min_length[3]');
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
                $data['id_status'] = 1;

                if($_FILES['src']['size'] > 0) {

                    if($id !== 0){
                        $tempVar = $this->Partner_model->get(array('id_partner' => $id))->result();
                        $tempVar = current($tempVar);
                        @unlink($tempVar->src);
                    }
                    $uploadPath = './assets/uploads/' . $this->router->class . '/';
        
                    $this->load->library('upload', array('upload_path' => $uploadPath, 'allowed_types' => 'gif|jpg|png'));

                    if ( ! $this->upload->do_upload('src')) {
                        $this->setError($this->upload->display_errors());
                    }else{
                        $file = $this->upload->data();
                        $this->load->library('image_lib', array('source_image' => $file['full_path'],
                            'width' => 316,
                            'height' => 316,
                            'quality' => '80%'));

                        if ( ! $this->image_lib->resize()){
                            $this->setError($this->image_lib->display_errors());
                        }
                        $data['src'] = $uploadPath . $file['file_name'];
                    }
                }
                if($id === 0){
                    $this->Partner_model->insert($data);
                }else{
                    $this->Partner_model->update(array('id_partner' => $id), $data);
                }
                $this->setMsg('Registro atualizado com sucesso');
            }
        }else{
            $this->setError('Ocorreu um erro ao processar o formulario, tente novamente mais tarde');
        }
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2), 'refresh');
    }
    public function delete($id){
        $data = $this->Partner_model->get(array('id_partner' => $id))->result();
        $data = current($data);
        @unlink($data->src);
        $this->Partner_model->delete(array('id_partner' => $id));
        $this->setMsg('Registro excluido com sucesso');
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2), 'refresh');
    }
}

/* End of file partner.php */
/* Location: ./application/controllers/adm/partner.php */