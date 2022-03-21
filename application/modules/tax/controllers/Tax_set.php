<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('tax/Tax_model', 'setting/Setting_model'));
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
      $params['tax_name'] = $f['n'];
    }
    $data['tax'] = $this->Tax_model->get($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    $config['base_url'] = site_url('manage/tax/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Pajak';
    $data['main'] = 'tax/tax_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      $taxName = $_POST['tax_name'];
      $taxShort = $_POST['tax_number'];
      $cpt = count($_POST['tax_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['tax_name'] = $taxName[$i];
        $params['tax_number'] = $taxShort[$i];

        $this->Tax_model->add($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Pajak Berhasil');
    redirect('manage/tax');
  }

// Add User_customer and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('tax_name', 'Nama Pajak', 'trim|required|xss_clean');
    $this->form_validation->set_rules('tax_number', 'Singkatan Pajak', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('tax_id')) {
        $params['tax_id'] = $this->input->post('tax_id');
      }
      $params['tax_name'] = $this->input->post('tax_name');
      $params['tax_number'] = $this->input->post('tax_number');
      $status = $this->Tax_model->add($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Pajak');
      redirect('manage/tax');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('tax_id')) {
        redirect('manage/tax/edit/' . $this->input->post('tax_id'));
      }

            // Edit mode
      if (!is_null($id)) {
        $object = $this->Tax_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/tax');
        } else {
          $data['tax'] = $object;
        }
      }
      $data['title'] = $data['operation'] . ' Pajak';
      $data['main'] = 'tax/tax_add';
      $this->load->view('manage/layout', $data);
    }
  }

// Delete to database
  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    if ($_POST) {

      $this->Tax_model->delete($id);
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
      $this->session->set_flashdata('success', 'Hapus Pajak Sekolah berhasil');
      redirect('manage/tax');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/tax/edit/' . $id);
    }  
  }
}
