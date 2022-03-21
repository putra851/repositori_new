<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Visit extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    
    $this->load->model(array('student/Student_model', 'visit/Visit_model', 'period/Period_model', 'setting/Setting_model', 'logs/Logs_model'));

  }

  function printBook() {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $this->load->helper(array('terbilang'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;
    $siswa = null;
    $siswaID = null;
    $periodID = null;
    $params = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '' && $f['n'] != '0') {
      $params['period_id']  = $f['n'];
      $periodID             = $f['n'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis']    = $f['r'];
      $siswa = $this->Student_model->get(array('student_nis'=>$f['r']));
      $siswaID = $siswa['student_id'];
    }
    
    $data['siswa'] = $this->Student_model->get(array('period_id'=>$periodID, 'student_id'=>$siswaID, 'group'=>TRUE));
    
    $data['period']     = $this->Period_model->get($params);
    $data['visit']       = $this->Visit_model->get(array('period_id'=>$periodID, 'student_id'=>$siswaID));
    $data['visitSum']    = $this->Visit_model->get_sum(array('period_id'=>$periodID, 'student_id'=>$siswaID));
    
    $data['unit']    = $this->Student_model->get_unit(array('status' => 1));
    $data['majors']  = $this->Student_model->get_majors();
    // endtotal
    $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    //$tanggal = date_create($f['d']);
    //$dformat = date_format($tanggal,'dmYHis');
    //$this->barcode2('TAHFIDZ'.$siswa['student_nis'], '');
    $html = $this->load->view('visit/visit_cetak_pdf', $data, TRUE);
    $data = pdf_create($html, 'Buku_Kunjunagan_'.$siswa['student_full_name'].'_'.date('Y-m-d'), TRUE, 'A4', TRUE);
  }

}