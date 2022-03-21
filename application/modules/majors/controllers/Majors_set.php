<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Majors_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    if ($this->session->userdata('uroleid') != '3') {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('student/Student_model', 'setting/Setting_model'));
    $this->load->helper(array('form', 'url'));
  }

// User_customer view in list
  public function index($offset = NULL) {
    $this->load->library('pagination');
// Apply Filter
// Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
// Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['majors_name'] = $f['n'];
    }

    //$paramsPage = $params;
    //$params['limit'] = 10;
    //$params['offset'] = $offset;
    $data['majors'] = $this->Student_model->get_unit($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    //$config['per_page'] = 10;
    //$config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/majors/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    //$config['total_rows'] = count($this->Student_model->get_class($paramsPage));
    //$this->pagination->initialize($config);

    $data['title'] = 'Unit Sekolah';
    $data['main'] = 'majors/majors_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      $majorsName = $_POST['majors_name'];
      $majorsShort = $_POST['majors_short_name'];
      $majorsStatus = $_POST['majors_status'];
      $cpt = count($_POST['majors_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['majors_name'] = $majorsName[$i];
        $params['majors_short_name'] = $majorsShort[$i];
        $params['majors_status'] = $majorsStatus[$i];

        $this->Student_model->add_majors($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Unit Sekolah Berhasil');
    redirect('manage/majors');
  }

// Add User_customer and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('majors_name', 'Nama Unit Sekolah', 'trim|required|xss_clean');
    $this->form_validation->set_rules('majors_short_name', 'Singkatan Unit Sekolah', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('majors_id')) {
        $params['majors_id'] = $this->input->post('majors_id');
      }
      $params['majors_name'] = $this->input->post('majors_name');
      $params['majors_short_name'] = $this->input->post('majors_short_name');
      $params['majors_status'] = $this->input->post('majors_status');
      $status = $this->Student_model->add_majors($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Kelas');
      redirect('manage/majors');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('majors_id')) {
        redirect('manage/majors/edit/' . $this->input->post('majors_id'));
      }

            // Edit mode
      if (!is_null($id)) {
        $object = $this->Student_model->get_unit(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/majors');
        } else {
          $data['majors'] = $object;
        }
      }
      $data['title'] = $data['operation'] . ' Unit Sekolah';
      $data['main'] = 'majors/majors_add';
      $this->load->view('manage/layout', $data);
    }
  }
  
  function majors_active($id = NULL) { 

    $active = array(
      'majors_id' => $id,
      'majors_status' => 1
    );

    $status = $this->Student_model->add_majors($active);

    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('success', 'Aktif Unit Sekolah Berhasil');
      redirect('manage/majors');
    }
  }
  
  function majors_nonactive($id = NULL) { 

    $active = array(
      'majors_id' => $id,
      'majors_status' => 0
    );

    $status = $this->Student_model->add_majors($active);

    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('success', 'Non-Aktif Unit Sekolah Berhasil');
      redirect('manage/majors');
    }
  }

// Delete to database
  public function delete($id = NULL) {
    if ($_POST) {

      $siswa = $this->Student_model->get(array('majors_id'=>$id));

      if (count($siswa) > 0) {
        $this->session->set_flashdata('failed', 'Data Unit Sekolah tidak dapat dihapus');
        redirect('manage/majors');
      }

      $this->Student_model->delete_majors($id);
// activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'user',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Unit Sekolah Sekolah berhasil');
      redirect('manage/majors');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/majors/edit/' . $id);
    }  
  }
}
