<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_khusus_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('presensi_khusus/Presensi_khusus_model', 'setting/Setting_model'));
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
      $params['presensi_khusus_search'] = $f['n'];
    } 

    $data['presensi_khusus'] = $this->Presensi_khusus_model->get($params);
    $config['base_url'] = site_url('manage/presensi_khusus');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Presensi Khusus';
    $data['main'] = 'presensi_khusus/presensi_khusus_list';
    $this->load->view('manage/layout', $data);
  }

  public function export_excel(){
    $data['presensi_khusus'] = $this->Presensi_khusus_model->get();
    $this->load->view('presensi_khusus/presensi_khusus_excel', $data);
  }


  // Update
  public function add($id = NULL) {

    $this->load->library('form_validation');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required|xss_clean');
    $this->form_validation->set_rules('id_pegawai', 'Pegawai', 'trim|required|xss_clean');
    $this->form_validation->set_rules('lokasi_absen', 'Lokasi Absen', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('id')) {
        $params['id'] = $id;
        $params['updated_date'] = date('Y-m-d H:i:s');
        $params['updated_by'] = $this->session->userdata('uid');
      } else {
        $params['created_date'] = date('Y-m-d H:i:s');
        $params['created_by'] = $this->session->userdata('uid');
      } 
      $params['tanggal'] = $this->input->post('tanggal'); 
      $params['id_pegawai'] = $this->input->post('id_pegawai'); 
      $params['lokasi_absen'] = $this->input->post('lokasi_absen'); 
      $params['remark'] = $this->input->post('remark'); 
      $status = $this->Presensi_khusus_model->add($params);

    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Presensi Khusus',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('id_pegawai')
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Presensi Khusus Berhasil');
      redirect('manage/presensi_khusus');
    } else {
      if ($this->input->post('id')) {
        redirect('manage/presensi_khusus/edit/' . $this->input->post('id'));
      }

    // Edit mode
      if (!is_null($id)) {
        $object = $this->Presensi_khusus_model->get(array('id' => $id));
        if ($object == NULL) {
        } else {
          $data['presensi_khusus'] = $object;
        }
      }
      $this->load->model('employees/Employees_model');
      $data['id_pegawai'] = $this->Employees_model->get();

      $this->load->model('presensi_data_area/Presensi_data_area_model');
      $data['lokasi_absen'] = $this->Presensi_data_area_model->get();
      
      $data['setting_level'] = $this->Setting_model->get(array('id' => 7)); 
      $data['title'] = $data['operation'] . ' Presensi Khusus';
      $data['main'] = 'presensi_khusus/presensi_khusus_edit';
      $this->load->view('manage/layout', $data);
    }
  }

  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    $presensi = $this->Presensi_khusus_model->get(array('id'=>$id));

    if ($_POST) {

      $this->Presensi_khusus_model->hapus($id);
    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Presensi Khusus',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Presensi Khusus berhasil');
      redirect('manage/presensi_khusus');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/presensi_khusus/edit/' . $id);
    }  
  }

  // View data detail
  public function view($id = NULL) {
    $data['presensi_khusus'] = $this->Presensi_khusus_model->get(array('id' => $id));
    $data['title'] = 'Detail Presensi Khusus';
    $data['main'] = 'presensi_khusus/presensi_khusus_view';
    $this->load->view('manage/layout', $data);
  }

}