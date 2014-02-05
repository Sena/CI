<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mosaic extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mosaic_model');
    }
    public function map($id = NULL){
        $this->session->set_userdata('category_id', $id);
        $this->data['mosaic'] = $this->Mosaic_model->get(array('category_id' => $id))->result();
        $this->content = $this->uri->segment(1) . '/mosaic';
        parent::renderer();
    }
    public function edit($id){
        $where = array();
        $where['position'] = $id;
        $where['category_id'] = $this->session->userdata('category_id');
        $data = $this->Mosaic_model->get($where)->result();
        $data = current($data);
        $data->id = $data->position;
        $this->data['gallery'] = $data;
        $this->content = $this->uri->segment(1) . '/galleryedit';
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
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) .  '/editar/' . $id);
            } else {
                $data = $this->input->post();

                $where = array();
                $where['position'] = $id;
                $where['category_id'] = $this->session->userdata('category_id');

                $oldData = $this->Mosaic_model->get($where)->result();
                $oldData = current($oldData);

                if($_FILES['thumbnail']['size'] > 0) {
                    @unlink($oldData->thumbnail);

                    $this->load->library('upload', $imgConfig);

                    if ( ! $this->upload->do_upload('thumbnail')) {
                        $this->setError($this->upload->display_errors());
                    }else{
                        $file = $this->upload->data();

                        $image_lib = array_merge($this->getimagesize($id), array('source_image'  => $file['full_path'], 'quality' => '80%'));

                        $this->load->library('image_lib', $image_lib);

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
                $this->Mosaic_model->update($where, $data);
                $this->setMsg('Registro atualizado com sucesso');
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/mapa/' . $this->session->userdata('category_id'));
            }
        }else{
            $this->setError('Ocorreu um erro ao processar o formulario, tente novamente mais tarde');
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
        }
    }
    private function getimagesize($position)
    {
        switch ($position) {
            case 1:
                $return = array('width' => 781, 'height' => 284);
                break;

            case 2:
                $return = array('width' => 244, 'height' => 284);
                break;

            case 3:
                $return = array('width' => 262, 'height' => 179);
                break;

            case 4:
                $return = array('width' => 763, 'height' => 179);
                break;

            case 5:
                $return = array('width' => 262, 'height' => 270);
                break;

            case 6:
                $return = array('width' => 763, 'height' => 270);
                break;
        }
        return $return;
    }
}

/* End of file clientes.php */
/* Location: ./application/controllers/adm/clientes.php */