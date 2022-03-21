<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Semester_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('semester/Semester_model', 'setting/Setting_model', 'period/Period_model'));
    $this->load->helper(array('form', 'url'));
  }

  public function index($offset = NULL) {
    $this->load->library('pagination');
    
    $s = $this->input->get(NULL, TRUE);
    $f = $this->input->get(NULL, TRUE);

    $data['s'] = $s;
    $data['f'] = $f;

    $params = array();
    
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['semester_name'] = $f['n'];
    }
    
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != 'all') {
      $params['period_id'] = $s['m'];
    }else if (isset($s['m']) && !empty($s['m']) && $s['m'] == 'all') {
    }
    
    $data['semester'] = $this->Semester_model->get($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    
    $config['base_url'] = site_url('manage/semester/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    
    $data['period'] = $this->Period_model->get();
    
    $data['title'] = 'Semester';
    $data['main'] = 'semester/semester_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      $semesterName = $_POST['semester_name'];
      $semesterPeriodId = $_POST['semester_period_id'];
      $cpt = count($_POST['semester_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['semester_name'] = $semesterName[$i];
        $params['semester_period_id'] = $semesterPeriodId;

        $this->Semester_model->add($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Semester Berhasil');
    redirect('manage/semester');
  }
  
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('semester_name', 'Nama Semester', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('semester_id')) {
        $params['semester_id'] = $this->input->post('semester_id');
      }
      $params['semester_name'] = $this->input->post('semester_name');
      $params['semester_period_id'] = $this->input->post('semester_period_id');
      $status = $this->Semester_model->add($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Semester');
      redirect('manage/semester');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('semester_id')) {
        redirect('manage/semester/edit/' . $this->input->post('semester_id'));
      }

// Edit mode
      if (!is_null($id)) {
        $object = $this->Semester_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/semester');
        } else {
          $data['semester'] = $object;
        }
      }
      $data['period'] = $this->Period_model->get();
      $data['title'] = $data['operation'] . ' Keterangan Semester';
      $data['main'] = 'semester/semester_add';
      $this->load->view('manage/layout', $data);
    }
  }


// Delete to database
  public function delete($id = NULL) {

    if ($_POST) {

      $this->Semester_model->delete($id);
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
      $this->session->set_flashdata('success', 'Hapus Semester berhasil');
      redirect('manage/semester');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/semester/edit/' . $id);
    }  
  }
}
