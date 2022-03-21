<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('bulan/Bulan_model', 'schedule/Schedule_model', 'student/Student_model', 'lesson/Lesson_model', 'setting/Setting_model'));
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
    $param = array();
    
    
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '' && $f['n'] != '0') {
          $params['majors_id']      = $f['n'];
          $param['majors_id']       = $f['n'];
          $data['class']            = $this->db->query("SELECT * FROM class JOIN majors ON majors.majors_id = class.majors_majors_id WHERE majors_majors_id = '".$f['n']."'")->result_array();      
        }
    
        if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
          $params['class_id']    = $f['r'];
        }
    
    $data['day']            = $this->Bulan_model->get_day();
    $data['lesson']         = $this->Lesson_model->get($param);
    $data['schedules']      = $this->Schedule_model->get($params);
    $data['setting_logo']   = $this->Setting_model->get(array('id' => 6));
    $config['base_url']     = site_url('manage/schedule/index');
    $config['suffix']       = '?' . http_build_query($_GET, '', "&");
    
    $data['majors']     = $this->Student_model->get_majors();
    
    $data['title'] = 'Jadwal Pelajaran';
    $data['main'] = 'schedule/schedule_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      
      $scheduleMajors   = $_POST['schedule_majors_id'];  
      $scheduleClass    = $_POST['schedule_class_id'];
      $scheduleLesson   = $_POST['schedule_lesson'];
      $scheduleDay      = $_POST['schedule_day'];
      $scheduleStart    = $_POST['schedule_start'];
      $scheduleEnd      = $_POST['schedule_end'];
      
      $cpt = count($_POST['schedule_lesson']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['schedule_class_id'] = $scheduleClass;
        $params['schedule_day'] = $scheduleDay;
        $params['schedule_lesson_id'] = $scheduleLesson[$i];
        $params['schedule_time'] = $scheduleStart[$i] . ' - ' . $scheduleEnd[$i];
        $this->Schedule_model->add($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Jadwal Pelajaran Berhasil');
    redirect('manage/schedule?n=' . $scheduleMajors . '&r=' . $scheduleClass);
  }

// Add User_customer and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('schedule_class_id', 'Nama Jadwal Pelajaran', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('schedule_id')) {
        $params['schedule_id'] = $this->input->post('schedule_id');
      }
      $params['schedule_class_id'] = $this->input->post('schedule_class_id');
      $status = $this->Schedule_model->add($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Jadwal Pelajaran');
      redirect('manage/schedule');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('schedule_id')) {
        redirect('manage/schedule/edit/' . $this->input->post('schedule_id'));
      }

// Edit mode
      if (!is_null($id)) {
        $object = $this->Schedule_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/schedule');
        } else {
          $data['schedule'] = $object;
        }
      }
      $data['title'] = $data['operation'] . ' Keterangan Jadwal Pelajaran';
      $data['main'] = 'schedule/schedule_add';
      $this->load->view('manage/layout', $data);
    }
  }


// Delete to database
  public function delete($id = NULL) {

    if ($_POST) {
        
        $majors_id  = $this->input->post('majors_id');
        $class_id   = $this->input->post('class_id');

        $this->Schedule_model->delete($id);
        $this->session->set_flashdata('success', 'Hapus Jadwal Pelajaran berhasil');
        redirect('manage/schedule?n=' . $majors_id . '&r=' . $class_id);
    } elseif (!$_POST) {
        $this->session->set_flashdata('delete', 'Gagal Menghapus Jadwal Pelajaran');
        redirect('manage/schedule');
    }  
  }
    
    function find_class(){
	    $id_majors = $this->input->post('id_majors');
        $class = $this->db->query("SELECT * FROM class WHERE majors_majors_id = '$id_majors'")->result_array();
    
        echo '<label for="" class="col-sm-2 control-label">Kelas</label>
				<div class="col-sm-2">
					<select class="form-control" name="r" id="kas_account_id">
					    <option  value="">-- Pilih Kelas --</option>';
						foreach ($class as $row){
							echo '<option  value="'.$row['class_id'].'">'.$row['class_name'].'</option>';
						}
						
					echo '</select>
					
				</div>
		        <span class="input-group-btn">
				<button class="btn btn-success" type="submit">Cari</button>
				</span>';
	}
}
