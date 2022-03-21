<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_data_area_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('presensi_data_area/Presensi_data_area_model', 'setting/Setting_model'));
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
      $params['presensi_data_area_search'] = $f['n'];
    } 

    $data['presensi_data_area'] = $this->Presensi_data_area_model->get($params);
    $config['base_url'] = site_url('manage/presensi_data_area');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Data Area Presensi';
    $data['main'] = 'presensi_data_area/presensi_data_area_list';
    $this->load->view('manage/layout', $data);
  }


  public function maps_area(){
    $id=base64_decode($this->input->get('id_area'));
    $params = array();
    $params['id']=$id;
    $data['presensi_data_area'] = $this->Presensi_data_area_model->get($params);
    $this->load->view('presensi_data_area/presensi_data_area_maps', $data);

  }

  public function maps_area_global(){
    $data['nama']=$this->input->get('nama');
    $data['longi']=$this->input->get('longi');
    $data['lati']=$this->input->get('lati');
    $this->load->view('presensi_data_area/presensi_data_area_maps_global', $data);

  }

  public function export_excel(){
    $data['presensi_data_area'] = $this->Presensi_data_area_model->get();
    $this->load->view('presensi_data_area/presensi_data_area_excel', $data);
  }


  // Update
  public function add($id = NULL) {

    $this->load->library('form_validation');
    $this->form_validation->set_rules('nama_area', 'Nama Area', 'trim|required|xss_clean');
    $this->form_validation->set_rules('longi', 'Longi', 'trim|required|xss_clean');
    $this->form_validation->set_rules('lati', 'Lati', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('id_area')) {
        $params['id_area'] = $id;
        $params['updated_date'] = date('Y-m-d H:i:s');
        $params['updated_by'] = $this->session->userdata('uid');
      } else {
        $params['created_date'] = date('Y-m-d H:i:s');
        $params['created_by'] = $this->session->userdata('uid');
      } 
      $params['nama_area'] = $this->input->post('nama_area'); 
      $params['longi'] = $this->input->post('longi'); 
      $params['lati'] = $this->input->post('lati'); 
      $params['remark'] = $this->input->post('remark'); 
      $status = $this->Presensi_data_area_model->add($params);

    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Data Area Presensi',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('nama_area')
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Data Area Presensi Berhasil');
      redirect('manage/presensi_data_area');
    } else {
      if ($this->input->post('id_area')) {
        redirect('manage/presensi_data_area/edit/' . $this->input->post('id_area'));
      }

    // Edit mode
      if (!is_null($id)) {
        $object = $this->Presensi_data_area_model->get(array('id' => $id));
        if ($object == NULL) {
        } else {
          $data['presensi_data_area'] = $object;
        }
      }
      $data['setting_level'] = $this->Setting_model->get(array('id' => 7)); 
      $data['title'] = $data['operation'] . ' Data Area Presensi';
      $data['main'] = 'presensi_data_area/presensi_data_area_edit';
      $this->load->view('manage/layout', $data);
    }
  }

  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    $presensi = $this->Presensi_data_area_model->get(array('id_area'=>$id));

    if ($_POST) {

      $this->Presensi_data_area_model->hapus($id);
    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Data Area Presensi',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Data Area Presensi berhasil');
      redirect('manage/presensi_data_area');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/presensi_data_area/edit/' . $id);
    }  
  }

  // View data detail
  public function view($id = NULL) {
    $data['presensi_data_area'] = $this->Presensi_data_area_model->get(array('id' => $id));
    $data['title'] = 'Detail Data Area Presensi';
    $data['main'] = 'presensi_data_area/presensi_data_area_view';
    $this->load->view('manage/layout', $data);
  }

}