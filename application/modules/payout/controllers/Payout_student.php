<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Payout_student extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    if ($this->session->userdata('logged_student') == NULL) {
      header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('payment/Payment_model', 'student/Student_model', 'payout/Payout_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'letter/Letter_model', 'logs/Logs_model', 'ltrx/Log_trx_model'));

  }


  public function index($offset = NULL) {
    $id = $this->session->userdata('uid_student');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $siswa['student_id']        = '';
    $siswa['student_nis']       = '';
    $siswa['student_full_name'] = '';
    $siswa['majors_short_name'] = '';
    $params                     = array();
    $param                      = array();
    $pay                        = array();
    $logs                       = array();
    $nis                        = NULL;
    $tahun                      = NULL;
    $like                       = NULL;

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id']  = $f['n'];
      $pay['period_id']     = $f['n'];
      $logs['period_id']    = $f['n'];
      $tahun                = $f['n'];
    }

// Siswa
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $logs['student_nis'] = $f['r'];
      $nis = $f['r'];
      $siswa = $this->Student_model->get_student(array('student_nis'=>$f['r']));

    }


    $params['group']    = TRUE;
    $pay['paymentt']    = TRUE;
    $param['status']    = 1;
    $pay['student_id']  = $siswa['student_id'];
    $logs['student_id'] = $siswa['student_id'];
    $like               = 'SP' . $siswa['majors_short_name'] . $siswa['student_nis'];


    $paramsPage = $params;
    $data['period']     = $this->Period_model->get($params);
    $data['siswa']      = $this->Student_model->get_student(array('student_id'=>$siswa['student_id'], 'group'=>TRUE));
    
    $data['kwitansi']   = $this->db->query("SELECT kas_id, kas_noref, kas_input_date, kas_debit FROM kas WHERE kas_noref LIKE '$like%' AND kas_period = '$tahun' ORDER BY kas_id DESC")->result_array();
    
    $data['pembayaran'] = $this->Bulan_model->get_pembayaran($tahun,$nis);
    $data['bebas']      = $this->Bebas_model->get($pay);
    $data['free']       = $this->Bebas_pay_model->get($params);
    $data['dom']        = $this->Bebas_pay_model->get($params);
    $data['bill']       = $this->Bulan_model->get_total($params);
    $data['in']         = $this->Bulan_model->get_total($param);
    $data['log']        = $this->Log_trx_model->get_history($logs);

    $data['total'] = 0;
    foreach ($data['bill'] as $key) {
      $data['total'] += $key['total'];
    }

    $data['pay'] = 0;
    foreach ($data['in'] as $row) {
      $data['pay'] += $row['bulan_bill'];
    }

    $data['pay_bill'] = 0;
    foreach ($data['dom'] as $row) {
      $data['pay_bill'] += $row['bebas_pay_bill'];
    }
    
    $config['base_url'] = site_url('student/payment/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Bulan_model->get($paramsPage));

    $data['student'] = $this->Student_model->get_student(array('id' => $id));
    $data['periodActive'] = $this->db->query("SELECT period_id FROM period WHERE period_status = '1'")->row_array();
    $data['title'] = 'Cek Pembayaran Siswa';
    $data['main'] = 'payout/payout_student_list';
    $this->load->view('student/layout', $data);
  }

  function cetakBukti() {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $this->load->helper(array('terbilang'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $siswa['student_id'] = '';
    $params = array();
    $param = array();
    $kas = array();
    $pay = array();
    $cashback = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      $cashback['period_id'] = $f['n'];
    }

// Siswa
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get_student(array('student_nis'=>$f['r']));

    }
    
    if (isset($f['f']) && !empty($f['f']) && $f['f'] != '') {
      $kas['date'] = $f['d'];
      $kas['noref'] = $f['f'];
      $param['noref'] = $f['f'];
      $cashback['noref'] = $f['f'];
    }

    $params['group']        =   TRUE;
    $pay['paymentt']        =   TRUE;
    $param['status']        =   1;
    $param['student_id']    =   $siswa['student_id'];
    $cashback['status']     =   1;
    $pay['student_id']      =   $siswa['student_id'];
    $cashback['student_id'] =   $siswa['student_id'];
    
    $data['majors']  = $this->Student_model->get_majors();
    $data['unit']    = $this->Student_model->get_unit(array('status' => 1));

    $data['period']  = $this->Period_model->get($params);
    $data['siswa']   = $this->Student_model->get_student(array('student_id'=>$siswa['student_id'], 'group'=>TRUE));
    $data['student'] = $this->Bulan_model->get($pay);
    $data['bulan']   = $this->Bulan_model->get($param);
    $data['bebas']   = $this->Bebas_model->get($pay);
    $data['free']    = $this->Bebas_pay_model->get($param);
    $data['s_bl']    = $this->Bulan_model->get_total($cashback);
    $data['s_bb']    = $this->Bebas_pay_model->get($cashback);
    $data['bcode']   = $this->Payout_model->get_bcode($kas);
    $bcode           = $this->Payout_model->get_bcode($kas);

    //total
    $data['summonth'] = 0;
    foreach ($data['s_bl'] as $row) {
      $data['summonth'] += $row['total'];
    }

    $data['sumbeb'] = 0;
    foreach ($data['s_bb'] as $row) {
      $data['sumbeb'] += $row['bebas_pay_bill'];
    }
    // endtotal
    $data['setting_nip_bendahara'] = $this->Setting_model->get(array('id' => 15));
    $data['setting_nama_bendahara'] = $this->Setting_model->get(array('id' => 16));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    $tanggal = date_create($f['d']);
    $dformat = date_format($tanggal,'dmYHis');
    
    $this->barcode2($bcode['kas_noref'], '');
    
    $data['huruf'] = number_to_words($data['summonth']+$data['sumbeb']);
    $html = $this->load->view('payout/payout_cetak_pdf', $data, TRUE);
    $data = pdf_create($html, 'Cetak_Struk_'.$siswa['student_full_name'].'_'.date('Y-m-d'), TRUE, 'A4', TRUE);
  }
  
  private function barcode2($sparepart_code, $barcode_type=39, $scale=6, $fontsize=1, $thickness=30,$dpi=72) {

  $this->load->library('upload');
  $config['upload_path'] = FCPATH . 'media/barcode_transaction/';

  /* create directory if not exist */
  if (!is_dir($config['upload_path'])) {
    mkdir($config['upload_path'], 0777, TRUE);
  }
  $this->upload->initialize($config);

    // CREATE BARCODE GENERATOR
    // Including all required classes
  require_once( APPPATH . 'libraries/barcodegen/BCGFontFile.php');
  require_once( APPPATH . 'libraries/barcodegen/BCGColor.php');
  require_once( APPPATH . 'libraries/barcodegen/BCGDrawing.php');

    // Including the barcode technology
    // Ini bisa diganti-ganti mau yang 39, ato 128, dll, liat di folder barcodegen
  require_once( APPPATH . 'libraries/barcodegen/BCGcode39.barcode.php');

    // Loading Font
    // kalo mau ganti font, jangan lupa tambahin dulu ke folder font, baru loadnya di sini
  $font = new BCGFontFile(APPPATH . 'libraries/font/Arial.ttf', $fontsize);

    // Text apa yang mau dijadiin barcode, biasanya kode produk
  $text = $sparepart_code;

    // The arguments are R, G, B for color.
  $color_black = new BCGColor(0, 0, 0);
  $color_white = new BCGColor(255, 255, 255);

  $drawException = null;
  try {
        $code = new BCGcode39(); // kalo pake yg code39, klo yg lain mesti disesuaikan
        $code->setScale($scale); // Resolution
        $code->setThickness($thickness); // Thickness
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->setFont($font); // Font (or 0)
        $code->parse($text); // Text
      } catch(Exception $exception) {
        $drawException = $exception;
      }

    /* Here is the list of the arguments
    1 - Filename (empty : display on screen)
    2 - Background color */
    $drawing = new BCGDrawing('', $color_white);
    if($drawException) {
      $drawing->drawException($drawException);
    } else {
      $drawing->setDPI($dpi);
      $drawing->setBarcode($code);
      $drawing->draw();
    }
    // ini cuma labeling dari sisi aplikasi saya, penamaan file menjadi png barcode.
    $filename_img_barcode = $sparepart_code .'_'.$barcode_type.'.png';
    // folder untuk menyimpan barcode
    $drawing->setFilename( FCPATH .'media/barcode_transaction/'. $sparepart_code.'.png');
    // proses penyimpanan barcode hasil generate
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

    return $filename_img_barcode;

  }
  
}