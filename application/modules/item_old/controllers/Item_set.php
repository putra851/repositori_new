<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('item/Item_model', 'student/Student_model', 'setting/Setting_model'));
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
      $params['item_name'] = $f['n'];
    }
    
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != 'all') {
      $params['majors_id'] = $s['m'];
    }else if (isset($s['m']) && !empty($s['m']) && $s['m'] == 'all') {
      //$params['majors_id'] = $s['m'];
    }
    $data['item'] = $this->Item_model->get($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    $config['base_url'] = site_url('manage/item/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    //$this->pagination->initialize($config);
    $data['majors'] = $this->Student_model->get_majors();
    
    $data['title'] = 'Unit POS';
    $data['main'] = 'item/item_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
      $itemName = $_POST['item_name'];
      $majorsMajorsId = $_POST['item_majors_id'];
      $cpt = count($_POST['item_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['item_name'] = $itemName[$i];
        $params['item_majors_id'] = $majorsMajorsId[$i];

        $this->Item_model->add($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Unit POS Berhasil');
    redirect('manage/item');
  }

// Add User_customer and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('item_name', 'Nama Unit POS', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('item_id')) {
        $params['item_id'] = $this->input->post('item_id');
      }
      $params['item_name'] = $this->input->post('item_name');
      $params['item_majors_id'] = $this->input->post('item_majors_id');
      $status = $this->Item_model->add($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Unit POS');
      redirect('manage/item');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('item_id')) {
        redirect('manage/item/edit/' . $this->input->post('item_id'));
      }

// Edit mode
      if (!is_null($id)) {
        $object = $this->Item_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/item');
        } else {
          $data['item'] = $object;
        }
      }
      $data['majors'] = $this->Student_model->get_majors();
      $data['title'] = $data['operation'] . ' Keterangan Unit POS';
      $data['main'] = 'item/item_add';
      $this->load->view('manage/layout', $data);
    }
  }


// Delete to database
  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }

    if ($_POST) {

      $this->Item_model->delete($id);
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
      $this->session->set_flashdata('success', 'Hapus Unit POS berhasil');
      redirect('manage/item');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/item/edit/' . $id);
    }  
  }
}
