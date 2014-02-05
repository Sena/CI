<?php
class Testimonials extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Testimonial_model');
    }
    public function index(){
        $this->data['list'] = $this->Testimonial_model->get();
        $this->data['header'] = loadDataTable();
        parent::index();
    }
    public function edit($id = NULL){
        if($this->uri->segment(3) == 'editar'
            && (int) $id === 0) {
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/novo');
        }else{
            $data = $this->Testimonial_model->get(array('id' => $id))->result();
            $data = current($data);
            if(isset($data->date)) {
                $data->date = implode('/', array_reverse(explode('-', $data->date)));
            }
            $this->data['data'] = $data;
        }
        $this->data['header'] .= loadValidator() . loadMask();
        $this->content = $this->uri->segment(1) . '/' . $this->router->class . 'edit';
        parent::index();
    }
    public function record($id = NULL){
        $id = (int)$id;
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
                $data['date'] = implode('-', array_reverse(explode('/', $data['date'])));

                if($_FILES['src']['size'] > 0) {

                    if($id !== 0){
                        $tempVar = $this->Testimonial_model->get(array('id' => $id))->result();
                        $tempVar = current($tempVar);
                        @unlink($tempVar->src);
                    }
                    $uploadPath = './assets/uploads/' . $this->router->class . '/';
        
                    $this->load->library('upload', array('upload_path' => $uploadPath, 'allowed_types' => 'gif|jpg|png'));

                    if ( ! $this->upload->do_upload('src')) {
                        $this->setError($this->upload->display_errors());
                    }else{
                        $file = $this->upload->data();
                        $data['src'] = $uploadPath . $file['file_name'];
                    }
                }
                if($id === 0){
                    $this->Testimonial_model->insert($data);
                }else{
                    $this->Testimonial_model->update(array('id' => $id), $data);
                }
                $this->setMsg('Registro atualizado com sucesso');
            }
        }else{
            $this->setError('Ocorreu um erro ao processar o formulario, tente novamente mais tarde');
        }
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
    }
    public function delete($id){
        $data = $this->Testimonial_model->get(array('id' => $id))->result();
        $data = current($data);
        @unlink($data->src);
        $this->Testimonial_model->delete(array('id' => $id));
        $this->setMsg('Registro excluido com sucesso');
        redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
    }
}

/* End of file testimonial.php */
/* Location: ./application/controllers/adm/testimonial.php */