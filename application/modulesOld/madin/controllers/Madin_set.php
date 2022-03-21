<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Madin_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
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
    $s = $this->input->get(NULL, TRUE);
    $f = $this->input->get(NULL, TRUE);

    $data['s'] = $s;
    $data['f'] = $f;

    $params = array();
// Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['madin_name'] = $f['n'];
    }
    
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != 'all') {
      $params['majors_id'] = $s['m'];
    }else if (isset($s['m']) && !empty($s['m']) && $s['m'] == 'all') {
      //$params['majors_id'] = $s['m'];
    }

    //$paramsPage = $params;
    //$params['limit'] = 10;
    //$params['offset'] = $offset;
    $data['madin'] = $this->Student_model->get_madin($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    //$config['per_page'] = 10;
    //$config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/madin/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    //$config['total_rows'] = count($this->Student_model->get_madin($paramsPage));
    //$this->pagination->initialize($config);
    $data['majors'] = $this->Student_model->get_majors();
    
    $data['title'] = 'Kamar';
    $data['main'] = 'madin/madin_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      $madinName = $_POST['madin_name'];
      //$madinMajorsId = $_POST['madin_majors_id'];
      $cpt = count($_POST['madin_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['madin_name'] = $madinName[$i];
        //$params['madin_majors_id'] = $madinMajorsId;

        $this->Student_model->add_madin($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Kamar Berhasil');
    redirect('manage/madin');
  }

// Add User_customer and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('madin_name', 'Nama Kamar', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('madin_id')) {
        $params['madin_id'] = $this->input->post('madin_id');
      }
      $params['madin_name'] = $this->input->post('madin_name');
      //$params['madin_majors_id'] = $this->input->post('madin_majors_id');
      $status = $this->Student_model->add_madin($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Kamar');
      redirect('manage/madin');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('madin_id')) {
        redirect('manage/madin/edit/' . $this->input->post('madin_id'));
      }

// Edit mode
      if (!is_null($id)) {
        $object = $this->Student_model->get_madin(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/madin');
        } else {
          $data['madin'] = $object;
        }
      }
      $data['majors'] = $this->Student_model->get_majors();
      $data['title'] = $data['operation'] . ' Keterangan Kamar';
      $data['main'] = 'madin/madin_add';
      $this->load->view('manage/layout', $data);
    }
  }


// Delete to database
  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    $siswa = $this->Student_model->get(array('madin_id'=>$id));

    if ($_POST) {

      if (count($siswa) > 0) {
        $this->session->set_flashdata('failed', 'Data Kamar tidak dapat dihapus');
        redirect('manage/madin');
      }

      $this->Student_model->delete_madin($id);
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
      $this->session->set_flashdata('success', 'Hapus Kamar berhasil');
      redirect('manage/madin');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/madin/edit/' . $id);
    }  
  }
}
