<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gallery_model');
    }
    public function index(){
        $this->data['category'] = $this->Gallery_model->getCategory()->result();
        $this->data['header'] = loadDataTable();
        $this->content = $this->uri->segment(1) . '/category';
        parent::renderer();
    }
    public function imagens($id = NULL){        
        $this->session->set_userdata('category_id', $id);
        $this->data['galleries'] = $this->Gallery_model->get(array('category_id' => $id))->result();
        $this->data['header'] = loadDataTable();
        $this->data['category_id'] = $this->session->userdata('category_id');
        parent::renderer();
    }
    public function edit($id = NULL){
        if($this->uri->segment(3) == 'editar'
            && (int) $id === 0) {
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/novo');
        }else{
            $data = $this->Gallery_model->get(array('id' => $id))->result();
            $data = current($data);
            $this->data['gallery'] = $data;
        }
        $this->content = $this->uri->segment(1) . '/' . $this->router->class . 'edit';
        parent::renderer();
    }
    public function record($id = NULL){
        $id = (int)$id;
        $uploadPath = './assets/uploads/' . $this->router->class . '/';
        $imgConfig = array('upload_path' => $uploadPath, 'allowed_types' => 'gif|jpg|png');


        if($this->input->post()){
            $this->form_validation->set_rules('name', 'Nome', 'trim|required|min_length[3]');

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
                $data['category_id'] = $this->session->userdata('category_id');

                if($id !== 0){
                    $oldData = $this->Gallery_model->get(array('id' => $id))->result();
                    $oldData = current($oldData);
                }

                if($_FILES['thumbnail']['size'] > 0) {
                    @unlink($oldData->thumbnail);

                    $this->load->library('upload', $imgConfig);

                    if ( ! $this->upload->do_upload('thumbnail')) {
                        $this->setError($this->upload->display_errors());
                    }else{
                        $file = $this->upload->data();
                        $this->load->library('image_lib', array(
                            'source_image'  => $file['full_path'],
                            'width'         => 118,
                            'height'        => 112,
                            'quality'       => '80%'));

                        if ( ! $this->image_lib->resize()){
                            $this->setError($this->image_lib->display_errors());
                        }
                        $data['thumbnail'] = $uploadPath . $file['file_name'];
                    }
                }

                if($_FILES['image']['size'] > 0) {
                    @unlink($oldData->image);
                    $imgConfig['max_width'] = '1024';
                    $imgConfig['max_height'] = '768';

                    $this->load->library('upload', $imgConfig);

                    if ( ! $this->upload->do_upload('image')) {
                        $this->setError($this->upload->display_errors());
                    }else{
                        $file = $this->upload->data();
                        $data['image'] = $uploadPath . $file['file_name'];
                    }
                }
                if($id === 0){
                    $this->Gallery_model->insert($data);
                }else{
                    $this->Gallery_model->update(array('id' => $id), $data);
                }
                $this->setMsg('Registro atualizado com sucesso');
                $data = $this->Gallery_model->get($data)->result();
                $data = current($data);
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/imagens/' . $this->session->userdata('category_id'));
            }
        }else{
            $this->setError('Ocorreu um erro ao processar o formulario, tente novamente mais tarde');
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
        }
    }
    public function delete($id){
        $data = $this->Gallery_model->get(array('id' => $id))->result();
        $data = current($data);
        @unlink($data->thumbnail);
        @unlink($data->image);
        $this->Gallery_model->delete(array('id' => $id));
        $this->setMsg('Registro excluido com sucesso');
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
    }
}

/* End of file clientes.php */
/* Location: ./application/controllers/adm/clientes.php */