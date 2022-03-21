<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('lesson/Lesson_model', 'setting/Setting_model', 'student/Student_model', 'employees/Employees_model', 'schedule/Schedule_model'));
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
    $param  = array();
    
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['lesson_name'] = $f['n'];
    }
    
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != '') {
      $params['majors_id'] = $s['m'];
      $param['id'] = $s['m'];
    }
    
    $data['majors'] = $this->Student_model->get_majors($params);
    $data['unit'] = $this->Student_model->get_majors($param);
    $data['employee'] = $this->Employees_model->get($params);
    $data['lessons'] = $this->Lesson_model->get($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    $config['base_url'] = site_url('manage/lesson/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    
    $data['title'] = 'Mata Pelajaran';
    $data['main'] = 'lesson/lesson_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      $lessonCode    = $_POST['lesson_code'];
      $lessonName    = $_POST['lesson_name'];
      $lessonTeacher = $_POST['lesson_teacher'];
      $lessonMajors  = $_POST['lesson_majors_id'];
      $cpt = count($_POST['lesson_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['lesson_code']      = $lessonCode[$i];
        $params['lesson_name']      = $lessonName[$i];
        $params['lesson_teacher']   = $lessonTeacher[$i];
        $params['lesson_majors_id'] = $lessonMajors;

        $this->Lesson_model->add($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Mata Pelajaran Berhasil');
    redirect('manage/lesson?m=' . $lessonMajors);
  }

// Add User_customer and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('lesson_name', 'Nama Mata Pelajaran', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('lesson_id')) {
        $params['lesson_id'] = $this->input->post('lesson_id');
      }
      $params['lesson_name'] = $this->input->post('lesson_name');
      $status = $this->Lesson_model->add($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Mata Pelajaran');
      redirect('manage/lesson');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('lesson_id')) {
        redirect('manage/lesson/edit/' . $this->input->post('lesson_id'));
      }

// Edit mode
      if (!is_null($id)) {
        $object = $this->Lesson_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/lesson');
        } else {
          $data['lesson']   = $object;
          $data['majors']   = $this->Student_model->get_majors($params);
        }
      }
      
      $data['title'] = $data['operation'] . ' Keterangan Mata Pelajaran';
      $data['main'] = 'lesson/lesson_add';
      $this->load->view('manage/layout', $data);
    }
  }


// Delete to database
  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    
    $jadwal = $this->Schedule_model->get(array('schedule_lesson_id'=>$id));

    if ($_POST) {
        
      $lessonMajors  = $_POST['lesson_majors_id'];

      if (count($jadwal) > 0) {
        $this->session->set_flashdata('failed', 'Mata Pelajaran tidak dapat dihapus karena sudah dimasukkan ke dalam jadwal pelajaran');
        redirect('manage/lesson?m=' . $lessonMajors);
      }

      $this->Lesson_model->delete($id);
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
      $this->session->set_flashdata('success', 'Hapus Mata Pelajaran berhasil');
      redirect('manage/lesson?m=' . $lessonMajors);
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/lesson/edit/' . $id);
    }  
  }
}
