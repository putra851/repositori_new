<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prove_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('prove/Prove_model', 'setting/Setting_model', 'student/Student_model'));
    $this->load->helper(array('form', 'url'));
  }

    // User_customer view in list
  public function index($offset = NULL) {
    $this->load->library('pagination');
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->get(NULL, TRUE);
    $s = $this->input->get(NULL, TRUE);

    $data['f'] = $f;
    $data['s'] = $s;

    $params = array();
    $param = array();
    // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['prove_search'] = $f['n'];
    }
    
    if (isset($s['c']) && !empty($s['c']) && $s['c'] != 'all') {
      $params['class_id'] = $s['c'];
    } else if (isset($s['c']) && !empty($s['c']) && $s['c'] == 'all') {
      
    }
    
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != '') {
      $params['majors_id'] = $s['m'];
      
        if ($s['s'] != '1') {
            $params['status'] = $s['s'];
        } else {
            $params['status']   = '1';    
        }
    }

    $data['prove']      = $this->Prove_model->get($params);
    $data['majors']     = $this->Student_model->get_majors();
    $data['class']      = $this->Student_model->get_class($params);

    $config['base_url'] = site_url('manage/prove/index');
    $config['suffix']   = '?' . http_build_query($_GET, '', "&");
    

    $data['title'] = 'Bukti Bayar Transfer';
    $data['main'] = 'prove/prove_list';
    $this->load->view('manage/layout', $data);
  }
  
  function class_searching(){
	    $id_majors = $this->input->post('id_majors');
        $dataKelas  = $this->db->query("SELECT * FROM class WHERE majors_majors_id = '$id_majors' ORDER BY class_name ASC")->result_array();
    
        echo '<select style="width: 200px;" id="c" name="c" class="form-control" required>
    			<option value="">--- Pilih Kelas ---</option>
    			<option value="all">Semua Kelas</option>';
              foreach($dataKelas as $row){ 

                echo '<option value="'.$row['class_id'].'">';
                    
                echo $row['class_name'];
                    
                echo '</option>';
            
                }
        echo '</select>';
	}
	
	public function approve($id = NULL) {
          
          $params['prove_id']           = $id; 
          $params['prove_note']         = "Terima kasih, pembayaran Telah Diverifikasi";
          $params['prove_status']       = '1';
          
          $status = $this->Prove_model->add($params);
    
          $this->session->set_flashdata('success', 'Transaksi Berhasil Diverifkasi');
          
          redirect('manage/prove');
    
    }
	
	public function ignore($id = NULL) {
          
          $params['prove_id']           = $id; 
          $params['prove_note']         = "Mohon maaf, bukti transfer kami tolak karena tidak sesuai";
          $params['prove_status']       = '3';
          
          $status = $this->Prove_model->add($params);
    
          $this->session->set_flashdata('success', 'Transaksi Berhasil Ditolak');
          
          redirect('manage/prove');
    
    }
	
    // Setting Upload File Requied
  function do_upload($name=NULL, $fileName=NULL) {
    $this->load->library('upload');

    $config['upload_path'] = FCPATH . 'uploads/prove/';

    /* create directory if not exist */
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }

    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '1024';
    $config['file_name'] = $fileName;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($name)) {
      $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
      redirect(uri_string());
    }

    $upload_data = $this->upload->data();

    return $upload_data['file_name'];
  }

}