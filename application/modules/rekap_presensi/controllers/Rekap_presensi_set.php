<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_presensi_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('rekap_presensi/Rekap_presensi_model','student/Student_model', 'setting/Setting_model'));
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
      $params['rekap_presensi_search'] = $f['n'];
    }
    
    $data['tgl_awal']=date('Y-m-d');
    $data['tgl_akhir']=date('Y-m-d');
    if(isset($f['tgl_awal']) || isset($f['tgl_akhir'])){
      $data['tgl_awal']=$f['tgl_awal'];
      $data['tgl_akhir']=$f['tgl_akhir'];
      if($f['tgl_awal'] > $f['tgl_akhir']){
        echo "<script>alert('Tanggal Awal Lebih Besar Dari Tanggal Akhir')</script>";
        $data['tgl_awal']=$f['tgl_akhir'];
      }
      $params['tgl_awal']=$f['tgl_awal'];
      $params['tgl_akhir']=$f['tgl_akhir'];
    }

    if (isset($f['m']) && !empty($f['m']) && $f['m'] != '') {
      $params['majors_id'] = $f['m'];
    }

    $data['rekap_presensi'] = $this->Rekap_presensi_model->get($params);
    $data['majors'] = $this->Student_model->get_majors();
    $config['base_url'] = site_url('manage/rekap_presensi');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Rekap Presensi Di WEB';
    $data['main'] = 'rekap_presensi/rekap_presensi_list';
    $this->load->view('manage/layout', $data);
  }

  public function export_excel(){
    $f = $this->input->get(NULL, TRUE);

    $data['f']=$f;

    $params = array();

    if (isset($f['majors_id']) && !empty($f['majors_id']) && $f['majors_id'] != '') {
      $params['majors_id'] = $f['majors_id'];
    }
    
    $data['tgl_awal']=date('Y-m-d');
    $data['tgl_akhir']=date('Y-m-d');
    if(isset($f['tgl_awal']) || isset($f['tgl_akhir'])){
      $data['tgl_awal']=$f['tgl_awal'];
      $data['tgl_akhir']=$f['tgl_akhir'];
      $params['tgl_awal']=$f['tgl_awal'];
      $params['tgl_akhir']=$f['tgl_akhir'];
    }
    $data['rekap_absensi'] = $this->Rekap_presensi_model->rekap();
    $this->load->view('rekap_presensi/rekap_presensi_excel', $data);
  }
  
  public function export_pdf(){
    $this->load->helper(array('dompdf'));
    $f = $this->input->get(NULL, TRUE);

    $data['f']=$f;

    $params = array();

    if (isset($f['majors_id']) && !empty($f['majors_id']) && $f['majors_id'] != '') {
      $params['majors_id'] = $f['majors_id'];
    }
    
    $data['tgl_awal']=date('Y-m-d');
    $data['tgl_akhir']=date('Y-m-d');
    if(isset($f['tgl_awal']) || isset($f['tgl_akhir'])){
      $data['tgl_awal']=$f['tgl_awal'];
      $data['tgl_akhir']=$f['tgl_akhir'];
      $params['tgl_awal']=$f['tgl_awal'];
      $params['tgl_akhir']=$f['tgl_akhir'];
    }
    $data['rekap_absensi'] = $this->Rekap_presensi_model->rekap();

    $html = $this->load->view('rekap_presensi/rekap_presensi_pdf', $data, TRUE);
    $data = pdf_create($html, 'Rekap_Presensi_'.$f['tgl_awal'].'_sd_'.$f['tgl_akhir'], TRUE, 'A4', 'landscape');
  }

  public function rekap(){
    $f = $this->input->get(NULL, TRUE);

    $data['f']=$f;

    $params = array();

    if (isset($f['majors_id']) && !empty($f['majors_id']) && $f['majors_id'] != '') {
      $params['majors_id'] = $f['majors_id'];
    }
    
    $data['tgl_awal']=date('Y-m-d');
    $data['tgl_akhir']=date('Y-m-d');
    if(isset($f['tgl_awal']) || isset($f['tgl_akhir'])){
      $data['tgl_awal']=$f['tgl_awal'];
      $data['tgl_akhir']=$f['tgl_akhir'];
      $params['tgl_awal']=$f['tgl_awal'];
      $params['tgl_akhir']=$f['tgl_akhir'];
    }
    $data['rekap_absensi'] = $this->Rekap_presensi_model->rekap();
    $this->load->view('rekap_presensi/rekap_presensi_rekap',$data);
  }

  public function rekap_detil(){
    $f = $this->input->get(NULL, TRUE);

    $data['f']=$f;

    $params = array();

    if (isset($f['employee_id']) && !empty($f['employee_id']) && $f['employee_id'] != '') {
      $params['employee_id'] = $f['employee_id'];
    }

    // $params['group']='id_pegawai';
    
    $data['tgl_awal']=date('Y-m-d');
    $data['tgl_akhir']=date('Y-m-d');
    if(isset($f['tgl_awal']) || isset($f['tgl_akhir'])){
      $data['tgl_awal']=$f['tgl_awal'];
      $data['tgl_akhir']=$f['tgl_akhir'];
      $params['tgl_awal']=$f['tgl_awal'];
      $params['tgl_akhir']=$f['tgl_akhir'];
    }
    $data['rekap_absensi_detil'] = $this->Rekap_presensi_model->get_rekap($params);
    $this->load->view('rekap_presensi/rekap_presensi_rekap_detil',$data);
  }

  // View data detail
  public function view($id = NULL) {
    $data['rekap_presensi'] = $this->Rekap_presensi_model->get(array('id' => $id));
    $data['title'] = 'Detail Rekap Presensi';
    $data['main'] = 'rekap_presensi/rekap_presensi_view';
    $this->load->view('manage/layout', $data);
  }

  // Update
  public function add($id = NULL) {

    $this->load->library('form_validation');
    $this->form_validation->set_rules('type', 'Jenis', 'trim|required|xss_clean');
    $this->form_validation->set_rules('id_pegawai', 'Pegawai', 'trim|required|xss_clean');
    $this->form_validation->set_rules('image', 'Foto', 'trim|required|xss_clean');
    $this->form_validation->set_rules('longi', 'Longi', 'trim|required|xss_clean');
    $this->form_validation->set_rules('lati', 'Lati', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';
    $f = $this->input->get(NULL, TRUE);
    $data['f']=$f;
    $data['employee']=$this->db->get('employee')->result_array();

    if ($_POST AND $this->form_validation->run() == TRUE) {

      $params['created_date'] = date('Y-m-d H:i:s');
      $params['created_by'] = $this->session->userdata('uid');
      $params['type'] = $this->input->post('type'); 
      $params['id_pegawai'] = $this->input->post('id_pegawai'); 
      $params['image'] = base64_decode($this->input->post('image')); 
      $params['longi'] = $this->input->post('longi'); 
      $params['lati'] = $this->input->post('lati'); 
      $params['keterangan'] = $this->input->post('keterangan'); 

      // var_dump($params);

      $this->load->library('curl');     
      $this->curl->create("https://demo.epesantren.co.id/rest-api/fileupload.php");
      $this->curl->post(array(
          'id_pegawai' => $this->input->post('id_pegawai'),
          'type' => $this->input->post('type'),
          'image' => $this->input->post('image'),
          'longi' => $this->input->post('longi'),
          'lati' => $this->input->post('lati'),
          'keterangan' => $this->input->post('keterangan')
      ));
      $result = json_decode($this->curl->execute());
      $status=1;

      if($result->error==false){
        // activity log
        $this->load->model('logs/Logs_model');
        $this->Logs_model->add(
          array(
            'log_date' => date('Y-m-d H:i:s'),
            'user_id' => $this->session->userdata('uid'),
            'log_module' => 'Tambah Presensi WEB',
            'log_action' => $data['operation'],
            'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('jenis')
          )
        );

        $this->session->set_flashdata('success', $data['operation'] . ' Presensi WEB Berhasil');
      }else{
        $this->session->set_flashdata('failed', $data['operation'] . ' Presensi WEB Gagal');
      }
      redirect('manage/rekap_presensi');
    } else {
      $data['setting_level'] = $this->Setting_model->get(array('id' => 7)); 
      $data['title'] = $data['operation'] . ' Presensi WEB';
      $data['main'] = 'rekap_presensi/rekap_presensi_add';
      $this->load->view('manage/layout', $data);
    }
  }

}