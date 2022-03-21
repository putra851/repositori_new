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
      $itemName         = $_POST['item_name'];
      $majorsMajorsId   = $_POST['item_majors_id'];
      
      $q = $this->db->query("SELECT majors_short_name FROM majors WHERE majors_id = '$majorsMajorsId'")->row_array();
      
      $cpt = count($_POST['item_name']);
      for ($i = 0; $i < $cpt; $i++) {
        $params['item_majors_id']   = $majorsMajorsId;
        $params['item_name']        = $itemName[$i] . ' ' . $q['majors_short_name'];

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
    
    $cek_pos_debit  = $this->db->query('SELECT * FROM pos_debit');
    $cek_pos_kredit = $this->db->query('SELECT * FROM pos_kredit');
    
    if($cek_pos_debit->num_rows() > 0 && $cek_pos_kredit->num_rows() > 0){
      $this->session->set_flashdata('failed', 'Gagal Hapus Unit POS. Masih Ada Setting yang Belum Dihapus');
      redirect('manage/item');
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
  
  public function view_item($id = NULL){
      

        $params = array();
        
        $item = $this->db->query("SELECT item_name, item_majors_id FROM item WHERE item_id = $id")->row_array();
        
        $majors_id = $item['item_majors_id'];
        
        $params['item_id'] = $id;
        
        $data['account_debit']  = $this->db->query("SELECT account_id, account_code, account_description FROM account WHERE account_category != 0 AND account_code LIKE '4-4%' AND account_majors_id = '$majors_id' ORDER BY account_code ASC")->result_array();
        
        $data['account_kredit'] = $this->db->query("SELECT account_id, account_code, account_description FROM account WHERE account_category != 0 AND account_code LIKE '5-5%' AND account_majors_id = '$majors_id' ORDER BY account_code ASC")->result_array();
        
        $data['debit_list']   = $this->Item_model->get_debit($params);
        $data['kredit_list']  = $this->Item_model->get_kredit($params);
        
        $data['judul']    = $item['item_name'];
        $data['title']    = 'Setting Unit POS';
        $data['main']     = 'item/item_view';
        
        $this->load->view('manage/layout', $data);
      
  }

  public function add_glob_debit(){
    if ($_POST == TRUE) {
      $itemID           = $_POST['item_id'];
      $itemAccountID    = $_POST['item_account_id'];
      
      $cpt = count($_POST['item_account_id']);
      for ($i = 0; $i < $cpt; $i++) {
          
        $params['pos_debit_item_id']    = $itemID;
        $params['pos_debit_account_id'] = $itemAccountID[$i];

        $this->Item_model->add_debit($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Akun POS Pendapatan Berhasil');
    redirect('manage/item/view_item/' . $itemID);
  }

  public function add_glob_kredit(){
    if ($_POST == TRUE) {
      $itemID           = $_POST['item_id'];
      $itemAccountID    = $_POST['item_account_id'];
      
      $cpt = count($_POST['item_account_id']);
      for ($i = 0; $i < $cpt; $i++) {
          
        $params['pos_kredit_item_id']    = $itemID;
        $params['pos_kredit_account_id'] = $itemAccountID[$i];

        $this->Item_model->add_kredit($params);
      }
    }
    $this->session->set_flashdata('success',' Tambah Akun POS Beban Berhasil');
    redirect('manage/item/view_item/' . $itemID);
  }
  
  public function delete_debit($id = NULL) {
      
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    $itemID = $this->input->post('item_id');
    $this->Item_model->delete_debit($id);
    $this->session->set_flashdata('failed',' Hapus Akun POS Pendapatan Berhasil');
    redirect('manage/item/view_item/' . $itemID);
    
  }
  
  public function delete_kredit($id = NULL) {
      
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    $itemID = $this->input->post('item_id');
    $this->Item_model->delete_kredit($id);
    $this->session->set_flashdata('failed',' Hapus Akun POS Beban Berhasil');
    redirect('manage/item/view_item/' . $itemID);
  }
  
}
