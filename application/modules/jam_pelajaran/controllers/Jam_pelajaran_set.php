<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jam_pelajaran_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('jam_pelajaran/Jam_pelajaran_model', 'setting/Setting_model'));
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
      $params['jam_pelajaran_name'] = $f['n'];
    }
    
    $data['jam_pelajaran'] = $this->Jam_pelajaran_model->get($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    
    $config['base_url'] = site_url('manage/jam_pelajaran/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    
    $data['title'] = 'Jam Pelajaran';
    $data['main'] = 'jam_pelajaran/jam_pelajaran_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      $jam_pelajaranName = $_POST['jam_pelajaran_name'];
      $jam_pelajaranStart = $_POST['jam_pelajaran_start'];
      $jam_pelajaranEnd = $_POST['jam_pelajaran_end'];
      $cpt = count($_POST['jam_pelajaran_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['jam_pelajaran_name'] = $jam_pelajaranName[$i];
        $params['jam_pelajaran_start'] = $jam_pelajaranStart[$i];
        $params['jam_pelajaran_end'] = $jam_pelajaranEnd[$i];

        $this->Jam_pelajaran_model->add($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Jam Pelajaran Berhasil');
    redirect('manage/jam_pelajaran');
  }
  
  public function add($id = NULL) {
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST) {

      if ($this->input->post('jam_pelajaran_id')) {
        $params['jam_pelajaran_id'] = $this->input->post('jam_pelajaran_id');
      }
      
      $params['jam_pelajaran_name'] = $this->input->post('jam_pelajaran_name');
      $params['jam_pelajaran_start'] = $this->input->post('jam_pelajaran_start');
      $params['jam_pelajaran_end'] = $this->input->post('jam_pelajaran_end');
      $status = $this->Jam_pelajaran_model->add($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Jam Pelajaran');
      redirect('manage/jam_pelajaran');
      
    } else {
      if ($this->input->post('jam_pelajaran_id')) {
        redirect('manage/jam_pelajaran/edit/' . $this->input->post('jam_pelajaran_id'));
      }

// Edit mode
      if (!is_null($id)) {
        $object = $this->Jam_pelajaran_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/jam_pelajaran');
        } else {
          $data['jam_pelajaran'] = $object;
        }
      }
      $data['title'] = $data['operation'] . ' Keterangan Jam Pelajaran';
      $data['main'] = 'jam_pelajaran/jam_pelajaran_add';
      $this->load->view('manage/layout', $data);
    }
  }


// Delete to database
  public function delete($id = NULL) {

    if ($_POST) {

      $this->Jam_pelajaran_model->delete($id);
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
      $this->session->set_flashdata('success', 'Hapus Jam Pelajaran berhasil');
      redirect('manage/jam_pelajaran');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/jam_pelajaran/edit/' . $id);
    }  
  }
}
