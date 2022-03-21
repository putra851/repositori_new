<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Banking extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    
    $this->load->model(array('payment/Payment_model', 'student/Student_model', 'banking/Banking_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'letter/Letter_model', 'logs/Logs_model', 'ltrx/Log_trx_model'));

  }
  
  function printBook() {
    $this->load->helper(array('dompdf'));
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;
    $siswa = null;
    $periodID = null;
    $siswaID = null;
    $params = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '' && $f['n'] != '0') {
      $params['period_id']      = $f['n'];
      $periodID                 = $f['n'];
    }

// Siswa
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis']    = $f['r'];
      $siswa = $this->Student_model->get(array('student_nis'=>$f['r']));
      $siswaID = $siswa['student_id'];
    }
    
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $date = $f['d'];
    }
    
    $data['siswa'] = $this->Student_model->get(array('student_id'=>$siswa['student_id'], 'group'=>TRUE));
    
    $data['period']     = $this->Period_model->get($params);
    if($f['n'] == '0'){
        $data['book']   = $this->db->query("SELECT banking_date as date, banking_note as note, banking_code as code, banking_debit AS debit, banking_kredit AS kredit, @saldo:=@saldo+banking_debit-banking_kredit AS saldo FROM banking JOIN (SELECT @saldo:=0) a WHERE banking_student_id = '$siswaID'")->result_array();
    }else{
        $data['book']   = $this->db->query("SELECT banking_date as date, banking_note as note, banking_code as code, banking_debit AS debit, banking_kredit AS kredit, @saldo:=@saldo+banking_debit-banking_kredit AS saldo FROM banking JOIN (SELECT @saldo:=0) a WHERE banking_student_id = '$siswaID' AND banking_period_id = '$periodID'")->result_array();
    }
    
    $data['unit']    = $this->Student_model->get_unit(array('status' => 1));
    $data['majors']  = $this->Student_model->get_majors();

    $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 

    $html = $this->load->view('banking/banking_book_pdf', $data, true);
    $data = pdf_create($html, $siswa['student_full_name'], TRUE, 'A4', TRUE);
  }

}