<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_data_libur_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('presensi_data_libur/presensi_data_libur_model', 'setting/Setting_model'));
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
      $params['presensi_data_libur_search'] = $f['n'];
    } 

    $data['presensi_data_libur'] = $this->presensi_data_libur_model->get($params);
    $config['base_url'] = site_url('manage/presensi_data_libur');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Data Libur Presensi';
    $data['main'] = 'presensi_data_libur/presensi_data_libur_list';
    $this->load->view('manage/layout', $data);
  }

  public function export_excel(){
    $data['presensi_data_libur'] = $this->presensi_data_libur_model->get();
    $this->load->view('presensi_data_libur/presensi_data_libur_excel', $data);
  }


  // Update
  public function add($id = NULL) {

    $this->load->library('form_validation');
    $this->form_validation->set_rules('hari', 'Hari', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    $this->db->select('*');
    $data['day']=$this->db->get('day')->result_array();

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('id')) {
        $params['id'] = $id;
        $params['updated_date'] = date('Y-m-d H:i:s');
        $params['updated_by'] = $this->session->userdata('uid');
      } else {
        $params['created_date'] = date('Y-m-d H:i:s');
        $params['created_by'] = $this->session->userdata('uid');
      } 
      $params['hari'] = $this->input->post('hari'); 
      $params['keterangan'] = $this->input->post('keterangan'); 
      $status = $this->presensi_data_libur_model->add($params);

    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Data Libur Presensi',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('nama_area')
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Data Libur Presensi Berhasil');
      redirect('manage/presensi_data_libur');
    } else {
      if ($this->input->post('id')) {
        redirect('manage/presensi_data_libur/edit/' . $this->input->post('id'));
      }

    // Edit mode
      if (!is_null($id)) {
        $object = $this->presensi_data_libur_model->get(array('id' => $id));
        if ($object == NULL) {
        } else {
          $data['presensi_data_libur'] = $object;
        }
      }
      $data['setting_level'] = $this->Setting_model->get(array('id' => 7)); 
      $data['title'] = $data['operation'] . ' Data Libur Presensi';
      $data['main'] = 'presensi_data_libur/presensi_data_libur_edit';
      $this->load->view('manage/layout', $data);
    }
  }

  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    $presensi = $this->presensi_data_libur_model->get(array('id'=>$id));

    if ($_POST) {

      $this->presensi_data_libur_model->hapus($id);
    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Data Libur Presensi',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Data Libur Presensi berhasil');
      redirect('manage/presensi_data_libur');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/presensi_data_libur/edit/' . $id);
    }  
  }

  // View data detail
  public function view($id = NULL) {
    $data['presensi_data_libur'] = $this->presensi_data_libur_model->get(array('id' => $id));
    $data['title'] = 'Detail Data Libur Presensi';
    $data['main'] = 'presensi_data_libur/presensi_data_libur_view';
    $this->load->view('manage/layout', $data);
  }

}