<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prove_student extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_student') == NULL) {
      header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('student/Student_model', 'prove/Prove_model', 'logs/Logs_model'));
    $this->load->helper(array('form', 'url'));
  }

  public function index($offset = NULL) {
    $id = $this->session->userdata('uid_student');
    
    if ($this->Student_model->get_student(array('id' => $id)) == NULL) {
      redirect('student');
    }
    
    $data['student'] = $this->Student_model->get_student(array('id' => $id));
    $data['prove']  = $this->Prove_model->get_student(array('student_id' => $id));
    $data['title'] = 'Kirim Bukti Transfer';
    $data['main'] = 'prove/prove_student_list';
    $this->load->view('student/layout', $data);
  }
  
  public function add($id = NULL) {

    if ($_POST) {
                
      $params['prove_note']         = $this->input->post('prove_note');
      $params['prove_status']       = '2';
      $params['prove_student_id']   = $this->input->post('prove_student_id');
      $status = $this->Prove_model->add($params);

      if (!empty($_FILES['prove_img']['name'])) {
        $paramsupdate['prove_img'] = $this->do_upload($name = 'prove_img', $fileName= base64_encode($params['prove_note']));
      } 

      $paramsupdate['prove_id'] = $status;
      $this->Prove_model->add($paramsupdate);

      $this->session->set_flashdata('success', 'Bukti Transfer Berhasil Dikirim');
      
      redirect('student/prove');
    }
    
  }
  
  public function cancel($id = NULL) {

    if ($_POST) {
      
      $params['prove_id']           = $this->input->post('prove_id'); 
      $params['prove_note']         = $this->input->post('prove_note');
      $params['prove_status']       = '0';
      
      $status = $this->Prove_model->add($params);

      $this->session->set_flashdata('success', 'Transaksi Berhasil Dibatalkan');
      
      redirect('student/prove');
    }
    
  }
	
    // Setting Upload File Requied
  function do_upload($name=NULL, $fileName=NULL) {
    $this->load->library('upload');

    $config['upload_path'] = FCPATH . 'uploads/prove/';

    /* create directory if not exist */
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }

    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '1024';
    $config['file_name'] = $fileName;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($name)) {
      $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
      redirect(uri_string());
    }

    $upload_data = $this->upload->data();

    return $upload_data['file_name'];
  }

}
