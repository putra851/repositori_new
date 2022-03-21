<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_waktu_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('presensi_waktu/Presensi_waktu_model', 'setting/Setting_model', 'student/Student_model'));
    $this->load->helper(array('form', 'url'));
  }

  public function index() {
    $this->load->library('pagination');
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->post(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
    $param = array();
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['presensi_waktu_search'] = $f['n'];
    } 
    
    $data['majors'] = $this->Student_model->get_majors();
    //$data['presensi_waktu'] = $this->Presensi_waktu_model->get($params);
    $config['base_url'] = site_url('manage/presensi_waktu');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Data Jam Masuk & Pulang';
    $data['main'] = 'presensi_waktu/presensi_waktu_list';
    $this->load->view('manage/layout', $data);
  }

  public function export_excel(){
    $data['presensi_waktu'] = $this->Presensi_waktu_model->get();
    $this->load->view('presensi_waktu/presensi_waktu_excel', $data);
  }


  // Update
  public function add($id = NULL) {

    $this->load->library('form_validation');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    $this->db->select('*');
    $data['day']=$this->db->get('day')->result_array();
    $data['majors']=$this->db->get('majors')->result_array();

    if ($_POST) {
      
      $majors   = $_POST['data_waktu_majors_id'];
      $day      = $_POST['data_waktu_day_id'];
      $masuk    = $_POST['data_waktu_masuk'];
      $pulang   = $_POST['data_waktu_pulang'];
      
      $count = count($day);
      
      for($i = 0; $i < $count; $i++){
          
          $params['data_waktu_majors_id'] = $majors;
          $params['data_waktu_day_id'] = $day[$i];
          $params['data_waktu_masuk'] = $masuk[$i];
          $params['data_waktu_pulang'] = $pulang[$i];
          
          $this->Presensi_waktu_model->add($params);
          
      }
      $this->session->set_flashdata('success', $data['operation'] . ' Data Jam Masuk & Pulang Berhasil');
      redirect('manage/presensi_waktu');
    } else {
      
      $data['title'] = $data['operation'] . ' Data Jam Masuk & Pulang';
      $data['main'] = 'presensi_waktu/presensi_waktu_add';
      $this->load->view('manage/layout', $data);
    }
  }
  
  public function edit_batch($id = NULL) {

    $this->load->library('form_validation');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    $this->db->select('*');
    $data['day']=$this->db->get('day')->result_array();
    $data['majors']=$this->db->get('majors')->result_array();

    if ($_POST) {
      
      $majors   = $_POST['data_waktu_majors_id'];
      $day      = $_POST['data_waktu_day_id'];
      $masuk    = $_POST['data_waktu_masuk'];
      $pulang   = $_POST['data_waktu_pulang'];
      
      $count = count($day);
      
      for($i = 0; $i < $count; $i++){
        
        $this->db->query("UPDATE data_waktu SET data_waktu_masuk = '$masuk[$i]', data_waktu_pulang = '$pulang[$i]' WHERE data_waktu_majors_id = '$majors' AND data_waktu_day_id = '$day[$i]'");
          
      }
      
      $this->session->set_flashdata('success', $data['operation'] . ' Data Jam Masuk & Pulang Berhasil');
      redirect('manage/presensi_waktu');
    } else {
        
    // Edit mode
      if (!is_null($id)) {
        $object = $this->Student_model->get_majors(array('id' => $id));
        if ($object == NULL) {
        } else {
          $data['majors'] = $object;
        }
      }
      
      $data['title'] = $data['operation'] . ' Data Jam Masuk & Pulang';
      $data['main'] = 'presensi_waktu/presensi_waktu_edit_batch';
      $this->load->view('manage/layout', $data);
    }
  }
  
  public function edit_one($id = NULL){
      
        $this->load->library('form_validation');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';
        
        if ($_POST) {
            
          if ($this->input->post('data_waktu_id')) {
            $params['data_waktu_id'] = $id;
          }
          
          $masuk    = $_POST['data_waktu_masuk'];
          $pulang   = $_POST['data_waktu_pulang'];
          
          $params['data_waktu_masuk'] = $masuk;
          $params['data_waktu_pulang'] = $pulang;
          
          $this->Presensi_waktu_model->add($params);
          
          $this->session->set_flashdata('success', $data['operation'] . ' Data Jam Masuk & Pulang Berhasil');
          redirect('manage/presensi_waktu');

        } else {
            // Edit mode
              if (!is_null($id)) {
                $object = $this->Presensi_waktu_model->get(array('data_waktu_id' => $id));
                if ($object == NULL) {
                } else {
                  $data['presensi_waktu'] = $object;
                }
              }
              
              $data['title'] = $data['operation'] . ' Data Jam Masuk & Pulang';
              $data['main'] = 'presensi_waktu/presensi_waktu_edit_one';
              $this->load->view('manage/layout', $data);
        }
  }

  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    $presensi = $this->Presensi_waktu_model->get(array('data_waktu_id'=>$id));

    if ($_POST) {

      $this->Presensi_waktu_model->hapus($id);
    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Data Jam Masuk & Pulang',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Data Jam Masuk & Pulang berhasil');
      redirect('manage/presensi_waktu');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/presensi_waktu/edit/' . $id);
    }  
  }

  public function delete_batch($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }

    if ($_POST) {

      $this->db->query("DELETE FROM data_waktu WHERE data_waktu_majors_id = '$id'");
    // activity log
    //   $this->load->model('logs/Logs_model');
    //   $this->Logs_model->add(
    //     array(
    //       'log_date' => date('Y-m-d H:i:s'),
    //       'user_id' => $this->session->userdata('uid'),
    //       'log_module' => 'Data Jam Masuk & Pulang',
    //       'log_action' => 'Hapus',
    //       'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
    //     )
    //   );
      $this->session->set_flashdata('success', 'Hapus Data Jam Masuk & Pulang untuk Satu Unit berhasil');
      redirect('manage/presensi_waktu');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/presensi_waktu/edit/' . $id);
    }  
  }

  // View data detail
  public function view($id = NULL) {
    $data['presensi_waktu'] = $this->Presensi_waktu_model->get(array('data_waktu_id' => $id));
    $data['title'] = 'Detail Data Jam Masuk & Pulang';
    $data['main'] = 'presensi_waktu/presensi_waktu_view';
    $this->load->view('manage/layout', $data);
  }

}