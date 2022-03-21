<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi_area_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('presensi_area/Presensi_area_model','position/Position_model', 'student/Student_model', 'setting/Setting_model'));
    $this->load->helper(array('form', 'url'));
  }

  public function index() {
    $this->load->library('pagination');
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->post(NULL, TRUE);
    $s = $this->input->post(NULL, TRUE);

    $data['f'] = $f;
    $data['s'] = $s;

    $params = array();
    $param = array();
    // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['presensi_area_search'] = $f['n'];
    } 
    if (isset($s['m']) && !empty($s['m']) && $s['m'] != '') {
      $params['majors_id'] = $s['m'];
    }
    if (isset($s['p']) && !empty($s['p']) && $s['p'] != '') {
      $params['employee_position_id'] = $s['p'];
    }

    if(isset($s['act_lock'])){
      $act=$s['act_lock'];
      $id_p=$s['id_p'];
      $set=array(
        'status_absen_temp' => strtoupper($act)
      );
      $selesai=0;
      foreach($id_p as $ip):
        $this->Presensi_area_model->act_lock($ip,$set);

        // activity log
        $this->load->model('logs/Logs_model');
        $this->Logs_model->add(
          array(
            'log_date' => date('Y-m-d H:i:s'),
            'user_id' => $this->session->userdata('uid'),
            'log_module' => 'Presensi_area',
            'log_action' => 'LOCK/UNLOCK',
            'log_info' => 'ID:' . $ip . ';Action:' . strtoupper($act)
          )
        );

        $selesai+=1;
      endforeach;

      if($selesai > 0){
        $this->session->set_flashdata('success', ' Sunting Status Absen Temp Area Absensi Pegawai Berhasil');
        redirect('manage/presensi_area');
      }else{
        echo "<script>alert('Sunting Status Absen Temp Area Absensi Pegawai Gagal');location.href='".base_url()."manage/presensi_area'</script>";
      }
    }

    $data['presensi_area'] = $this->Presensi_area_model->get($params);
    $data['majors'] = $this->Student_model->get_majors();
    $data['position'] = $this->Position_model->get();

    $config['base_url'] = site_url('manage/presensi_area');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");

    $data['title'] = 'Area Presensi Pegawai';
    $data['main'] = 'presensi_area/presensi_area_list';
    $this->load->view('manage/layout', $data);
  }

  function searching_position(){
    $id_majors = $this->input->post('id_majors');
      $dataPosition  = $this->db->query("SELECT * FROM position WHERE position_majors_id = '$id_majors' ORDER BY position_name ASC")->result_array();
  
      echo '<select style="width: 200px;" id="p" name="p" class="form-control" required>
        <option value="">--- Pilih Jabatan ---</option>
        <option value="all" selected>Semua Jabatan</option>';
            foreach($dataPosition as $row){ 

              echo '<option value="'.$row['position_id'].'">';
                  
              echo $row['position_name'];
                  
              echo '</option>';
          
              }
      echo '</select>';
  }

  // Update
  public function add($id = NULL) {

    $this->load->library('form_validation');

    if (!$this->input->post('employee_id')) {
      $this->form_validation->set_rules('employee_nip', 'NIP', 'trim|required|xss_clean|is_unique[employee.employee_nip]');
    }
    // $this->form_validation->set_rules('area_absen', 'Area Absen', 'trim|required|xss_clean');
    $this->form_validation->set_rules('status_absen', 'Status Absen', 'trim|required|xss_clean');
    $this->form_validation->set_rules('jarak_radius', 'Jarak Radius Absen', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST AND $this->form_validation->run() == TRUE) {
 
      $id = $this->input->post('employee_id');
      $data=array(
        "area_absen" => implode(",",$this->input->post('area_absen')),
        "status_absen" => $this->input->post('status_absen'),
        "jarak_radius" => $this->input->post('jarak_radius')
      ); 
      $status = $this->Presensi_area_model->edit($id,$data);

    // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Presensi_area',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('employee_name')
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Area Absensi Pegawai Berhasil');
      redirect('manage/presensi_area');
    } else {
      if ($this->input->post('employee_id')) {
        redirect('manage/presensi_area/edit/' . $this->input->post('employee_id'));
      }

    // Edit mode
      if (!is_null($id)) {
        $object = $this->Presensi_area_model->get(array('id' => $id));
        if ($object == NULL) {
        } else {
          $data['presensi_area'] = $object;
        }
      }
      $data['setting_level'] = $this->Setting_model->get(array('id' => 7)); 
      $data['area_absen'] = $this->Presensi_area_model->get_area_absen();
      $data['title'] = $data['operation'] . ' Area Presensi Pegawai';
      $data['main'] = 'presensi_area/presensi_area_edit';
      $this->load->view('manage/layout', $data);
    }
  }

}